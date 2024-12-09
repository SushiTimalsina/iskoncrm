@extends('backend.layouts.master')

@section('styles')
<link href="{{asset('themes/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
<link href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #results { padding:20px; border:1px solid; background:#ccc; }
</style>
@endsection

@section('content')

<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
  <!--begin::Page-->
  <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
    <!--begin::Header-->
    <div id="kt_app_header" class="app-header d-flex" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '300px'}">
      <!--begin::Header container-->
      <div class="app-container container-fluid d-flex align-items-stretch" id="kt_app_header_container">
        <!--begin::Header wrapper-->
        <div class="app-header-wrapper d-flex flex-stack w-100">
          <!--begin::Logo wrapper-->
          @include('backend.layouts.mobile-logo')
          <!--end::Logo wrapper-->
          <!--begin::Page title wrapper-->
          <div id="kt_app_header_page_title_wrapper">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_page_title_wrapper'}" class="page-title d-flex flex-column justify-content-center me-3 mb-6 mb-lg-0">
              <!--begin::Title-->
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Profile Picture Upload</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('devotees.index')}}" class="text-muted text-hover-primary">Devotee Management</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Devotee Details</li>
              </ul>
            </div>
          </div>
          @include('backend.layouts.usermenu')
        </div>
      </div>
    </div>
    <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    @include('backend.layouts.leftmenu')

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
      <!--begin::Content wrapper-->
      <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
          <!--begin::Content container-->
          <div id="kt_app_content_container" class="app-container container-fluid">
            @if(session()->get('success'))
            <div class="alert alert-success">
                <div class="alert-body">{{ session()->get('success') }}</div>
            </div>
            @endif

            @if(session()->get('error'))
            <div class="alert alert-danger">
                <div class="alert-body">{{ session()->get('error') }}</div>
            </div>
            @endif

            <form action="{{ route('profileimageupdate', $devoteeid) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-3"></div>
                <div class="col-md-5 col-lg-5 col-sm-5">
                  <div id="my_camera"></div>
                  <input class="mt-5" type=button value="Take Snapshot" onClick="take_snapshot()">
                  <input type="hidden" name="image" class="image-tag">
                  <div id="results" class="mt-5">Your captured image will appear here...</div>
                  <button type="submit" class="mt-5 btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Upload</button>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3"></div>
              </div>
            </form>

          </div>
          <!--end::Content container-->
        </div>
        <!--end::Content-->
      </div>
      @include('backend.layouts.copyrights')
      <!--end::Footer-->
    </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script language="JavaScript">
    Webcam.set({
        width: 490,
        height: 350,
        image_format: 'jpg',
        jpeg_quality: 100
    });

    Webcam.attach( '#my_camera' );

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>
@endsection
