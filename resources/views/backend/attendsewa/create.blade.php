@extends('backend.layouts.master')

@section('styles')
<link href="{{asset('themes/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Add Service Attendance</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('sewa-attend.index')}}" class="text-muted text-hover-primary">Service Management</a>
                </li>
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
          <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content flex-column-fluid">
              <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card">
                  <div class="card-body pr-5 pl-5">
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

                    <!--
                    <h5>Scan your QR</h5>
                    <video id="video" width="400" height="300" autoplay></video>
                    <canvas id="qr-canvas" style="display: none;"></canvas>
                  -->

                    <form method="post" action="{{ route('sewa-attend.store') }}" enctype="multipart/form-data">
                      @csrf
                        <div class="row mb-2">
                          <!--<div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                              <div class="form-group">
                                  <label for="devotee">Devotee ID</label>
                                  <input type="number" name="devotee" id="devotee" class="form-control form-control-sm" />
                              </div>
                            </div>-->
                          <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                              <div class="form-group">
                                  <label for="devotee">Devotee</label>
                                  <select class="form-control" name="devotee" id="devotee" required>
                                    <option value="">Select One</option>
                                    @if($devotees->count() != NULL)
                                      @foreach($devotees as $devotee)
                                      <option value="{{$devotee->id}}"
                                        data-kt-rich-content-email="<?php if($devotee->email_enc != NULL){ echo Crypt::decrypt($devotee->email_enc); } ?>"
                                        data-kt-rich-content-mobile="<?php if($devotee->mobile_enc != NULL){ echo Crypt::decrypt($devotee->mobile_enc); } ?>"
                                        data-kt-rich-content-initiation="@if(Helper::getinitiationrow($devotee->id)) {{Helper::getinitiationrow($devotee->id)->initiation_name}} @endif"
                                         @if(isset($_GET['devotee']) && ($_GET['devotee'] == $devotee->id)) selected @endif
                                        >
                                        <?php if($devotee->firstname != NULL){ echo Crypt::decrypt($devotee->firstname); } ?>
                                        <?php if($devotee->middlename != NULL){ echo Crypt::decrypt($devotee->middlename); } ?>
                                        <?php if($devotee->surname != NULL){ echo Crypt::decrypt($devotee->surname); } ?>
                                        </option>
                                      @endforeach
                                    @endif
                                  </select>
                              </div>
                            </div>
                              <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                  <div class="form-group">
                                      <label for="department">Service Department</label>
                                      <select class="form-select form-select-sm form-select-solid" data-control="select2" name="department" id="department" required>
                                        <option value="">Select One</option>
                                        @if($departments->count() != NULL)
                                          @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{$department->title}}</option>
                                          @endforeach
                                        @endif
                                      </select>
                                  </div>
                                </div>
                          </div>
                          <div class="row mb-2">
                              <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                  <div class="form-group">
                                      <label for="date">Date</label>
                                      <input type="text" class="form-control form-control-solid" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" readonly />
                                  </div>
                              </div>
                              <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                  <div class="form-group">
                                      <label for="designation">Designation</label>
                                      <select class="form-select form-select-sm form-select-solid" name="designation" id="designation" required>
                                        <option value="Volunteer">Volunteer</option>
                                        <option value="Head">Head</option>
                                      </select>
                                  </div>
                              </div>
                            </div>
                          <div class="row mb-2">
                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
                            </div>
                          </div>
                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
          @include('backend.layouts.copyrights')
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript">
// Format options
const optionFormat = (item) => {
    if (!item.id) {
        return item.text;
    }

    var span = document.createElement('span');
    var template = '';

    template += '<div class="d-flex align-items-center">';
    template += '<div class="d-flex flex-column">'
    template += '<span class="fs-4 fw-bold lh-1">' + item.text + '</span>';
    template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-kt-rich-content-initiation') + '</span>';
    template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-kt-rich-content-email') + '</span>';
    template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-kt-rich-content-mobile') + '</span>';
    template += '</div>';
    template += '</div>';

    span.innerHTML = template;

    return $(span);
}

// Init Select2 --- more info: https://select2.org/
$('#devotee').select2({
    placeholder: "Select an option",
    templateSelection: optionFormat,
    templateResult: optionFormat
});
</script>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.3.1/dist/jsQR.js"></script>
<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('qr-canvas');
    const context = canvas.getContext('2d');
    const qrResultInput = document.getElementById('devotee');
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
              const str = qrCode.data;
              const lastSegment = str.split("-").pop();
              qrResultInput.value = lastSegment; // Set QR data to input field
              scanning = false; // Stop further scanning
              alert("QR Code Scanned: " + lastSegment);
            }
        }
        if (scanning) {
            requestAnimationFrame(tick); // Continue scanning if still allowed
        }
    }
</script>
@endsection
