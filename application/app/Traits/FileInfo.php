<?php

namespace App\Traits;

trait FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This trait basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo(){
        $data['withdrawVerify'] = [
            'path'=>'assets/images/verify/withdraw'
        ];
        $data['depositVerify'] = [
            'path'      =>'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path'      =>'assets/verify'
        ];
        $data['default'] = [
            'path'      => 'assets/images/general/default.png',
        ];
        $data['withdrawMethod'] = [
            'path'      => 'assets/images/withdraw/method',
            'size'      => '800x800',
        ];
        $data['ticket'] = [
            'path'      => 'assets/support',
        ];
        $data['logoIcon'] = [
            'path'      => 'assets/images/general',
        ];
        $data['favicon'] = [
            'size'      => '128x128',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/plugins',
            'size'      => '36x36',
        ];
        $data['seo'] = [
            'path'      => 'assets/images/seo',
            'size'      => '1180x600',
        ];
        $data['userProfile'] = [
            'path'      =>'assets/images/user/profile',
            'size'      =>'350x300',
        ];
        $data['adminProfile'] = [
            'path'      =>'assets/admin/images/profile',
            'size'      =>'400x400',
        ];
        $data['productImage'] = [
            'path'      =>'assets/images/frontend/productImage',
            'size'      =>'894x661',
        ];
        $data['serviceImage'] = [
            'path'      =>'assets/images/frontend/serviceImage',
            'size'      =>'894x661',
        ];
        $data['productFile'] = [
            'path'      =>'assets/images/frontend/productFile',
        ];
        $data['productThumbnail'] = [
            'path'      =>'assets/images/frontend/productThumbnail',
            'size'      =>'500x370',
        ];
        $data['blog'] = [
            'path'      =>'assets/images/frontend/blog',
        ];
        $data['about'] = [
            'path'      =>'assets/images/frontend/about',
        ];

        return $data;
	}

}
