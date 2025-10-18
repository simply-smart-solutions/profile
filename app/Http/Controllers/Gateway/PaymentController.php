<?php

namespace App\Http\Controllers\Gateway;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Deposit;
use App\Models\Product;
use App\Lib\FormProcessor;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\GatewayCurrency;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{


     // product payment
     public function productPayment($id){

        $product = Product::findOrFail($id);
        $owner = $product->user;
        $user = auth()->user();

        if (@$owner->id == $user->id) {
            $notify[] = ['error', 'You cannot buy your own product'];
            return back()->withNotify($notify);
        }

        if($product->is_free == 1){

            $user = auth()->user();
            $totalAmount = 0;
            $quantity = 1;

            // order table data insert
            $order = new Order();
            $order->user_id = $user->id ;
            $order->order_number = Str::random(4).now()->format('dmY');
            $order->quantity = $quantity;
            $order->product_price = $totalAmount;
            $order->firstname = $user->firstname;
            $order->lastname = $user->lastname;
            $order->email =  $user->email;
            $order->phone =  $user->mobile;
            $order->country = $user->address->country;
            $order->address = $user->address->address;
            $order->status = 1;
            $order->save();

            // data insert into pivot table
            $order->products()->attach($product['id'],['product_quantity'=>$quantity]);

            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $order->user_id;
            $adminNotification->title = 'Order place from '.$order->firstname.$order->lastname;
            $adminNotification->click_url = urlPath('admin.orders.details',$order->id);
            $adminNotification->save();


            notify($user, 'ORDER PLACE', [
                'order_number'=>$order->order_number,
                'amount' => showAmount($order->product_price),
                'trx' => $user->trx,
                'post_balance' => showAmount($user->balance)
            ]);

            $notify[] = ['success', 'Order place has been successfully'];
            return to_route('home')->withNotify($notify);

        }

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';

        return view($this->activeTemplate .'user.payment.product_payment', compact('gatewayCurrency', 'pageTitle','product'));

    }

    // productPlace
    public function productPlace(Request $request){
        if($request->gateway == 'balance'){

            $totalAmount = $request->amount;
            $product = Product::find($request->product_id);

            // check balance
            $user = auth()->user();
            if($user->balance < $totalAmount){
                $notify[] = ['error', 'Insufficient Balance'];
                return back()->withNotify($notify);
            }

            $quantity = 1;
            // order table data insert
            $order = new Order();
            $order->user_id = $user->id ;
            $order->order_number = Str::random(4).now()->format('dmY');
            $order->quantity = $quantity;
            $order->product_price = $totalAmount;
            $order->firstname = $user->firstname;
            $order->lastname = $user->lastname;
            $order->email =  $user->email;
            $order->phone =  $user->mobile;
            $order->country = $user->address->country;
            $order->address = $user->address->address;
            $order->status = 1;
            $order->save();

            $product->sale += 1;
            $product->save();

            // data insert into pivot table
            $order->products()->attach($product['id'],['product_quantity'=>$quantity]);

            // added owner user
            $owner = $product->user;
            if(isset($owner)){
            $owner->balance += $order->product_price;
            $owner->save();
            }

            // less buyer user balance
            $user->balance -= $order->product_price;
            $user->save();

            $trx = getTrx();

            $transaction                =   new Transaction();
            $transaction->user_id       =   auth()->user()->id;
            $transaction->amount        =   $order->product_price;
            $transaction->post_balance  =   $user->balance;
            $transaction->charge        =   0;
            $transaction->trx_type      =   '-';
            $transaction->details       =   'Order Place';
            $transaction->trx           =   $trx;
            $transaction->remark        =   'Order Place';
            $transaction->save();

            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $order->user_id;
            $adminNotification->title = 'Order place from '.$order->firstname.$order->lastname;
            $adminNotification->click_url = urlPath('admin.orders.details',$order->id);
            $adminNotification->save();


            notify($user, 'ORDER PLACE', [
                'order_number'=>$order->order_number,
                'amount' => showAmount($order->product_price),
                'trx' => $user->trx,
                'post_balance' => showAmount($user->balance)
            ]);

            $notify[] = ['success', 'Order place has been successfully'];
            return to_route('home')->withNotify($notify);
        }

        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);


        $totalAmount = $request->amount;
        $product = Product::find($request->product_id);
        $user = auth()->user();

        $quantity = 1;
        // order table data insert
        $order = new Order();
        $order->user_id = $user->id ;
        $order->order_number = Str::random(4).now()->format('dmY');
        $order->quantity = $quantity;
        $order->product_price = $totalAmount;
        $order->firstname = $user->firstname;
        $order->lastname = $user->lastname;
        $order->email =  $user->email;
        $order->phone =  $user->mobile;
        $order->country = $user->address->country;
        $order->address = $user->address->address;
        $order->status = 0;
        $order->save();

        // data insert into pivot table
        $order->products()->attach($product['id'],['product_quantity'=>$quantity]);

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $order->user_id ;
        $adminNotification->title ='Order request from '.$order->firstname.$order->lastname;
        $adminNotification->click_url = urlPath('admin.orders.details',$order->id);
        $adminNotification->save();

        notify($user, 'ORDER REQUEST', [
            'order_number'=>$order->order_number,
            'amount' => showAmount($order->product_price),
            'trx' => $user->trx,
            'post_balance' => showAmount($user->balance)
        ]);


        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
        $payable = $request->amount + $charge;
        $final_amo = $payable * $gate->rate;

        $data = new Deposit();
        $data->user_id = $user->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount =  $totalAmount;
        $data->order_id = $order->id;
        $data->product_id = $product->id;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->save();
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');

    }

    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Deposit Methods';
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle'));
    }

    public function depositInsert(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);


        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
        $payable = $request->amount + $charge;
        $final_amo = $payable * $gate->rate;

        $data = new Deposit();
        $data->user_id = $user->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $request->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->save();
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }


    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            return "Sorry, invalid URL.";
        }
        $data = Deposit::where('id', $id)->where('status', 0)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }


    public function depositConfirm()
    {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status',0)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return to_route('user.deposit.manual.confirm');
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if(@$data->session){
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }


    public static function userDataUpdate($deposit,$isManual = null)
    {
        if ($deposit->status == 0 || $deposit->status == 2) {
            $deposit->status = 1;
            $deposit->save();

            $user = User::find($deposit->user_id);

            if (!isset($deposit->order_id)) {
                    $user->balance += $deposit->amount;
                    $user->save();
            }

            if(isset($deposit->order_id)){

                $product = Product::findOrFail($deposit->product_id);

                $order = Order::findOrFail($deposit->order_id);
                $order->status = 1;
                $order->save();

                $product->sale += 1;
                $product->save();

                // added owner user
                $owner = $product->user;
                if(isset($owner)){
                $owner->balance += $order->product_price;
                $owner->save();
                }

                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $deposit->user_id ;
                $adminNotification->title = 'Order place from '.$user->firstname.$user->lastname;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();

                notify($user, 'ORDER PLACE', [
                    'order_number'=>$order->order_number,
                    'amount' => showAmount($order->product_price),
                    'trx' => $user->trx,
                    'post_balance' => showAmount($user->balance)
                ]);
            }

            $transaction = new Transaction();
            $transaction->user_id = $deposit->user_id;
            $transaction->amount = $deposit->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = $deposit->charge;
            $transaction->trx_type = '+';
            $transaction->details = 'Deposit Via ' . $deposit->gatewayCurrency()->name;
            $transaction->trx = $deposit->trx;
            $transaction->remark = 'deposit';
            $transaction->save();

            if (!$isManual) {
                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'Deposit successful via '.$deposit->gatewayCurrency()->name;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();
            }

            notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                'method_name' => $deposit->gatewayCurrency()->name,
                'method_currency' => $deposit->method_currency,
                'method_amount' => showAmount($deposit->final_amo),
                'amount' => showAmount($deposit->amount),
                'charge' => showAmount($deposit->charge),
                'rate' => showAmount($deposit->rate),
                'trx' => $deposit->trx,
                'post_balance' => showAmount($user->balance)
            ]);


        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $pageTitle = 'Deposit Confirm';
            $method = $data->gatewayCurrency();
            $gateway = $method->method;
            return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method','gateway'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        $gatewayCurrency = $data->gatewayCurrency();
        $gateway = $gatewayCurrency->method;
        $formData = $gateway->form->form_data;

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);


        $data->detail = $userData;
        $data->status = 2; // pending
        $data->save();


        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $data->user->id;
        $adminNotification->title = 'Deposit request from '.$data->user->username;
        $adminNotification->click_url = urlPath('admin.deposit.details',$data->id);
        $adminNotification->save();

        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name' => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount' => showAmount($data->final_amo),
            'amount' => showAmount($data->amount),
            'charge' => showAmount($data->charge),
            'rate' => showAmount($data->rate),
            'trx' => $data->trx
        ]);

        $notify[] = ['success', 'Your request has been taken'];
        return to_route('user.deposit.history')->withNotify($notify);
    }


}
