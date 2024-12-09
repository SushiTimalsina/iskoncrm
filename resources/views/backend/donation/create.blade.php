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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Create Donation</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('donation.index')}}" class="text-muted text-hover-primary">Donation Management</a>
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

                    <form method="post" action="{{ route('donation.store') }}" enctype="multipart/form-data">
                      @csrf
                        <div class="row mb-2">
                          <div class="col-md-12 col-sm-12 col-lg-12 mb-4">
                              <div class="form-group">
                                  <label for="title">Title</label>
                                  <select class="form-control" name="title">
                                    <option value="">Select One</option>
                                  </select>
                              </div>
                          </div>
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
                                      <label for="sewa">Sewa</label>
                                      <select class="form-select" data-control="select2" name="sewa" id="sewa" required>
                                        <option value="">Select One</option>
                                        @if($sewas->count() != NULL)
                                          @foreach($sewas as $sewa)
                                            <option value="{{$sewa->id}}">{{$sewa->title}}</option>
                                          @endforeach
                                        @endif
                                      </select>
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                    <div class="form-group">
                                        <label for="donation">Donation Amount</label>
                                        <input type="number" name="donation" id="donation" class="form-control" required />
                                    </div>
                                </div>
                          </div>
                          <div class="row mb-2">
                              <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                  <div class="form-group">
                                      <label for="type">Transaction Type</label>
                                      <select class="form-select" data-control="select2" name="type" id="type" required>
                                        <option value="">Select One</option>
                                        <option value="Esewa">Esewa</option>
                                        <option value="QR">QR</option>
                                        <option value="Khalti">Khalti</option>
                                        <option value="Nepal Pay">Nepal Pay</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Donation Box">Donation Box</option>
                                        <option value="Int'l Transfer">Int'l Transfer</option>
                                        <option value="Other">Other</option>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-select" data-control="select2" name="status" id="status" required>
                                          <option value="">Select One</option>
                                          <option value="Paid">Paid</option>
                                          <option value="Pending">Pending</option>
                                          <option value="Schedule">Schedule</option>
                                          <option value="Refund">Refund</option>
                                          <option value="Cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                      <div class="form-group">
                                          <label for="voucher">Voucher No.</label>
                                          <input type="text" name="voucher" id="voucher" class="form-control" />
                                      </div>
                                    </div>
                            </div>
                          <div class="row mb-2">
                            <input type="hidden" name="designation" value="Head" />
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
@endsection
