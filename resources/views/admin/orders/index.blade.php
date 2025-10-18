
@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th>@lang('Full Name')</th>
                                <th>@lang('Order Number')</th>
                                <th>@lang('Order Date')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                           <tr>
                            <td>{{__($order->firstname.$order->lastname)}}</td>
                            <td>#{{__($order->order_number)}}</td>
                            <td>{{ showDateTime($order->created_at)}}</td>
                            <td>{{__($general->cur_sym)}}{{__($order->product_price)}}</td>
                            <td>@php echo $order->statusBadge($order->status) @endphp</td>
                            <td>
                                <a href="{{route('admin.orders.details',$order->id)}}" class="btn btn-sm btn--primary ms-1">
                                    <i class="la la-eye"></i>
                                </a>
                            </td>
                         </tr>
                         @empty
                         <tr>
                           <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                        </tr>
                         @endforelse
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($orders->hasPages())
            <div class="card-footer py-4">
             @php echo paginateLinks($orders) @endphp
         </div>
         @endif
        </div><!-- card end -->
    </div>
</div>
@endsection


