@extends('backend.layouts.master')

@section('styles')
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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Donation Details</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('donation.index')}}" class="text-muted text-hover-primary">Donations</a>
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
                  <div class="card-header border-0 pt-6">
                    <div class="card-toolbar">
                      @can('donation-edit')
                      <div class="d-flex ms-3 justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{ route('donation.edit', $show->id)}}" class="btn btn-primary">
                        <i class="ki-outline ki-pencil fs-2"></i>Edit</a>
                      </div>
                      @endcan
                      @can('donation-delete')
                      <div class="d-flex ms-3 justify-content-end" data-kt-user-table-toolbar="base">
                        <form action="{{ route('donation.destroy', $show->id)}}" method="post">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i>Trash</button>
                        </form>
                      </div>
                      @endcan
                    </div>
                  </div>
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

                    <h3 class="mb-2">Donation Details</h3>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <tr>
                          <th>Devotee</th>
                          <td>
                            @if($show->getdevotee->firstname != NULL){{Crypt::decrypt($show->getdevotee->firstname)}}@endif
                            @if($show->getdevotee->middlename != NULL){{Crypt::decrypt($show->getdevotee->middlename)}}@endif
                            @if($show->getdevotee->surname != NULL){{Crypt::decrypt($show->getdevotee->surname)}}@endif
                          </td>
                        </tr>
                        <tr>
                          <th>Branch</th>
                          <td>{{$show->getbranch->title}}</td>
                        </tr>
                        @if($show->sewa_id != NULL)
                        <tr>
                          <th>Sewa</th>
                          <td>{{$show->getsewa->title}}</td>
                        </tr>
                        @endif
                        @if($show->yatra_seasons_id != NULL)
                        <tr>
                          <th>Yatra Season</th>
                          <td>{{$show->yatra_seasons_id}}</td>
                        </tr>
                        @endif
                        @if($show->course_batch_id != NULL)
                        <tr>
                          <th>Course Batch</th>
                          <td>{{Helper::getcourcebatch($show->course_batch_id)->name}}</td>
                        </tr>
                        @endif
                        <tr>
                          <th>Title</th>
                          <td>{{$show->title}}</td>
                        </tr>
                        <tr>
                          <th>Donation</th>
                          <td>Rs. {{$show->donation}}</td>
                        </tr>
                        <tr>
                          <th>Donation Type</th>
                          <td>{{$show->donationtype}}</td>
                        </tr>
                        <tr>
                          <th>Status</th>
                          <td>
                            @if($show->status == 'Paid') <span class="badge badge-light-success">Paid</span> @endif
                            @if($show->status == 'Pending') <span class="badge badge-light-info">Pending</span> @endif
                            @if($show->status == 'Schedule') <span class="badge badge-light-primary">Schedule</span> @endif
                            @if($show->status == 'Refund') <span class="badge badge-light-danger">Refund</span> @endif
                            @if($show->status == 'Cancelled') <span class="badge badge-light-danger">Cancelled</span> @endif
                          </td>
                        </tr>
                      </table>
                    </div>
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
@endsection
