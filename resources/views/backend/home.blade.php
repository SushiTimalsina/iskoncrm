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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Admin Dashboard</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Dashboard</a>
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


                <div class="row gx-5 gx-xl-10 mb-xl-10">
                  <!--begin::Col-->
                  <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-10">

                    <div class="card card-flush">
                      <!--begin::Header-->
                      <div class="card-header pt-5">
                        <!--begin::Title-->
                        <h3 class="card-title text-gray-800"><strong>Devotees Highlights</strong></h3>
                      </div>
                      <div class="card-body pt-5">
                        <div class="d-flex flex-stack">
                          <div class="text-gray-700 fw-semibold fs-6 me-2">Total Devotees</div>
                          <div class="d-flex align-items-senter">
                            <i class="ki-outline ki-user fs-2 text-success me-2"></i>
                            <span class="text-gray-900 fw-bolder fs-6">{{$devotees->count()}}</span>
                          </div>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                          <div class="d-flex flex-stack">
                            <div class="text-gray-700 fw-semibold fs-6 me-2">Active Devotees</div>
                            <div class="d-flex align-items-senter">
                              <i class="ki-outline ki-user fs-2 text-success me-2"></i>
                              <span class="text-gray-900 fw-bolder fs-6">{{$activedevotees->count()}}</span>
                            </div>
                          </div>
                          <div class="separator separator-dashed my-3"></div>
                            <div class="d-flex flex-stack">
                              <div class="text-gray-700 fw-semibold fs-6 me-2">Imported Devotees</div>
                              <div class="d-flex align-items-senter">
                                <i class="ki-outline ki-user fs-2 text-success me-2"></i>
                                <span class="text-gray-900 fw-bolder fs-6">{{$importeddevotees->count()}}</span>
                              </div>
                            </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-10">
                    <div class="card card-flush">
                      <!--begin::Header-->
                      <div class="card-header pt-5">
                        <!--begin::Title-->
                        <h3 class="card-title text-gray-800"><strong>Mentor Highlights</strong></h3>
                      </div>
                      <div class="card-body pt-5">
                        <div class="d-flex flex-stack">
                          <div class="text-gray-700 fw-semibold fs-6 me-2">Total Mentors</div>
                          <div class="d-flex align-items-senter">
                            <i class="ki-outline ki-user fs-2 text-success me-2"></i>
                            <span class="text-gray-900 fw-bolder fs-6">{{$mentors->count()}}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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

<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('themes/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('themes/assets/plugins/custom/vis-timeline/vis-timeline.bundle.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('themes/assets/js/widgets.bundle.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/widgets.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/create-project/type.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/create-project/budget.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/create-project/settings.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/create-project/team.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/create-project/targets.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/create-project/files.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/create-project/complete.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/create-project/main.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/create-app.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/new-address.js')}}"></script>
@endsection
