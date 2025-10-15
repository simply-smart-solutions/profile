@extends($activeTemplate.'layouts.master')
@section('content')

<!-- ==================== Card Start Here ==================== -->
<div class="col-xl-9 col-lg-12">
    <div class="dashboard-body account-form">
        <div class="dashboard-body__bar">
            <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
        </div>
        <div class="row gy-4 justify-content-center">
            <h4>{{__($pageTitle)}}</h4>
                <div class="card-wrap pb-30">
                    <table class="table table--responsive--lg">
                        <thead>
                            <tr>
                                <th>@lang('Product Image')</th>
                                <th>@lang('Product Name')</th>
                                @if($order->status == 1)
                                <th>@lang('File Download')</th>
                                @endif
                                <th>@lang('Quantity')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Total Amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <h5>@lang('Order No:') # {{__($order->order_number)}}</h5>
                            @foreach($order->products as $item)
                            <tr class="cart-row">
                               <td data-label="Product Image">
                                 <a href="{{ route('product.details', ['slug' => slug($item->name), 'id' => $item->id])}}" target="_blank">
                                   <img src="{{ getImage(getFilePath('productImage').'/'.@$item->productImages[0]->image)}}" alt="Image" class="rounded" style="width:50px;">
                               </a>
                           </td>
                               <td data-label="Product Name">
                                   <a href="{{ route('product.details', ['slug' => slug($item->name), 'id' => $item->id])}}" target="_blank">
                                       {{__($item->name)}}
                                   </a>
                               </td>
                               @if($order->status == 1)
                               <td data-label="File Download"><a class="btn btn--base" href="{{ route('user.product.file.download', ['id' => $item->id, 'orderId' => $order->id]) }}" title="File Download"><i class="fas fa-download"></i> @lang('File')</a></td>
                               @endif
                               <td data-label="Quantity">{{__($item->pivot->product_quantity)}} x {{ showAmount(__($item->price)- ($item->price * $item->discount/100 )) }}</td>
                               <td data-label="Status">@php echo $order->statusBadge($item->status) @endphp</td>
                               <td data-label="Total Amount">
                               <span class="badge badge--base">
                                   @if($item->discount !=0)
                                   {{__($general->cur_sym)}}{{ showAmount(__($item->price)- ($item->price * $item->discount/100 )) }}
                                   @else
                                   {{__($general->cur_sym)}} {{__($item->price * $item->pivot->product_quantity)}}
                                   @endif
                               </span>
                           </td>
                           </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Card End Here ==================== -->
@endsection

