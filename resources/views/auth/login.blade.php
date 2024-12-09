@extends('backend.layouts.master')

@section('styles')
<link href="{{asset('themes/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('themes/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="d-flex flex-column flex-root" id="kt_app_root">
  <!--begin::Authentication - Sign-in -->
  <div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
      <!--begin::Form-->
      <div class="d-flex flex-center flex-column flex-lg-row-fluid">
        <div style="text-align:center;"><img alt="Logo" src="{{asset('images/logo-transparent.png')}}" width="200" style="margin:0 auto;" /></div>
        <!--begin::Wrapper-->
        <div class="w-lg-500px p-10">
          @if (session('error'))
             <div class="alert alert-danger">
                  {{ session('error') }}
             </div>
          @endif
          <!--begin::Form-->
          <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" action="{{ route('login') }}">
            @csrf
            <div class="text-center mb-11">
              <h1 class="text-gray-900 fw-bolder mb-3">Devotee Sign In</h1>
            </div>
            <div class="fv-row mb-8">
              <div class="fv-row mb-8">
                <!--begin::Email-->
                <input type="text" placeholder="Email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus />
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
            <!--end::Input group=-->
            <div class="fv-row mb-3">
              <input type="password" placeholder="Password" name="password" class="form-control bg-transparent @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="password-field">
              <span class="fa fa-eye " id="togglePassword"  ></span>
              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
              <!--end::Password-->
            </div>

            <div class="fv-row mb-8">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label" for="remember">
                  {{ __('Remember Me') }}
              </label>
            </div>
            <!--end::Input group=-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
              <div></div>
              <!--begin::Link-->
              @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="link-primary">Forgot Password ?</a>
              @endif
              <!--end::Link-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Submit button-->
            <div class="d-grid mb-10">
              <button type="submit" id="kt_sign_in_submit" class="custombutton">
                <span class="indicator-label">Sign In</span>
              </button>
            </div>
          </form>
          <!--end::Form-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Form-->
      <!--begin::Footer-->

    </div>
  </div>
  <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<script src="assets/js/custom/authentication/sign-in/general.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  $(document).ready(function () {

     //  Toggle  Password Start
     $("#togglePassword").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
     $("#togglePassword").click(function() {
        const passwordInput = $("#password-field");
        const type = passwordInput.attr("type");

        if (type === "password") {
            passwordInput.attr("type", "text");
            $("#togglePassword").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
        } else {
            passwordInput.attr("type", "password");
            $("#togglePassword").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
        }
    });
    //  Toggle  Password End

  });

</script>
@endsection
