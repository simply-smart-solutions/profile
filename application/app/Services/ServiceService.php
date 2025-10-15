<?php

namespace App\Services;

use App\Models\Service;
use App\Models\Category;

class ServiceService
{
    public function index()
    {

        return Service::with('category')
        ->orderBy('id', 'desc')
        ->paginate(getPaginate(20));

    }

    public function create(){
        return Category::where('status',1)->get();
    }

    public function storeService($data,$user=null)
    {
        $isRestricted = gs()->is_restricted;

        $purifier = new \HTMLPurifier();
        $service = new Service();
        $service->category_id = $data->category_id;
        $service->name = $data->name;
        $service->description = $purifier->purify($data->description);

        $service->status = 1;
        
        if ($data->hasFile('image')) {
            if ($data->file('image')->isValid()) {
                try {
                    $oldPath = getFilePath('serviceImage').'/'.$service->image;
                    fileManager()->removeFile($oldPath);
                    $filePath = fileUploader($data->file('image'), getFilePath('serviceImage') , getFileSize('serviceImage'));
                    $service->image = $filePath;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your file'];
                    return back()->withNotify($notify);
                }
            }
        }


        if ($service->save()) {

            return $service;
        } else {
            return null;
        }
    }

    public function edit($id){
        return  Service::with(['category'])->findOrFail($id);
    }

    public function deleteService($serviceId){

        $service  = Service::findOrFail($serviceId);


        $thumbPath = getFilePath('serviceImage') . '/' . $service->image;
        fileManager()->removeFile($thumbPath);

        if ( $service->delete()) {
            return $service;
        } else {
            return null;
        }

    }

    public function updateService($data, $user = null)
    {


        $purifier = new \HTMLPurifier();

        $service = Service::findOrFail($data->id);
        $service->category_id = $data->category_id;
        $service->name = $data->name;
        $service->description = $purifier->purify($data->description);
        
        $service->status = $data->status ? 1: 0;

        if ($data->hasFile('image')) {
            if ($data->file('image')->isValid()) {
                try {
                    $oldPath = getFilePath('serviceImage').'/'.$service->image;
                    fileManager()->removeFile($oldPath);
                    $filePath = fileUploader($data->file('image'), getFilePath('serviceImage') , getFileSize('serviceImage'));
                    $service->image = $filePath;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your file'];
                    return back()->withNotify($notify);
                }
            }
        }

        if ($service->save()) {
            return $service;
        } else {
            return null;
        }
    }




}
