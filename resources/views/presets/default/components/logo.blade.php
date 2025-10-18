 <div class="header-menu-wrapper align-items-center d-flex">
    <div class="logo-wrapper" style="display:flex; justify-content: center; align-items:center;">
        <a style="width:120px;" href="{{ route('home') }}" class="header-logo normal-logo">
            <img style="max-width:110px; max-height:110px;" src="{{ asset(getFilePath('logoIcon') . '/logo.png') }}"
                alt="{{ config('app.name') }}">
        </a>

        <a style="width:120px;" href="{{ route('home') }}" class="header-logo dark-logo hidden">
            <img style="max-width:110px; max-height:110px;" src="{{ asset(getFilePath('logoIcon') . '/logo.png') }}"
                alt="{{ config('app.name') }}">
        </a>
        <div class="app_name" style="">
            <span class="name1">Simply</span> <span class="name2">Smart</span> <span class="name3">Solution</span>
        </div>
    </div>
</div>

<style>
.header-logo{
    width: 150px;
    -webkit-filter: drop-shadow(2px 2px 2px #bebdbdde);
    filter: drop-shadow(2px 2px 2px #bebdbdde);
}
.app_name {
  font-family: 'Roboto Condensed', sans-serif;
  font-weight: bold;
  font-size:35px;
}
.app_name .name1{
  color: #00dde5;
  text-shadow: 1px 1px 5px rgba(255, 252, 252, 0.639);
  text-shadow: 1px 1px 1px black;
}
.app_name .name2{
  color: #3576f8;
  text-shadow: 1px 1px 1px black;
}
.app_name .name3{
  color: #ffffff;
  background:rgb(0, 191, 255);
  border-radius: 8px;
  padding: 0px 9px;
  text-shadow: 1px 1px 1px black;
  font-size: 28px;
}
</style>