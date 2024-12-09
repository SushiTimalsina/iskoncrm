@extends('backend.layouts.master')

@section('styles')
<link href="{{asset('themes/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('themes/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('style.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="d-flex flex-column flex-root" id="kt_app_root">
  <!--begin::Page bg image-->
  <style>body { background:#B13126 !important; }</style>
  <!--end::Page bg image-->
  <!--begin::Authentication - Sign-in -->
  <div class="d-flex flex-column flex-column-fluid flex-lg-row">
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end aligncenterposition" style="margin:0 auto;">
      <!--begin::Card-->
      <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-400px p-10">
        <!--begin::Wrapper-->
        <div class="d-flex flex-center flex-column flex-column-fluid">
          <div class="d-flex flex-center flex-lg-start flex-column">
            <img alt="Logo" src="{{asset('images/logo-transparent.png')}}" width="200" style="margin:0 auto;" />
            <h2 class="logintitle">Admin Login</h2>
            <!--end::Title-->
          </div>

          @if (session('error'))
             <div class="alert alert-danger">
                  {{ session('error') }}
             </div>
          @endif

          <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" action="{{ route('admin.login') }}">
            @csrf
            <div class="fv-row mb-8">
              <!--begin::Email-->
              <input type="text" placeholder="Email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus />
              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
            <div class="fv-row mb-4 password-section">
              <input type="password" placeholder="Password" name="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="password-field">
              <span class="fa fa-eye " id="togglePassword"  ></span>
              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>

            <div class="fv-row mb-8">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label" for="remember">
                  {{ __('Remember Me') }}
              </label>
            </div>

            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
              <div></div>
              @if (Route::has('password.request'))
              <a href="{{ route('admin.password.request') }}" class="link-primary">Forgot Password ?</a>
              @endif
            </div>
            <div class="d-grid mb-10">
              <button type="submit" id="kt_sign_in_submit" class="custombutton">
                <span class="indicator-label">Sign In</span>
              </button>
            </div>
          </form>
          <!--end::Form-->
        </div>
        <!--end::Footer-->
      </div>
      <!--end::Card-->
    </div>
    <!--end::Body-->
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
