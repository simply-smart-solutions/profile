{{-- @php
$discountShop = getContent('discount_shop.content',true);
$discountProducts = App\Models\Product::where('status',1)
->with(['productImages','category'])
->where('discount', '>', 0)
->latest()
->limit(8)
->get();
@endphp
<!-- ========  new item section ===== -->
<section class="new-section pt-120" id="discount">
    <div class="container" >
        <div class="row justify-content-left text-left">
            <div class="col-xl-7 col-lg-8 hero-content">
                <h2>{{__($discountShop->data_values->heading)}}</h2>
            </div>
        </div>
        <div class="row justify-content-center pt-5 gy-4 new-product-card_wraper">
              <!-- card  -->
            @foreach($discountProducts as $product)
                <div class="col-md-4 col-sm-6" >
                    <div class="product-container align-items-center">
                        <div class="thumb">
                            <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}">
                                <img src="{{ getImage(getFilePath('productThumbnail').'/'.@$product->thumbnail)}}" alt="product Image">
                            </a>
                        </div>
                        <div class="product-card-body">
                            <div class="card-text_content">
                                <h6 class="product-title">
                                    <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}" title="{{$product->name}}">
                                        @if(strlen(__($product->name)) >10)
                                            {{substr( __($product->name), 0, 28).'...' }}
                                        @else
                                            {{__($product->name)}}
                                        @endif
                                    </a>
                                </h6>
                                @php
                                    $averageRatingHtml = calculateAverageRating($product->average_rating);
                                    if (!empty($averageRatingHtml['ratingHtml'])) {
                                        echo $averageRatingHtml['ratingHtml'];
                                    }
                                @endphp
                            </div>
                            <div class="product-meta">
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- / product card  -->
            <div class="pt-4 text-center">
                <a href="{{route('browse')}}" class="btn btn--base ">@lang('View More')</a>
            </div>
        </div>
    </div>
</section>
<!-- ======== / new item section ===== --> --}}

<!-- ========  new item section ===== -->
<section class="new-section pt-120" id="discount">
    <div class="container" >
        <div class="row justify-content-left text-left">
            <div class="col-xl-7 col-lg-8 hero-content">
                <h2>Our Teams</h2>
            </div>
        </div>
        <div class="row justify-content-center pt-5 gy-4 new-product-card_wraper">
              <!-- card  -->
            @foreach([1, 2, 3] as $item)
                <div class="col-md-4 col-sm-6" >
                    <div class="product-container align-items-center">
                        <div class="thumb">
                            <a href="#">
                                <img src="" alt="profile">
                            </a>
                        </div>
                        <div class="product-card-body">
                            <div class="card-text_content">
                                <h6 class="product-title">
                                    <a href="">
                                        
                                    </a>
                                </h6>
                            </div>
                            <div class="product-meta">
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- / product card  -->
            <div class="pt-4 text-center">
                <a href="{{route('our_teams')}}" class="btn btn--base ">@lang('View More')</a>
            </div>
        </div>
    </div>
</section>
<!-- ======== / new item section ===== -->

