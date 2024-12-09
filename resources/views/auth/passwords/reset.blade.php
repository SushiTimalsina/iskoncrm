@extends('backend.layouts.master')

@section('styles')
<link href="{{asset('themes/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('themes/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="d-flex flex-column flex-root" id="kt_app_root">
  <!--begin::Page bg image-->
  <style>body { background:#B13126 !important; }</style>
  <!--end::Page bg image-->
  <!--begin::Authentication - Sign-in -->
  <div class="d-flex flex-column flex-column-fluid flex-lg-row">
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20" style="margin:0 auto;">
      <!--begin::Card-->
      <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
        <!--begin::Wrapper-->
        <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
          <div class="d-flex flex-center flex-lg-start flex-column">
            <img alt="Logo" src="{{asset('images/logo-transparent.png')}}" width="200" style="margin:0 auto;" />
            <h2 class="fw-normal mt-5 mb-5" style="margin:0 auto;">Enter New Password</h2>
            <!--end::Title-->
          </div>
          <!--begin::Form-->
          <form method="POST" action="{{ route('password.update') }}" style="width:70%;">
              @csrf

              <input type="hidden" name="token" value="{{ $token }}">

              <div class="fv-row mb-8">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="fv-row mb-8">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="fv-row mb-8">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
              </div>

              <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_in_submit" class="custombutton">
                  <span class="indicator-label">{{ __('Reset Password') }}</span>
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
