@php
    $contact = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element', false);
    $languages = App\Models\Language::all();
    $pages = App\Models\Page::where('tempname', $activeTemplate)->get();
    $user = auth()->user();
@endphp
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">

<style>
@media (max-width:1050px){
    .app_name {
        display: none;
    }
    .animationBox_container{
        display: none;
    }
}
</style>
<!--========================== Header section Start ==========================-->
<div class="header-main-area">
    <div class="header" id="header" style="padding:10px 0 !important;">
        <div class="container position-relative" style="width:100%; max-width:96%; margin-left:15px;">
            <div class="row">
                <div class="header-wrapper" style="display:flex; align-items:space-between; justify-content:space-between;">
                    <!-- ham menu -->
                    <i class="fas fa-bars ham__menu" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                        aria-controls="offcanvasExample"></i>

                    <!-- logo start -->
                    @include($activeTemplate.'components.logo')
                    <!-- logo end -->

                    <div class="menu-wrapper">
                        <ul class="main-menu">
                            @auth
                                <li>
                                    <a class="{{ Route::is('user.home') ? 'active' : '' }}" aria-current="page"
                                        href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                            @endauth
                            @foreach ($pages as $page)
                                @if ($page->slug != 'blog')
                                    <li>
                                        <a class="{{ Request::url() == url('/') . '/' . $page->slug ? 'active' : '' }}" aria-current="page"
                                        href="{{ route('pages', [$page->slug]) }}" style="white-space:nowrap;">{{ __($page->name) }}</a>
                                @endif
                            @endforeach
                        </ul>
                        <div class="menu-right-wrapper">
                            <ul>
                                <li>
                                    <div class="light-dark-btn-wrap ms-1" id="light-dark-checkbox">
                                        <i class="fas fa-moon mon-icon"></i>
                                        <i class='fas fa-sun sun-icon'></i>
                                    </div>
                                </li>
                                <li></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--========================== Header section End ==========================-->

<!--========================== Sidebar mobile menu wrap Start ==========================-->


<div class="offcanvas offcanvas-start text-bg-light" tabindex="-1" id="offcanvasExample">
    <div class="offcanvas-header">
        <div class="logo">
            <div class="header-menu-wrapper align-items-center d-flex">
                <div class="logo-wrapper">
                    <a href="{{ route('home') }}" class="normal-logo"> <img
                            src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}"
                            alt="{{ config('app.name') }}"></a>
                    <a href="{{ route('home') }}" class="dark-logo hidden"> <img
                            src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}"
                            alt="{{ config('app.name') }}"></a>
                </div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @auth
            <div class="user-info"
                style="background: url({{ asset($activeTemplateTrue . 'images/sidenav_uer.jpg') }});background-position: center;background-size: cover; filter: grayscale(30%) ;">
                <div class="user-thumb">
                    <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}"
                        alt="user-image">
                </div>
                <h4 class="text-white">{{ __($user->fullname) }}</h4>
            </div>
        @endauth

        <ul class="side-Nav">
            @auth
                <li class="{{ Route::is('user.home') ? 'active' : '' }}">
                    <a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                </li>
            @endauth
            @foreach ($pages as $page)
                <li class="{{ Request::url() == url('/') . '/' . $page->slug ? 'active' : '' }}">
                    <a href="{{ route('pages', [$page->slug]) }}"> {{ __($page->name) }}</a>
                </li>
            @endforeach
        </ul>

    </div>
</div>
