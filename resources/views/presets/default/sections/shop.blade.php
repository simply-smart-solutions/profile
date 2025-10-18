@php
 $shop = getContent('shop.content',true);
 $products = App\Models\Product::with(['productImages', 'category'])
    ->where('status', 1)
    ->latest()
    ->limit(8)
    ->get();
@endphp

<!-- ========  Feature section ===== -->
<section class="feature-section py-120 section-bg">
    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 text-center hero-content">
                <h2 class="pb-40">{{__($shop->data_values->heading)}}</h2>
                <p class="pb-80">{{__($shop->data_values->sub_heading)}} </p>
            </div>
        </div>
        <div class="row justify-content-center pt-1 gy-5 card_wraper" id="card_wraper">
              <!-- card  -->
            @foreach($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6" >
                    <div class="card_body">
                        <div class="card-img">
                            <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}">
                                <img src="{{ getImage(getFilePath('productThumbnail').'/'.@$product->thumbnail)}}" alt="product image">
                            </a>
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
                        </div>
                    </div>
                </div>
            @endforeach
                <!-- / card  -->
            <div class="mt-5 text-center">
                <a href="{{route('browse')}}" class="btn btn--base">@lang('View More')</a>
            </div>
        </div>

    </div>
</section>
<!-- ======== / Feature section ===== -->
