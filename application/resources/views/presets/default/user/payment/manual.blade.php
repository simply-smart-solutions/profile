@extends($activeTemplate.'layouts.master')

@section('content')
<div class="col-xl-9 col-lg-12">
    <div class="dashboard-body account-form">
        <div class="dashboard-body__bar">
            <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
        </div>
        <div class="row gy-4 justify-content-center">
            <h3 class="contact__title">{{$pageTitle}}</h3>

         <form action="{{ route('user.deposit.manual.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="text-center mt-2">@lang('You have requested') <b class="text-success">{{ showAmount($data['amount'])  }} {{__($general->cur_text)}}</b> , @lang('Please pay')
                            <b class="text-success">{{showAmount($data['final_amo']) .' '.$data['method_currency'] }} </b> @lang('for successful payment')
                        </p>
                        <h4 class="text-center mb-4">@lang('Please follow the instruction below')</h4>

                        <p class="my-4 text-center">@php echo  $data->gateway->description @endphp</p>

                    </div>

                    <x-custom-form identifier="id" identifierValue="{{ $gateway->form_id }}"></x-custom-form>

                    <div class="col-md-12 mt-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn--base">@lang('Pay Now')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
