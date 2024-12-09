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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Admin Management</h1>
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

                <form method="get" action="{{route('adminsearch')}}" enctype="multipart/form-data">
                  <!--begin::Card-->
                  <div class="card mb-7">

                    <!--begin::Card body-->
                    <div class="card-body">
                      <!--begin::Compact form-->
                      <div class="row align-items-center">
                        <div class="col-lg-2">
                          <label class="fs-6 form-label fw-bold text-gray-900" for="user">Admin</label>
                          <select class="form-select" name="user" data-control="select2">
                            <option value="">Select User</option>
                            @if($listusers->count() != NULL)
                              @foreach($listusers as $listuser)
                                <option value="{{$listuser->id}}" @if(isset($_GET['user']) && ($_GET['user'] == $listuser->id)) selected @endif>@if($listuser->name != NULL){{Crypt::decrypt($listuser->name)}}@endif</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                        <div class="col-lg-2">
                          <label class="fs-6 form-label fw-bold text-gray-900" for="branch">Branch</label>
                          <select class="form-select" name="branch" data-control="select2">
                            <option value="">Select Branch</option>
                            @if($branches->count() != NULL)
                              @foreach($branches as $branch)
                                <option value="{{$branch->id}}" @if(isset($_GET['branch']) && ($_GET['branch'] == $branch->id)) selected @endif>{{$branch->title}}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                        <div class="col-lg-2">
                          <label class="fs-6 form-label fw-bold text-gray-900" for="status">Status</label>
                          <select class="form-select" name="status" data-control="select2">
                            <option value="">Select Status</option>
                            <option value="Active" @if(isset($_GET['status']) && ($_GET['status'] == 'Active')) selected @endif>Active</option>
                            <option value="Draft" @if(isset($_GET['status']) && ($_GET['status'] == 'Draft')) selected @endif>Draft</option>
                            <option value="Deactivated" @if(isset($_GET['status']) && ($_GET['status'] == 'Deactivated')) selected @endif>Deactivated</option>
                          </select>
                        </div>
                        <div class="col-md-2 col-md-2 col-lg-2">
                          <input type="hidden" name="search" value="true" />
                          <button type="submit" class="btn btn-primary me-5 mt-7">Search</button>
                        </div>
                      </div>
                      </div>
                    </div>
                </form>


                <!--begin::Card-->
                <div class="card">

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


                  <!--begin::Card header-->
                  <div class="card-header border-0 pt-6">
                    <div class="card-toolbar">
                      <!--begin::Toolbar-->
                      <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{route('admins.create')}}" class="btn btn-primary" >
                        <i class="ki-outline ki-plus fs-2"></i>Add Admin</a>
                        <!--end::Add user-->
                      </div>
                    </div>
                    <!--end::Card toolbar-->
                  </div>
                  <!--end::Card header-->
                  <!--begin::Card body-->
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

                    <!--begin::Table-->
                    <table class="table table-bordered" id="kt_table_users">
                      <thead>
                        <tr>
                          <th>Admin</th>
                          <th>Branch</th>
                          <th>Branch Status</th>
                          <th>Role</th>
                          <th>Is On?</th>
                          <th>Joined Date</th>
                          <th>Login IP</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody class="text-gray-600 fw-semibold">
                      @foreach($users as $user)
                      <tr>
                        <td>
                          <!--begin::User details-->
                          <div class="d-flex flex-column">
                            @if($user->name != NULL){{Crypt::decrypt($user->name)}}@endif @if($user->devotee_id)<a href="{{ route('devotees.show',$user->devotee_id) }}" class="text-gray-800 text-hover-primary mb-1"><i class="ki-outline ki-arrow"></i></a>@endif
                            <span>{{$user->email}}</span>
                          </div>
                        </td>
                        <td>@if($user->branch_id != NULL) {{$user->getbranch->title}} @endif</td>
                        <td>
                          <div class="badge badge-light fw-bold">
                            @if($user->is_admin == 0)<span class="badge badge-secondary">User</span>@endif
                            @if($user->is_admin == 1)<span class="badge badge-primary">Super Admin</span>@endif
                            @if($user->is_admin == 2)<span class="badge badge-success">Branch Admin</span>@endif
                          </div>
                        </td>
                        <td>
                          @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                            <span class="badge badge-light">{{ $v }}</span>
                            @endforeach
                            @endif
                        </td>
                        <td>
                          <div class="badge badge-light fw-bold">
                            @if(Cache::has('is_online' . $user->id))
                                <span class="badge badge-light-success">Online</span>
                            @else
                                <span class="badge badge-light-danger">Offline</span>
                            @endif
                          </div><br />
                          {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                        </td>
                        <td>{{$user->created_at}}</td>
                        <td>{{$user->loginip}}</td>
                        <td>
                            @if($user->status == 'Active') <span class="badge badge-light-success">Active</span> @endif
                            @if($user->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
                            @if($user->status == 'Deactivated') <span class="badge badge-light-danger">Deactivated</span> @endif
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                          <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                          <!--begin::Menu-->
                          <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                            @can('admin-list')
                            <div class="menu-item px-3">
                              <a href="{{route('admins.show', $user->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-eye fs-2"></i> View</a>
                            </div>
                            @endcan

                            @can('admin-edit')
                            <div class="menu-item px-3">
                              <a href="{{ route('admins.edit', $user->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-pencil fs-2"></i> Edit</a>
                            </div>
                            @endcan

                            @if($user->id != Auth::guard('admin')->id())
                            <div class="menu-item px-3">
                              <form action="{{ route('admins.destroy', $user->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i> Delete</button>
                              </form>
                            </div>
                            @endif
                            <!--end::Menu item-->
                          </div>
                          <!--end::Menu-->
                        </td>
                      </tr>
                      @endforeach
                      </tbody>
                    </table>
                    <!--end::Table-->
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
