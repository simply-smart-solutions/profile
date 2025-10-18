@extends($activeTemplate.'layouts.master')
@section('content')
<div class="col-xl-9 col-lg-12">
    <div class="dashboard-body">
        <div class="dashboard-body__bar">
            <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
        </div>
        <div class="row gy-4">
            <div class="col-xl-4 col-lg-6 col-sm-6">
                <a class="d-block" href="{{route('user.orders')}}">
                    <div class="dashboard-card">
                        <span class="banner-effect-1"></span>
                        <div class="dashboard-card__icon">
                            <i class="fas fa-cart-plus"></i>
                        </div>
                        <div class="dashboard-card__content">
                            <h5 class="dashboard-card__title">@lang('My Orders')</h5>
                            <h4 class="dashboard-card__amount">{{__($ordersCount)}}</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6 col-sm-6">
                <div class="dashboard-card">
                    <span class="banner-effect-1"></span>
                    <div class="dashboard-card__icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <div class="dashboard-card__content">
                        <h5 class="dashboard-card__title">@lang('Balance')</h5>
                        <h4 class="dashboard-card__amount">{{__($general->cur_sym)}} {{showAmount($userBalace)}}</h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-sm-6">
                <a class="d-block" href="{{route('user.product.index')}}">
                    <div class="dashboard-card">
                        <span class="banner-effect-1"></span>
                        <div class="dashboard-card__icon">
                            <i class="fab fa-product-hunt"></i>
                        </div>
                        <div class="dashboard-card__content">
                            <h5 class="dashboard-card__title">@lang('My Products')</h5>
                            <h4 class="dashboard-card__amount">{{__($productCount)}}</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

