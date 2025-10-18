@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <!-- ==================== Product Details Here ==================== -->
    <section class="product-details-area py-80">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-8">
                    <div class="product-details-left">
                        <div class="product-details-left__content">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                    aria-labelledby="home-tab" tabindex="0">
                                    <div class="product-details-left__thumb" style="background-image: url({{ getImage(getFilePath('serviceImage') . '/' . @$service->image) }});">
                                    </div>
                                </div>
                            </div>
                            <div class="info">

                                <div class="tab-content mt-3" id="myTabContent">
                                    @if (!empty($serviceImages) && is_array($serviceImages))
                                        @foreach ($serviceImages as $index => $serviceImage)
                                            <div class="tab-pane fade{{ $index === 0 ? ' show active' : '' }}"
                                                id="image-tab-{{ $index }}" role="tabpanel"
                                                aria-labelledby="image-tab-{{ $index }}" tabindex="0">
                                                <div class="product-details-left__thumb">
                                                    <a class="image-popup"
                                                        href="{{ getImage(getFilePath('productImage') . '/' . @$serviceImage) }}">
                                                        <span>@lang('Screenshots')<i class="fas fa-expand"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="row py-4">
                            <div class="product-info">
                                <div class="product-title">
                                    <h3>{{ __($service->name) }}</h3>
                                    <ul class="social-list">
                                        <li class="social-list__item"><a href="<?php echo getProductShareLinks($service->id)['facebook']; ?>"
                                                class="social-list__link" target="_blank"><i
                                                    class="fab fa-facebook-f"></i></a> </li>
                                        <li class="social-list__item"><a href="<?php echo getProductShareLinks($service->id)['twitter']; ?>"
                                                class="social-list__link" target="_blank"> <i
                                                    class="fab fa-twitter"></i></a></li>
                                        <li class="social-list__item"><a href="<?php echo getProductShareLinks($service->id)['linkedin']; ?>"
                                                class="social-list__link" target="_blank"> <i
                                                    class="fab fa-linkedin-in"></i></a></li>
                                        <li class="social-list__item"><a href="<?php echo getProductShareLinks($service->id)['instagram']; ?>"
                                                class="social-list__link" target="_blank"> <i
                                                    class="fab fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                                <div class="tag-rating-sales-wrap">
                                    <p class="cate-title">{{ __(@$service->category->name) }}</p>
                                    <div class="ratings-box me-3">
                                        <div class="review-wrapper">
                                            @php
                                                $averageRatingHtml = calculateAverageRating($service->average_rating);
                                                if (!empty($averageRatingHtml['ratingHtml'])) {
                                                    echo $averageRatingHtml['ratingHtml'];
                                                }
                                            @endphp
                                        </div>
                                    </div>
                                    {{-- <div class="price">
                                        <h5 class="product-price"> <i class="fas fa-shopping-cart"></i>
                                            {{ getTotalSales($service->id) }} @lang('sales')</h5>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row gy-4 justify-content-center">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs coustome-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                        type="button" role="tab" aria-controls="home" aria-selected="false"
                                        tabindex="-1">
                                        @lang('Description')
                                    </a>
                                </li>

                                {{-- <li class="nav-item" role="presentation">
                                    <a class="nav-link " id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                        type="button" role="tab" aria-controls="contact" aria-selected="false"
                                        tabindex="-1">
                                        @lang('Reviews')
                                    </a>
                                </li> --}}
                            </ul>
                            <div class="tab-content pt-4" id="myTabContent">

                                <div class="tab-pane fade active show" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <div class="row gy-4 justify-content-center">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="about-right-content">
                                                <div class="section-heading mb-0 wyg">
                                                    <p class="section-heading__desc mb-4 wyg">
                                                        @php echo $service->description; @endphp
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="row gy-4 justify-content-center">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="tab-review-wrap">
                                                <ul class="comment-list">
                                                    {{-- @forelse($reviews as $item)
                                                        <li class="comment-list__item d-flex flex-wrap">
                                                            <div class="comment-list__thumb">
                                                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$item->user->image) }}"
                                                                    alt="image">
                                                            </div>
                                                            <div class="comment-list__content">
                                                                <h4 class="comment-list__name">{{ $item->user->username }}
                                                                </h4>
                                                                <div
                                                                    class="time-rating-warper d-flex justify-content-between">
                                                                    <span class="comment-list__time"> <span
                                                                            class="comment-list__time-icon"><i
                                                                                class="far fa-clock"></i></span>
                                                                        {{ diffForHumans($item->created_at) }} </span>
                                                                    <ul class="rating-list mb-2">
                                                                        @php
                                                                            $averageRatingHtml = calculateAverageRating($service->average_rating);
                                                                            if (!empty($averageRatingHtml['ratingHtml'])) {
                                                                                echo $averageRatingHtml['ratingHtml'];
                                                                            }
                                                                        @endphp
                                                                    </ul>
                                                                </div>
                                                                <p class="comment-list__desc">{{ __($item->message) }}</p>
                                                                <div class="comment-list__reply">
                                                                    <a class="comment-list__reply-text"
                                                                        href="javascript:void(0)"><span
                                                                            class="comment-list__reply-icon"></span></a>
                                                                    <span>{{ showDateTime($item->created_at) }}</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @empty
                                                        <p>@lang('No Reviews')</p>
                                                    @endforelse --}}
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Product Details End ==================== -->

    <!-- ==================== Our Products Start Here ==================== -->
    <section class="echommerce-products section-bg py-80">
        <span class="circle1"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section-heading  text-left">
                        <h2 class="section-heading__title pb-4">@lang('Related Products')</h2>
                        <div class="border-bottom pb-3"></div>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center latest-products card_wraper" id="card_wraper">
                @if(isset($relatedServices))
                @forelse($relatedServices as $service)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card_body">
                            <div class="card-img">
                                <a href="{{ route('product.details', ['slug' => slug($service->name), 'id' => $service->id])}}">
                                    <img src="{{ getImage(getFilePath('serviceImage').'/'.@$service->image)}}" alt="product image">
                                </a>
                                @if(isset($service->discount))
                                <div class="product-badge bg--info">
                                    @if($service->is_free ==1)
                                    <p>@lang('Free')</p>
                                    @else
                                    <p>{{$service->discount}}%</p>
                                    @endif
                                </div>
                                @else
                                <div class="product-badge bg--base">
                                    <p>@lang('New')</p>
                                </div>
                                @endif
                            </div>
                            <div class="content">
                                <div class="content-text">
                                   <h5><a href="{{ route('service.details', ['slug' => slug($service->name), 'id' => $service->id])}}" target="_blank">
                                        @if(strlen(__($service->name)) >30)
                                        {{substr( __($service->name), 0,30).'...' }}
                                        @else
                                        {{__($service->name)}}
                                        @endif
                                    </a></h5>
                                </div>
                                <div class="card-meta">
                                    <div class="btm">
                                        <div class="cart">
                                            <a href="{{ route('service.details', ['slug' => slug($service->name), 'id' => $service->id])}}" class="btn btn--base btn--sm outline"><i class="fas fa-cart-plus"></i> @lang('Free')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>{{ __($emptyMessage) }}</p>
                @endforelse
                @endif
            </div>
        </div>
        <span class="circle2"></span>
    </section>
    <!-- ==================== / Our Products  ==================== -->
