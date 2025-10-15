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
                                <th>@lang('Order Date')</th>
                                <th>@lang('Order Number')</th>
                                <th>@lang('Product Name')</th>
                                <th>@lang('File Downlaod')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Status')</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)

                            <tr>
                                <td data-label="Order Date">{{ showDateTime($order->created_at)}}</td>
                                <td data-label="Order Number" class="fw-bold">#{{__($order->order_number)}}</td>
                                @foreach (@$order->products as $item)
                                <td data-label="Order Number" class="fw-bold">{{__($item->name)}}</td>
                                <td data-label="File Download">
                                @if($order->status == 1)
                                    <a class="btn btn--base btn--sm" href="{{ route('user.product.file.download', ['id' => $item->id, 'orderId' => $order->id]) }}" title="File Download"><i class="fas fa-download"></i> @lang('File')</a>
                                @else
                                <span class="badge badge--warning">@lang('Pending')</span>
                                @endif

                                </td>

                                @endforeach
                                <td data-label="Amount">{{__($general->cur_sym)}} {{showAmount(__($order->product_price))}} </td>
                                <td data-label="Status">@php echo $order->statusBadge($order->status) @endphp </td>

                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%" data-label="Order Table">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            @if ($orders->hasPages())
            <div class="d-flex justify-content-end">
                {{ paginateLinks($orders) }}
            </div>
            @endif
        </div>
    </div>
</section>
<!-- ==================== Card End Here ==================== -->
@endsection

