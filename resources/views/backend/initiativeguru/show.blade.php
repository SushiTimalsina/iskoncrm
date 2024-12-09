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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Initiation Guru Details</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('initiative-guru.index')}}" class="text-muted text-hover-primary">Initiation Guru</a>
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


                      <div class="table-responsive">
                        <table class="table table-bordered">
                          <tr>
                            <th>Guru Name</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Created Date</th>
                            <th>Action</th>
                          </tr>
                          <tr>
                            <td><a href="{{ route('devotees.show', $show->name)}}">
                              @if($show->name != NULL){{Crypt::decrypt($show->getdevotee->firstname)}}@endif
                              @if($show->name != NULL){{Crypt::decrypt($show->getdevotee->middlename)}}@endif
                              @if($show->name != NULL){{Crypt::decrypt($show->getdevotee->surname)}}@endif
                            </a></td>
                            <td>
                              @if($show->status == 'Active') <span class="badge badge-light-success">Active</span> @endif
                              @if($show->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
                              @if($show->status == 'Trash') <span class="badge badge-light-danger">Trash</span> @endif
                            </td>
                            <td>{{$show->getcreatedby->name}}</td>
                            <td>{{$show->created_at}}</td>
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <!--begin::Menu-->
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                @can('initiative-edit')
                                <div class="menu-item px-3">
                                  <a href="{{ route('initiative-guru.edit', $show->id)}}" class="btn btn-light d-block">Edit</a>
                                </div>
                                @endcan
                                @can('initiative-delete')
                                <div class="menu-item px-3">
                                  <form action="{{ route('initiative-guru.destroy', $show->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete">Trash</button>
                                  </form>
                                </div>
                                @endcan
                              </div>
                            </td>
                          </tr>
                        </table>
                      </div>


                    @if($lists->count() != NULL)
                    <h3 class="mb-3">List of Devotees</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                              <th>SN</th>
                              <th>Devotee</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php $i = 1; @endphp
                          @foreach($lists as $list)
                          <tr>
                            <td>@php echo $i; @endphp</td>
                            <td><a href="{{ route('devotees.show', $list->id)}}">{{Helper::getdevoteebyid($list->devotee_id)->firstname}} {{Helper::getdevoteebyid($list->devotee_id)->middlename}} {{Helper::getdevoteebyid($list->devotee_id)->surname}}</a></td>
                          </tr>
                          @php $i++; @endphp
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    @else
                    <div class="demo-spacing-0"><div class="alert alert-primary" role="alert"><div class="alert-body">No devotee listing found!</div></div></div>
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
