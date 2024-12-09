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
      <div class="app-container container-fluid d-flex align-items-stretch" id="kt_app_header_container">
        <div class="app-header-wrapper d-flex flex-stack w-100">
          @include('backend.layouts.mobile-logo')
          <div id="kt_app_header_page_title_wrapper">
            <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_page_title_wrapper'}" class="page-title d-flex flex-column justify-content-center me-3 mb-6 mb-lg-0">
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Batch Management</h1>
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
                      <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{route('course-batch.create')}}" class="btn btn-primary"><i class="ki-outline ki-plus fs-2"></i>Add Batch</a>
                      </div>
                      @if (Route::currentRouteName() == 'coursebatchtrash')
                      <a href="{{route('course-batch.index')}}" type="button" class="btn btn-primary ms-2">
                      <i class="ki-outline ki-file fs-2"></i>All Lists</a>
                      @else
                      <a href="{{route('coursebatchtrash')}}" type="button" class="btn btn-primary ms-2">
                      <i class="ki-outline ki-trash fs-2"></i>Trash Folder</a>
                      @endif
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

                    @if($lists->count() != NULL)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                              <th>SN</th>
                              <th>Name</th>
                              <th>Branch</th>
                              <th>Course</th>
                              <th>Facilitator</th>
                              <th>Date</th>
                              <th>Type</th>
                              <th>Unit</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php $i = ($lists->perPage() * ($lists->currentPage() - 1)) + 1;; @endphp
                          @foreach($lists as $list)
                          <tr>
                            <td>{{$i}}</td>
                            <td><a href="{{ route('course-batch.show', $list->id)}}">{{$list->name}}</a></td>
                            <td>{{$list->getbranch->title}}</td>
                            <td>{{$list->getcourse->title}}</td>
                            <td><a href="{{ route('devotees.show', Helper::getdevoteebyfacilitator($list->facilitators_id)->id) }}">
                              @if(Helper::getdevoteebyfacilitator($list->facilitators_id) != NULL){{Crypt::decrypt(Helper::getdevoteebyfacilitator($list->facilitators_id)->firstname)}}@endif
                              @if(Helper::getdevoteebyfacilitator($list->facilitators_id) != NULL){{Crypt::decrypt(Helper::getdevoteebyfacilitator($list->facilitators_id)->middlename)}}@endif
                              @if(Helper::getdevoteebyfacilitator($list->facilitators_id) != NULL){{Crypt::decrypt(Helper::getdevoteebyfacilitator($list->facilitators_id)->surname)}}@endif
                            </a>
                            </td>
                            <td><strong>Start Date: </strong> {{$list->start_date}}<br /><strong>End Date: </strong>{{$list->end_date}}</td>
                            <td>{{$list->type}}</td>
                            <td>{{$list->unit}} Days</td>
                            <td>
                              @if($list->status == 'Completed') <span class="badge badge-light-success">Completed</span> @endif
                              @if($list->status == 'Active') <span class="badge badge-light-primary">Active</span> @endif
                              @if($list->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
                              @if($list->status == 'Not Started') <span class="badge badge-light-info">Not Started</span> @endif
                              @if($list->status == 'In Progress') <span class="badge badge-light-warning">In Progress</span> @endif
                            </td>
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                                @if (Route::currentRouteName() == 'coursebatchtrash')
                                @can('course-delete')
                                <div class="menu-item px-3">
                                  <a href="{{ route('coursebatchrestore', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-arrows-loop fs-2"></i> Restore</a>
                                </div>
                                <div class="menu-item px-3">
                                  <form action="{{ route('course-batch.destroy', $list->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i> Permanently Delete</button>
                                  </form>
                                </div>
                                @endcan
                                @else
                                @can('course-edit')
                                <div class="menu-item px-3">
                                  <a href="{{ route('course-batch.edit', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-pencil fs-2"></i> Edit</a>
                                </div>
                                @endcan
                                @can('course-delete')
                                <div class="menu-item px-3">
                                  <a href="{{ route('coursebatchmovetotrash', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-trash fs-2"></i> Trash</a>
                                </div>
                                @endcan
                                @endif
                              </div>
                            </td>
                          </tr>
                          @php $i++; @endphp
                          @endforeach
                        </tbody>
                      </table>
                      <div class="mt-2">{!! $lists->links() !!}</div>
                    </div>
                    @else
                    <div class="demo-spacing-0"><div class="alert alert-primary" role="alert"><div class="alert-body">No listing found!</div></div></div>
                    @endif
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