@endsection


@push('style')
    <style>
        .wyg h1,
        .wyg h2,
        .wyg h3,
        .wyg h4 {
            color: hsl(var(--black));
        }

        .wyg p {
            color: hsl(var(--black));
        }

        .wyg ul {
            margin: 35px;
        }

        .wyg ul li {
            list-style-type: disc;
            color: hsl(var(--black));
            font-family: var(--body-font);
        }

        /*========= dark css =======*/
        .dark .wyg h1,
        .dark .wyg h2,
        .dark .wyg h3,
        .dark .wyg h4 {
            color: hsl(var(--white)/.6);
        }

        .dark .wyg p {
            color: hsl(var(--white)/.6);
        }

        .dark .wyg ul {
            margin: 35px;
        }

        .dark .wyg ul li {
            list-style-type: disc;
            color: hsl(var(--white));
        }
    </style>
@endpush

@push('script')
    <script>
        
        // rating set
        $(document).ready(function() {
            "use strict"
            $('.rating-stars i').on('click', function() {
                var rating = parseInt($(this).data('rating'));
                $('#rating').val(rating);
                updateStars(rating);
            });

            $('#rating').on('input', function() {
                var rating = $(this).val();
                updateStars(rating);
            });


            function updateStars(rating) {
                var stars = $('.rating-stars i');
                stars.removeClass('fas').addClass('far');
                stars.each(function(index) {
                    if (index < rating) {
                        $(this).removeClass('far').addClass('fas');
                    }
                });
            }

            var initialRating = parseInt($('#rating').val());
            if (initialRating > 0) {
                updateStars(initialRating);
            }

        });
        // end rating set
    </script>
@endpush
