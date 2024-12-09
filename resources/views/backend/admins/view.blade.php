@extends('backend.layouts.master')

@section('styles')
<link href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" rel="stylesheet" type="text/css" />
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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Admin Details</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('admins.index')}}" class="text-muted text-hover-primary">Admin Management</a>
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
                <!--begin::Card-->
                <div class="card">
                  <div class="card-header border-0 pt-6">
                    <div class="card-toolbar">
                      @can('user-edit')
                      <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{ route('admins.edit', $user->id)}}" class="btn btn-primary">
                        <i class="ki-outline ki-plus fs-2"></i>Edit Admin</a>
                      </div>

                      <div class="d-flex justify-content-end ms-3" data-kt-user-table-toolbar="base">
                        <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatePassword">
                        <i class="ki-outline ki-plus fs-2"></i>Update Password</a>
                      </div>
                      @endcan
                    </div>
                  </div>

                  <div class="modal fade" id="updatePassword" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                              <div class="modal-header" id="kt_modal_add_user_header">
                                  <h2 class="fw-bold">Update Password</h2>
                                  <button type="button"
                                      class="btn btn-icon btn-sm btn-active-icon-primary"
                                      data-bs-dismiss="modal">
                                      <i class="ki-outline ki-cross fs-1"></i>
                                  </button>
                              </div>
                              <div class="modal-body">
                                  <form method="POST"
                                      action="{{ route('admins.updatePassword', $user->id) }}"
                                      enctype="multipart/form-data">
                                      @csrf
                                      @method('POST')

                                      <div class="mb-3">
                                          <label for="password" class="form-label">Password</label>
                                          <input type="password" class="form-control" id="password"
                                              name="password" required>
                                      </div>

                                      <div class="mb-3">
                                          <label for="confirm-password" class="form-label">Confirm
                                              Password</label>
                                          <input type="password" class="form-control"
                                              id="confirm-password" name="confirm-password" required>
                                      </div>

                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-light"
                                              data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-primary">Update
                                              Password</button>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>

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

                  <div class="card-body py-4">
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

                  <table class="table table-bordered">
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>User Age</th>
                      <th>Status</th>
                    </tr>
                    <tr>
                      <td><a href="{{ route('devotees.show',$user->devotee_id) }}">@if($user->name != NULL){{Crypt::decrypt($user->name)}}@endif</a></td>
                      <td>{{$user->email}}</td>
                      <td>{{ \Carbon\Carbon::parse($user->created_at)->diffForhumans() }}</td>
                      <td>
                        @if($user->status == 'Active') <span class="badge badge-light-success">Active</span> @endif
                        @if($user->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
                        @if($user->status == 'Deactivated') <span class="badge badge-light-danger">Deactivated</span> @endif
                      </td>
                    </tr>
                    <tr>
                      <th>Department Role</th>
                      <th>Branch</th>
                      <th>Last Activity</th>
                      <th></th>
                    </tr>
                    <tr>
                      <td>
                        <div class="badge badge-light fw-bold">
                          @if($user->is_admin == 0)<span class="badge badge-secondary">User</span>@endif
                          @if($user->is_admin == 1)<span class="badge badge-primary">Super Admin</span>@endif
                          @if($user->is_admin == 2)<span class="badge badge-success">Branch Admin</span>@endif
                        </div>
                      </td>
                      <td>@if($user->branch_id != NULL) {{$user->getbranch->title}} @endif</td>
                      <td>{{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</td>
                      <td></td>
                    </tr>
                  </table>
                  </div>

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
@endsection
