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
                    </div>
                </div>
            </aside>
              <!-- card  -->
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 main-content">
                <div class="row gy-4 justify-content-center">
                    @forelse($services as $service)
                    <div class="col-xl-4 col-lg-6 col-md-6" >
                        <div class="card_body">
                            <div class="card-img">
                                <a href="{{ route('service.details', ['slug' => slug($service->name), 'id' => $service->id])}}">
                                    <img src="{{ getImage(getFilePath('serviceImage').'/'.@$service->image)}}" alt="service image">
                                </a>
                            </div>
                            <div class="content">
                                <div class="content-text">
                                    {{-- <p><a href="{{route('filter.category.services',$service->category->id)}}"> {{__($service->category->name)}} </a></p> --}}
                                    <h5><a href="{{ route('service.details', ['slug' => slug($service->name), 'id' => $service->id])}}" target="_blank">
                                        @if(strlen(__($service->name)) >30)
                                        {{substr( __($service->name), 0,30).'...' }}
                                        @else
                                        {{__($service->name)}}
                                        @endif
                                    </a></h5>
                                </div>
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
            @if ($services->hasPages())
            <div class="col-md-12 d-flex justify-content-center">
                {{ paginateLinks($services) }}
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
            values: [5, 10000],
            step: 1,
            slide: function (event, ui) {
            },
            change:function(){

                    var categories   = [];
                    var searchValue = [];

                     getFilteredData(categories,searchValue)
                }
        });

        $("input[type='checkbox'][name='categories']").on('click', function(){
            var categories   = [];
            var searchValue = [];

                $('.filter-by-category:checked').each(function() {
                    if(!categories.includes(parseInt($(this).val()))){
                        categories.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(categories,searchValue)
        });

        $("#searchValue").on('keyup', function () {
            var categories   = [];
            var searchValue = [];
            var searchValue = $(this).val();
            getFilteredData(categories,searchValue)
        });

        function getFilteredData(categories,searchValue){

            $.ajax({
                type: "get",
                url: "{{ route('service.filtered') }}",
                beforeSend: function() {
                    $("#loading").css({display: 'block'});
                },
                data:{
                    "categories": categories,
                    "search": searchValue,
                },
                dataType: "json",
                success: function (response) {
                    $("#loading").css({display: 'none'});
                    console.log(response);

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
