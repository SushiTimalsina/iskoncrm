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


            <h1>QR Code Scanner</h1>

            <video id="video" width="400" height="300" autoplay></video>
            <canvas id="qr-canvas" style="display: none;"></canvas>

            <p>Decoded Data:</p>
            <form method="post" action="{{ route('searchbyqrid') }}" enctype="multipart/form-data">
              @csrf
              <div class="row mb-2">
                  <div class="col-md-8 col-sm-8 col-lg-8">
                    <div class="form-group">
                        <input type="text" class="form-control" name="id" id="qr-result" readonly />
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-lg-4">
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary">Search</button>
                      </div>
                  </div>
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
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.3.1/dist/jsQR.js"></script>
<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('qr-canvas');
    const context = canvas.getContext('2d');
    const qrResultInput = document.getElementById('qr-result');
    let scanning = true;

    // Request camera access
    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
        .then(function (stream) {
            video.srcObject = stream;
            video.setAttribute('playsinline', true); // iOS compatibility
            video.play();
            requestAnimationFrame(tick);
        });

    function tick() {
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const qrCode = jsQR(imageData.data, imageData.width, imageData.height);

            if (qrCode && scanning) {
                qrResultInput.value = qrCode.data; // Set QR data to input field
                scanning = false; // Stop further scanning
                alert("QR Code Scanned: " + qrCode.data);
            }
        }
        if (scanning) {
            requestAnimationFrame(tick); // Continue scanning if still allowed
        }
    }
</script>
@endsection
