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
            <h2 class="fw-normal mt-5 mb-5" style="margin:0 auto;">Change Password</h2>
            <!--end::Title-->
          </div>
          <!--begin::Form-->
          <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <div>
                <label for="password">New Password</label>
                <input type="password" name="password" class="form-control mt-2 mb-5" required>
            </div>

            <div>
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control mt-2 mb-5" required>
            </div>

            <button type="submit" class="custombutton">Update Password</button>
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
@endsection
