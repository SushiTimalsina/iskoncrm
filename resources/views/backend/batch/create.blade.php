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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Add Batch</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('course-batch.index')}}" class="text-muted text-hover-primary">Batch Management</a>
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

                    <form method="post" action="{{ route('course-batch.store') }}" enctype="multipart/form-data">
                      @csrf
                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="name">Batch Name</label>
                                    <input type="text" class="form-control" name="name" id="name" required />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="course">Course</label>
                                    <select name="course" id="course" class="form-select" data-control="select2" required>
                                      <option value="">Select One</option>
                                      @if($courses->count() != NULL)
                                        @foreach($courses as $course)
                                          <option value="{{$course->id}}">{{$course->title}}</option>
                                        @endforeach
                                      @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="facilitator">Facilitator</label>
                                    <select name="facilitator" id="facilitator" class="form-select" data-control="select2" required>
                                      <option value="">Select One</option>
                                      @if($facilitators->count() != NULL)
                                        @foreach($facilitators as $facilitator)
                                          <option value="{{$facilitator->id}}">
                                            <?php if($facilitator->getdevotee->firstname != NULL){ echo Crypt::decrypt($facilitator->getdevotee->firstname); } ?>
                                            <?php if($facilitator->getdevotee->middlename != NULL){ echo Crypt::decrypt($facilitator->getdevotee->middlename); } ?>
                                            <?php if($facilitator->getdevotee->surname != NULL){ echo Crypt::decrypt($facilitator->getdevotee->surname); } ?>
                                          </option>
                                        @endforeach
                                      @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="branch">Branch <span class="required"></span></label>
                                    <select class="form-select" name="branch" id="branch" required>
                                        <option value="">Select One</option>
                                        @if ($branches->count() != null)
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="marks">Total Marks</label>
                                    <input type="number" class="form-control" name="marks" id="marks" required />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="fee">Course Fee</label>
                                    <input type="number" class="form-control" name="fee" id="fee" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="examtype">Exam Type</label>
                                    <select class="form-control" id="examtype" name="examtype" required>
                                      <option value="Written">Written</option>
                                      <option value="Verbal">Verbal</option>
                                      <option value="Both">Both</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="parent">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                      <option value="Draft">Draft</option>
                                      <option value="Active">Active</option>
                                      <option value="Not Started">Not Started</option>
                                      <option value="In Progress">In Progress</option>
                                      <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="unit" class="w-100">Duration</label>
                                    <input type="number" class="form-control d-inline-block w-25" name="unit" id="unit" required />
                                    <select class="form-select d-inline-block w-25" id="unitdays" name="unitdays" required>
                                        <option value="">Unit</option>
                                        <option value="Days">Days</option>
                                        <option value="Weeks">Weeks</option>
                                        <option value="Months">Months</option>
                                        <option value="Years">Years</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="text" class="form-control" name="start_date" id="start_date" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="text" class="form-control" name="end_date" id="end_date" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="Online">Online</option>
                                        <option value="Physical">Physical</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                              <div class="form-group">
                                  <label for="certificate">Blank Certificate</label>
                                  <input type="file" class="form-control" name="certificate" id="certificate" />
                              </div>
                            </div>
                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
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
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
@php
$today = date('Y-m-d');
$nextdate = date('Y-m-d', strtotime('+5 year'));
@endphp
<script type="text/javascript">
  $(document).ready(function() {
      $("#start_date").flatpickr();
      $("#end_date").flatpickr();
  });
</script>
@endsection
