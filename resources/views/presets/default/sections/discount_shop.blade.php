@php
$team = App\Models\Team::where('status', 1)
->where('serial', 1)
->first();

$teams = App\Models\Team::where('status', 1)
->whereNot('serial', 1)
->orderBy('serial')
->limit(4)->get();
@endphp

<!-- ========  new item section ===== -->
<section class="new-section pt-120" id="discount">
    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 hero-content">
                <h2 style="text-align: center;">Our Teams</h2>
            </div>
        </div>
        @isset($team->name)
        <div class="row justify-content-center pt-5 gy-4 new-product-card_wraper">
            <div class="col-md-3 col-sm-6" >
                <div class="" style="border-radius: 10px; box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.144);">
                    <div class="d-flex">
                        <div class="" style="max-width:160px; max-height:180px; overflow: hidden !important; border-radius: 10px; border: 1px solid rgb(203, 243, 255);">
                             <img src="{{ asset('public/storage/' . $item->photo) }}" style="width:100% !important; height:100% !important;"/>
                        </div>
                        <div class="card-text_content" style="padding: 10px 10px; ">
                            <h6 class="product-title" style="margin: 0;">
                                <a href="">
                                    {{$item->name ?? ""}}
                                </a>
                            </h6>
                            <div class="product-meta" style="font-size:13px;">
                                <i>{{substr($item->bio, 1, 150) ?? ""}}</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endisset

        <div class="row justify-content-center pt-5 gy-4 new-product-card_wraper">
              <!-- card  -->
            @foreach($teams as $item)
                <div class="col-md-3 col-sm-6" >
                    <div class="" style="border-radius: 10px; box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.144);">
                        <div class="d-flex">
                            <div class="" style="max-width:160px; max-height:180px; overflow: hidden !important; border-radius: 10px; border: 1px solid rgb(203, 243, 255);">
                                 <img src="{{ asset('public/storage/' . $item->photo) }}" style="width:100% !important; height:100% !important;"/>
                            </div>
                            <div class="card-text_content" style="padding: 10px 10px; ">
                                <h6 class="product-title" style="margin: 0;">
                                    <a href="">
                                        {{$item->name ?? ""}}
                                    </a>
                                </h6>
                                <div class="product-meta" style="font-size:13px;">
                                <i>{{substr($item->bio, 1, 150) ?? ""}}</i>
                                </div>
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

