@extends($activeTemplate .'layouts.frontend')
@section('content')
<section class="signup-section  py-80">
<div class="container">
    <div class="row gy-4 justify-content-center">
        <div class="verification-code-wrapper">
            <div class="verification-area">
                <h5 class="pb-3 text-center border-bottom">@lang('Verify Mobile Number')</h5>
                <form action="{{route('user.verify.mobile')}}" method="POST" class="submit-form">
                    @csrf
                    <p class="verification-text">@lang('A 6 digit verification code sent to your mobile number') : +{{
                        showMobileNumber(auth()->user()->mobile) }}</p>
                    @include($activeTemplate.'components.verification_code')
                    <div class="mb-3">
                        <button type="submit" class="btn btn--base w-50">@lang('Submit')</button>
                    </div>
                    <div class="form-group">
                        <p>
                            @lang('If you don\'t get any code'), <a href="{{route('user.send.verify.code', 'phone')}}"
                                class="forget-pass"> @lang('Try again')</a>
                        </p>
                        @if($errors->has('resend'))
                        <br />
                        <small class="text-danger">{{ $errors->first('resend') }}</small>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
