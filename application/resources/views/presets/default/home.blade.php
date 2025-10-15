@extends($activeTemplate.'layouts.frontend')
@section('content')

    @php
    $banner = getContent('banner.content', true);
    $categories = App\Models\Category::where('status',1)->get();
    @endphp

    <section class="hero hero-bg" style="padding: 150px 0;">
        <span class="circle1"></span>
        <span class="circle2"></span>
        <div class="circle3"></div>
        <img class="hero-shape-bg" data-value="-10" src="{{asset($activeTemplateTrue.'images/hero-shape.png')}}" alt="banner image3">

        <style>
        .animationBox_container{
            position: relative;
            z-index: 100;
        }
        .animationBox_container .box-img{
            display: flex;
            flex-direction: column;
            justify-content: left;
            align-items: center;
            cursor: pointer;
        }
        .animationBox_container .box-img .name{
            white-space: nowrap;
            display: none;
        }
        </style>

        <div class="container" >
            <div class="animationBox_container">
                <span class="box3 top_image_bounce" style="left: -10px; top: 150px; font-size:60px;">
                    <span class="box-img">
                        <i class="fas fa-angle-left"></i>
                    </span>
                </span>
                <span class="box6 left_image_bounce" style="right: 0px; top: 150px; font-size:60px;">
                    <span class="box-img">
                        <i class="fas fa-angle-right"></i>
                    </span>
                </span>
            </div>

            <div class="row justify-content-center position-relative">
                <div class="col-xl-7 col-lg-8 col-md-8 text-center">
                    <div class="heror-content">
                        <p class="sub-heading">{{__($banner->data_values->heading)}}</p>
                        <h1 class="heading" style="white-space:nowrap;">{{__($banner->data_values->sub_heading)}}</h1>
                    </div>
                </div>
                {{-- search result --}}
                <div class="search-result-wrap d-none">
                    <ul>
                        <li class="search-results searchResults"></li>
                    </ul>
                </div>
            </div>

            <div class="row gy-4 category-wraper justify-content-center pt-1">
                @foreach($categories as $category)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 ">
                    <div class="category-card_body">
                        <img class="category-bg" data-value="-2" src="{{asset($activeTemplateTrue.'images/category-bg.png')}}" alt="banner image1">

                        <div class="category-img">
                            <a href="{{route('filter.category.service',$category->id)}}">
                                <span style="color:rgb(50, 255, 245) !important;">@php echo $category->icon;@endphp</span>
                            </a>
                        </div>
                        <div class="category-content">
                            <a href="{{route('filter.category.service',$category->id)}}"><h6>{{__($category->name)}}</h6></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection


@push('script')
    <script>
        $(document).ready(function() {
            "use strict";
            $('.searchProduct').on('keyup', function() {
                var baseUrl = '{{ url('/') }}';
                var searchValue = $(this).val().trim();
                var searchResults = $(this).closest('.position-relative').find('.search-results');

                if (searchValue !== '') {
                    $.ajax({
                        url: '{{ route("product.search") }}',
                        type: 'get',
                        data: { search: searchValue },
                        dataType: 'json',
                        success: function(response) {
                            searchResults.empty();

                            $('.search-result-wrap').removeClass('d-none')

                            if (response.length > 0) {
                                $.each(response, function(index, product) {
                                    var productName = product.name;
                                    var productSlug = slugify(productName);
                                    var productId = product.id;

                                    var productLink = baseUrl + '/product/' + productSlug + '/' + productId;

                                    var resultItem = $('<a>' + productName + '</a>');
                                    resultItem.attr('href', productLink);
                                    // resultItem.css('opacity', 0);
                                    searchResults.append(resultItem);
                                    resultItem.animate({ opacity: 1, marginLeft: '10px' }, 500);
                                });
                                searchResults.show();
                            } else {
                                searchResults.html('<p>No results found.</p>');

                            }
                        }.bind(this)
                    });
                } else {
                    searchResults.empty();
                    $('.search-result-wrap').addClass('d-none');
                }
            });

            $('.close-hide-show').on('click', function() {
                var searchResults = $(this).closest('.position-relative').find('.search-results');
                searchInput.val('');
                searchResults.empty();
            });

            function slugify(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
            }
        });
    </script>

@endpush


