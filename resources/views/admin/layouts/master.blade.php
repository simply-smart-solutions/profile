<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general->siteName($pageTitle ?? '') }}</title>

    <link rel="shortcut icon" type="image/png" href="{{getImage(getFilePath('logoIcon') .'/favicon.png')}}">
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/common/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-toggle.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/line-awesome.min.css')}}">

    @stack('style-lib')

    <link rel="stylesheet" href="{{asset('assets/admin/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/custom-style.css')}}">

    <link rel="stylesheet" href="{{asset('assets/admin/css/fontawesome-iconpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/summernote-bs4.css')}}">
    <link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet">

    <meta
    name="csrf-token"
    content="{{ csrf_token() }}"
    >
    @stack('style')
</head>

<body>
    @yield('content')
    <script src="{{asset('assets/common/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/common/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/bootstrap-toggle.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jquery.slimscroll.min.js')}}"></script>

    @include('includes.notify')
    @stack('script-lib')

    <script src="{{asset('assets/admin/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/admin.js')}}"></script>
    {{-- <script src="{{ asset('assets/common/js/ckeditor.js') }}"></script> --}}

    {{-- LOAD EDITOR --}}
    {{-- <script>
        // "use strict";
        $(document).ready(function() {
            if ($(".trumEdit")[0]) {
                ClassicEditor
                .create(document.querySelector('.trumEdit'), {
                    // uploadUrl: '{{ url("/upload/image") }}',
                    // headers: {
                    //     'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    // }
                })
                .then(editor => {
                    // console.log('Editor ready', editor);
                })
                .catch(error => {
                    // console.error(error);
                });
            }
        });
    </script> --}}

    <!-- LFM Modal -->
    <div class="modal fade lfm-modal" id="lfmModalSummernote" tabindex="-1" role="dialog" aria-labelledby="lfmModalSummernoteTitle" aria-hidden="true">
        <i class="fas fa-times-circle"></i>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <iframe src="" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- Loader --}}
    <div class="request-loader">
        <img
        src="{{asset('assets/admin/img/loader.gif')}}"
        alt=""
        >
    </div>

    {{-- Loader --}}
    <!-- Fontawesome Icon Picker JS -->
    <script src="{{asset('assets/admin/js/plugin/fontawesome-iconpicker/fontawesome-iconpicker.min.js')}}"></script>
    <!-- Popper and Bootstrap (bundle includes tooltip) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <!-- Summernote (BS4 version) -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
    
    <!-- Summernote JS -->
    <script src="{{asset('assets/admin/js/plugin/summernote/summernote-bs4.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        });
        var imgupload = "{{route('lfm.summernote.upload')}}";
        var baseurl = "{{url('/')}}";
        // var route_prefix = "{{ url('laravel-filemanager') }}";

        
                
        var ImageButton = function(context) {
            var ui = $.summernote.ui;
            var button = ui.button({
                contents: '<i class="far fa-images"></i>',
                tooltip: 'File Manager',
                click: function() {
                    let id = context.$note[0].id;
                    $("#lfmModalSummernote").find('iframe').attr('src', "");
                    $("#lfmModalSummernote").find('iframe').attr('src', baseurl + "/laravel-filemanager?summernote=" + id);
                    $("#lfmModalSummernote").modal('show');
                }
            });
        
            return button.render();
        }

        function uniqid() {
            return '_' + Math.random().toString(36).substr(2, 9);
        }
        $(".trumEdit").each(function (i) {
            let theight;
            let $summernote = $(this);
            $summernote.attr('id', "trumEdit" + uniqid());
            if ($(this).data('height')) {
                theight = $(this).data('height');
            } else {
                theight = 200;
            }
            $('.trumEdit').eq(i).summernote({
                height: theight,
                dialogsInBody: true,
                dialogsFade: false,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['height', ['height']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'image', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                buttons: {
                    image: ImageButton,
                },
                popover: {
                    image: [
                    ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']]
                    ],
                    link: [
                    ['link', ['linkDialogShow', 'unlink']]
                    ],
                    table: [
                    ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                    ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                    ],
                    air: [
                    ['color', ['color']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']]
                    ]
                },
                callbacks: {
                    onImageUpload: function (files) {
                    // console.log(files);
                    $(".request-loader").addClass('show');
                    
                    let fd = new FormData();
                    fd.append('image', files[0]);
                    
                    $.ajax({
                        url: imgupload,
                        method: 'POST',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                        // console.log(data);
                        $summernote.summernote('insertImage', data);
                            $(".request-loader").removeClass('show');
                        }
                    });
                    
                    }
                }
            });
        });
                
        // LFM scripts START
        window.closeLfmModal = function(serial){
            $('#lfmModal'+serial).modal('hide');
            // if any modal is open, then add 'modal-open' class to body
            if($(".modal.show").length > 0) {
            setTimeout(function() {
                $('body').addClass('modal-open');
            }, 500);
            }
        };
        window.closeLfmModalSummernote = function(){
            $('#lfmModalSummernote').modal('hide');
            // if any modal is open, then add 'modal-open' class to body
            setTimeout(function() {
                if($(".modal.show").length > 0) {
                $('body').addClass('modal-open');
                }
            }, 500);
        };
        $(document).ready(function() {
            $(`.lfm-modal .fas.fa-times-circle`).on('click', function() {
            $(this).parents('.lfm-modal').modal('hide');
            // if any modal is open, then add 'modal-open' class to body
            setTimeout(function() {
                if($(".modal.show", parent.document).length > 0) {
                $('body', parent.document).addClass('modal-open');
                }      
            }, 500);
            });

            $(`.lfm-modal`).on('click', function(e) {
            if (!$(e.target).hasClass('modal-dialog') && !$(e.target).parents('.modal-dialog').length) {
                console.log('outside modal');
                // if any modal is open, then add 'modal-open' class to body
                setTimeout(function() {
                if($(".modal.show", parent.document).length > 0) {
                    $('body', parent.document).addClass('modal-open');
                }    
                }, 500);
            }
            });
            
        });
        
        window.insertImage = function(id, items) {
            items.forEach(function(item) {
                $("#" + id).summernote('insertImage', item);
            });
        };  
        // LFM scripts END

    </script>
    @stack('script')
</body>
</html>