<div class="row gy-4 justify-content-center">
    @forelse($services as $service)
    <div class="col-xl-4 col-lg-6 col-md-4" >
        <div class="card_body">
            <div class="card-img">
                <a href="{{ route('service.details', ['slug' => slug($service->name), 'id' => $service->id])}}">
                    <img src="{{ getImage(getFilePath('serviceImage').'/'.@$service->image)}}" alt="service image">
                </a>
                {{-- <div class="product-badge bg--base">
                    <p>@lang('New')</p>
                </div> --}}
            </div>
            <div class="content">
                <div class="content-text">
                    <p><a href="{{route('filter.category.service',$service->category->id)}}"> {{__($service->category->name)}} </a></p>
                    <h5><a href="{{ route('service.details', ['slug' => slug($service->name), 'id' => $service->id])}}">
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
