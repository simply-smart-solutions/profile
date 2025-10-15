<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    public function products(){
        return $this->belongsToMany(Product::class)
                    ->withPivot('product_quantity');
    }

    public function statusBadge($status){
        $html = '';
        if($this->status == 0){
            $html = '<span class="badge badge--warning">'.trans('Pending').'</span>';
        }
        elseif($this->status == 1){
            $html = '<span class="badge badge--success">'.trans('Approved').'</span>';
        }
       else{
            $html = '<span><span class="badge badge--danger">'.trans('Cancel').'</span></span>';
        }
        return $html;
    }
}
