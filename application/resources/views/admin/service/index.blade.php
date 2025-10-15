@extends('admin.layouts.app')
@section('panel')
@include('admin.components.tabs.product')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th>@lang('Product Name')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Author')</th>
                                <th>@lang('Image')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Discount Price')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($products as $item)
                           <tr>
                              <td>{{__($item->name)}}</td>
                              <td>{{__(@$item->category->name)}}</td>
                              <td>
                                @if($item->user)
                                <span class="bage badge--warning">{{__($item->user->username)}}</span>
                                @else
                                <span class="bage badge--primary">@lang('Admin')</span>
                                @endif
                              </td>

                              <td><img src="{{ getImage(getFilePath('productThumbnail').'/'.@$item->thumbnail)}}" alt="Image" class="rounded" style="width:100px;"></td>

                              <td>
                                {{__($general->cur_sym)}} {{__(showAmount($item->price))}}
                            </td>
                            <td> @if(isset($item->discount))
                                 {{__($item->discount)}}%
                                 @else
                                 <span>@lang('No')</span>
                                 @endif
                            </td>
                                <td>@php echo $item->statusBadge($item->status); @endphp</td>
                              <td>
                                 <div class="button--group">
                                    <a href="{{route('admin.product.edit',$item->id)}}"  class="btn btn-sm btn--primary"><i class="las la-edit"></i></a>
                                    <button class="btn btn-sm btn--danger rejectBtn" data-id="{{ $item->id }}"><i class="las la-trash"></i></button>
                                 </div>
                              </td>
                           </tr>
                           @empty
                           <tr>
                             <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                          </tr>
                           @endforelse
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($products->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($products) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>

{{-- REJECT MODAL --}}
<div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Product Delete Confirmation')</h5>
                <button type="button" class="close btn btn--danger" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{route('admin.product.delete')}}" method="get">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure you want to delete this product?')
                     </p>
                </div>
                <div class="modal-footer">
                    <div class="buttorn_wrapper">
                        <button type="submit" class="btn btn--success"> <span
                                class="btn_title">@lang('Delete') <i
                                    class="fa-solid fa-angles-right"></i></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('breadcrumb-plugins')
<a href="{{route('admin.product.create')}}" class="btn btn-sm btn--primary "><i class="las la-plus"></i>@lang('Add
    New')</a>
@endpush

@push('script')
<script>
    (function($){
        "use strict";
        $('.rejectBtn').on('click', function () {
            var modal = $('#rejectModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });

    })(jQuery);
</script>
@endpush


