<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Services\ServiceService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use function Ramsey\Uuid\v1;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService){
        $this->serviceService = $serviceService;
    }

    public function index(){

        $pageTitle = 'All Services';
        $services = $this->serviceService->index();
        return view('admin.services.index', compact('services','pageTitle'));
    }

    public function create (){
        $pageTitle ='Add Service';
        $categories = $this->serviceService->create();
        return view('admin.services.create',compact('pageTitle','categories'));
    }

     public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category_id' => 'required',
            'image' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        // field validation
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request;
        $service = $this->serviceService->storeService($data);

        if ($service) {
            return response()->json([
                'message' => 'Service has been created successfully',
                'service' => $service,
            ]);
        } else {
            return response()->json([
                'message' => 'Service could not be created. Please try again later.',
            ], 500);
        }
    }

    public function edit($id){
        $pageTitle= 'Update';
        $categories = Category::where('status',1)->get();
        $service = $this->serviceService->edit($id);
        return view('admin.services.edit',compact('pageTitle','categories','service'));

    }


    public function update(Request $request){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'price' => 'required',
                'discount' => 'nullable|numeric|between:0,99.99',
                'category_id' => 'required',
                'thumbnail' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
                'images.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
                'file.*' => ['required', 'file', new FileTypeValidate(['zip', 'rar'])],
            ]);

            // field validation
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request;
            $service = $this->serviceService->updateService($data);

            if ($service) {
                return response()->json([
                    'message' => 'Service has been updated successfully',
                    'Service' => $service,
                ]);
            } else {
                return response()->json([
                    'message' => 'Service could not be updated. Please try again later.',
                ], 500);
            }
    }


    public function imageRemove(Request $request){

        $request->validate([
            'id' => 'required'
        ]);

        $data = $request;
        $imageRemove = $this->serviceService->imageRemove($data);

        if ($imageRemove) {

            $notify[] = ['success','Service Image has been deleted'];
            return back()->withNotify($notify);

        } else {
            $notify[] = ['error','Service Image can not deleted. Please try again later.'];
            return back()->withNotify($notify);
            }
    }

    public function delete(Request $request)
    {
        $ServiceId = $request->id;
        $Service = $this->serviceService->deleteService($ServiceId);

        if ($Service) {

            $notify[] = ['success', 'Service and related images have been deleted successfully'];
            return back()->withNotify($notify);

        } else {
            $notify[] = ['error','Service can not deleted. Please try again later.'];
            return back()->withNotify($notify);
            }

    }

    public function pendingService(){
        $pageTitle = 'Pending Services';
        $pendingServices = Service::with(['category', 'ServiceImages','user'])
            ->where('status',0)
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(20));

            return view('admin.services.pendings',compact('pendingServices','pageTitle'));

    }

    public function approveService(){
        $pageTitle = 'Approve Services';
        $approveServices = Service::with(['category', 'ServiceImages','user'])
            ->where('status',1)
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(20));

            return view('admin.services.approves',compact('approveServices','pageTitle'));

    }

    public function approveSingleService($id){
        $Service =  Service::findOrFail($id);
        $Service->status = 1;
        $Service->save();
        $notify[] = ['success', 'Service approved successfully.'];
        return back()->withNotify($notify);

    }

    public function rejectSingleService($id){
        $Service =  Service::findOrFail($id);
        $Service->status = 0;
        $Service->save();
        $notify[] = ['success', 'Service reject successfully.'];
        return back()->withNotify($notify);

    }

}
