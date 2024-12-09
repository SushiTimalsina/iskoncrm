@extends('backend.layouts.master')

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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">
                @if (isset($edit))
                    Edit
                @else
                    Add
                @endif
                Mentor</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('mentor.index')}}" class="text-muted text-hover-primary">Mentor Management</a>
                </li>
              </ul>
            </div>
            <!--end::Page title-->
          </div>
          <!--end::Page title wrapper-->
          <!--begin::Navbar-->
          @include('backend.layouts.usermenu')
          <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
      </div>
      <!--end::Header container-->
    </div>
    <!--end::Header-->
    <!--begin::Wrapper-->
    <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
      <!--begin::Sidebar-->
      @include('backend.layouts.leftmenu')
        <!--end::Sidebar-->
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          <!--begin::Content wrapper-->
          <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
              <!--begin::Content container-->
              <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Card-->
                <div class="card">
                  <!--begin::Card header-->

                  <!--end::Card header-->
                  <!--begin::Card body-->
                  <div class="card-body py-4">
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
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (isset($edit))
                        <form action="{{ route('mentor.update', $edit->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @else
                        <form action="{{ route('mentor.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                      @csrf
                        <div class="row">
                          @if(!isset($edit))
                          <div class="col-md-4 col-sm-4 col-lg-4 mb-2">
                              <div class="form-group">
                                  <label for="devotee">Devotee</label>
                                  <select class="form-control" name="devotee" id="devotee" required>
                                    <option value="">Select One</option>
                                    @if($devotees->count() != NULL)
                                      @foreach($devotees as $devotee)
                                          <option value="{{$devotee->id}}" @if (isset($edit)) {{ old('devotee', $edit->devotee_id == $devotee->id ? 'selected' : '' ?? '') }} @endif
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
                          @endif
                          <div class="col-md-4 col-sm-4 col-lg-4 mb-2">
                                <div class="form-group">
                                    <label for="branch">Branch</label>
                                    <select class="form-control" data-control="select2" name="branch" id="branch" required>
                                      <option value="">Select One</option>
                                      @if($branches->count() != NULL)
                                        @foreach($branches as $branch)
                                          <option value="{{$branch->id}}" @if (isset($edit)) {{ old('branch', $edit->branch_id == $branch->id ? 'selected' : '' ?? '') }} @endif>{{$branch->title}}</option>
                                        @endforeach
                                      @endif
                                    </select>
                                </div>
                              </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-2">
                                <div class="form-group">
                                    <label for="parent">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        @if (isset($edit))
                                          <option value="Active" @if (isset($edit)) {{ old('status', $edit->status == 'Active' ? 'selected' : '' ?? '') }} @endif>Active</option>
                                          <option value="Draft" @if (isset($edit)) {{ old('status', $edit->status == 'Draft' ? 'selected' : '' ?? '') }} @endif>Draft</option>
                                        @else
                                          <option value="Active">Active</option>
                                          <option value="Draft">Draft</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">@if (isset($edit)) Update @else Create @endif Mentor</button>
                            </div>
                          </div>
                    </form>
                  </div>
                  <!--end::Card body-->
                </div>
                <!--end::Card-->
              </div>
              <!--end::Content container-->
            </div>
            <!--end::Content-->
          </div>
          <!--end::Content wrapper-->
          <!--begin::Footer-->
          @include('backend.layouts.copyrights')
          <!--end::Footer-->
        </div>
        <!--end:::Main-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Page-->
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
