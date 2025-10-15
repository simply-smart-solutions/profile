@extends($activeTemplate.'layouts.frontend')
@section('content')

@php
$min = 5;
$max = 10000;
@endphp
<!-- ========  Feature section ===== -->
<section class="shop-section  py-120 section-bg">
    <div class="container" >
        <div class="row justify-content-center pt-1 gy-4 card_wraper" id="card_wraper">
            <aside class="col-xl-3 col-lg-3 col-md-12">
                <div class="filter-form">
                    <div class="sidebar_body">
                        <div class="sidebar-wraper mb-4">
                            <div class="sidebar-header">
                                <div class="aside-search-box">
                                    <input class="form--input__field form--control mb-0" id="searchValue" name="search" type="text" placeholder="@lang('Search')">
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-wraper mb-4">
                            <div class="sidebar-categories">
                                <div class="script-item">
                                    <p class="mb-1">@lang('Categories')</p>
                                    @foreach($categories as $category)
                                        <div class="form-check custom--checkbox">
                                            <input class="form-check-input filter-by-category" name="categories" type="checkbox" value="{{$category->id}}" id="chekbox-{{$loop->index}}">
                                            <label class="form-check-label" for="chekbox-{{$loop->index}}">
                                                {{__($category->name)}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- <div class="sidebar-wraper mb-4">
                            <div class="range-slider-box">
                                <p class="pb-2 pt-1">@lang('Price Range')--({{$general->cur_sym}}<span
                                    id="minTxt">@lang('5')</span>-{{$general->cur_sym}}<span
                                    id="maxTxt">@lang('10000')</span>)
                                </p>

                                <div class="slider-box pb-2">
                                    <div class="range-slider">
                                        <div id="p_range"></div>
                                        <input type="hidden" name="min" id="min">
                                        <input type="hidden" name="max" id="max">
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </aside>
              <!-- card  -->
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 main-content">
                <div class="row gy-4 justify-content-center">
                    @forelse($products as $product)
                    <div class="col-xl-4 col-lg-6 col-md-6" >
                        <div class="card_body">
                            <div class="card-img">
                                <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}">
                                    <img src="{{ getImage(getFilePath('productThumbnail').'/'.@$product->thumbnail)}}" alt="product image">
                                </a>
                                {{-- @if(isset($product->discount))
                                <div class="product-badge bg--info">
                                    @if($product->is_free ==1)
                                    <p>@lang('Free')</p>
                                    @else
                                    <p>{{$product->discount}}%</p>
                                    @endif
                                </div>
                                @else
                                <div class="product-badge bg--base">
                                    <p>@lang('New')</p>
                                </div>
                                @endif --}}
                            </div>
                            <div class="content">
                                <div class="content-text">
                                    <p><a href="{{route('filter.category.products',$product->category->id)}}"> {{__($product->category->name)}} </a></p>
                                    <h5><a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}" target="_blank">
                                        @if(strlen(__($product->name)) >30)
                                        {{substr( __($product->name), 0,30).'...' }}
                                        @else
                                        {{__($product->name)}}
                                        @endif
                                    </a></h5>
                                </div>
                                {{-- <div class="card-meta">
                                    <div class="sale">
                                        <p class="amount"><i class="fas fa-bolt"></i> {{__($product->sale)}} @lang('sales')</p>
                                        <div class="review-wrapper">
                                            @php
                                            $averageRatingHtml = calculateAverageRating($product->average_rating);
                                            if (!empty($averageRatingHtml['ratingHtml'])) {
                                                echo $averageRatingHtml['ratingHtml'];
                                            }
                                        @endphp
                                        <p class="review-count">
                                            @if(empty($product->review_count && $product->average_rating ))
                                             @else
                                               ({{__( $product->review_count)}})
                                             @endif
                                        </p>
                                        </div>
                                    </div>
                                    <div class="btm">
                                        <div class="price">
                                            @if($product->is_free == 1)
                                            <h5 class="product-price">{{$general->cur_sym}} 00.00</h5>
                                            @else
                                            <h5 class="product-price">{{$general->cur_sym}} {{showAmount($product->price)}}</h5>
                                            @endif
                                        </div>
                                        <div class="cart">
                                            @if($product->is_free == 1)
                                            <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}" class="btn btn--base btn--sm outline"><i class="fas fa-cart-plus"></i> @lang('Free')</a>
                                            @else
                                            <a href="{{route('user.product.payment',$product->id)}}" class="btn btn--base btn--sm"><i class="fas fa-cart-plus"></i> @lang('Purchase')</a>
                                            @endif
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center">{{__($emptyMessage)}}</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="row mt-4">
            @if ($products->hasPages())
            <div class="col-md-12 d-flex justify-content-center">
                {{ paginateLinks($products) }}
            </div>
            @endif
        </div>

    </div>
</section>
<!-- ======== / Feature section ===== -->
@endsection

@push('script')
<script>

    (function ($) {
        "use strict";
        $("#p_range").slider({
            range: true,
            min: 0,
            max: 10000,
            values: [5, 10000],
            step: 1,
            slide: function (event, ui) {
                $("#min").val(ui.values[0]),
                $("#max").val(ui.values[1]);
                $("#minTxt").html(ui.values[0]),
                $("#maxTxt").html(ui.values[1]);
            },
            change:function(){
                    var min = $('input[name="min"]').val();
                    var max = $('input[name="max"]').val();

                    var categories   = [];
                    var searchValue = [];

                     getFilteredData(min,max,categories,searchValue)
                }
        });

        $("input[type='checkbox'][name='categories']").on('click', function(){
            var categories   = [];
            var searchValue = [];
            var min = [];
            var max = [];

                $('.filter-by-category:checked').each(function() {
                    if(!categories.includes(parseInt($(this).val()))){
                        categories.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(min,max,categories,searchValue)
        });

        $("#searchValue").on('keyup', function () {
            var categories   = [];
            var searchValue = [];
            var min = [];
            var max = [];

            var searchValue = $(this).val();
            getFilteredData(min,max,categories,searchValue)
        });

        function getFilteredData(min,max,categories,searchValue){

            $.ajax({
                type: "get",
                url: "{{ route('product.filtered') }}",
                data:{
                    "min":min,
                    "max":max,
                    "categories": categories,
                    "search": searchValue,
                },
                dataType: "json",
                success: function (response) {
                    if(response.html){
                        $('.main-content').html(response.html);
                    }

                    if(response.error){
                        notify('error', response.error);
                    }
                }
            });
        }

    })(jQuery);

</script>
@endpush
