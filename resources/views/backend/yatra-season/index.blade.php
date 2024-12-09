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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Yatra Season Management</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('yatra-season.index')}}" class="text-muted text-hover-primary">Yatra Season Management</a>
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <i class="ki-outline ki-plus fs-2"></i>Add Yatra Season</button>
                      </div>
                      <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_user_header">
                              <h2 class="fw-bold">Add</h2>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                              </div>
                            </div>
                            <div class="modal-body">
                              <form method="post" action="{{ route('yatra-season.store') }}" enctype="multipart/form-data">
                                @csrf
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                        <div class="form-group">
                                            <label for="catname">Yatra Season Name</label>
                                            <input type="text" class="form-control" name="name" id="name" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                        <div class="form-group">
                                            <label for="yatra">Yatra</label>
                                            <select class="form-select form-select-sm" data-control="select2" name="yatra" id="yatra" required>
                                              <option value="">Select One</option>
                                              @if($yatracategories->count() != NULL)
                                                @foreach($yatracategories as $yatracategorie)
                                                  <option value="{{$yatracategorie->id}}">{{$yatracategorie->title}}</option>
                                                @endforeach
                                              @endif
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                          <div class="form-group">
                                              <label for="price">Total Price</label>
                                              <input type="number" class="form-control" name="price" id="price" required />
                                          </div>
                                      </div>
                                      <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                          <div class="form-group">
                                              <label for="pricedetails">Price Details</label>
                                              <select class="form-control" id="pricedetails" name="pricedetails" required>
                                                  <option value="One Way">One Way</option>
                                                  <option value="Two Way">Two Way</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                          <div class="form-group">
                                              <label for="route">Route</label>
                                              <input type="text" class="form-control" name="route" id="route" required />
                                          </div>
                                      </div>
                                      <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                          <div class="form-group">
                                              <label for="parent">Status</label>
                                              <select class="form-control" id="status" name="status" required>
                                                  <option value="Active">Active</option>
                                                  <option value="Draft">Draft</option>
                                              </select>
                                          </div>
                                      </div>
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
                              <th>Name</th>
                              <th>Price</th>
                              <th>Price Details</th>
                              <th>Route</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($lists as $list)
                          <tr>
                            <td><a href="{{ route('yatra-season.show', $list->id)}}">{{$list->name}}</a></td>
                            <td>Rs. {{$list->price}}</td>
                            <td>{{$list->pricedetails}}</td>
                            <td>{{$list->route}}</td>
                            <td>
                              @if($list->status == 'Active') <span class="badge badge-light-success">Active</span> @endif
                              @if($list->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
                              @if($list->status == 'Trash') <span class="badge badge-light-danger">Trash</span> @endif
                            </td>
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <!--begin::Menu-->
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                @can('yatra-list')
                                <div class="menu-item px-3">
                                  <a href="{{ route('yatra-season.show', $list->id)}}" class="btn btn-light d-block">View</a>
                                </div>
                                @endcan
                                @can('yatra-edit')
                                <div class="menu-item px-3">
                                  <a href="{{ route('yatra-season.edit', $list->id)}}" class="btn btn-light d-block">Edit</a>
                                </div>
                                @endcan
                                @can('yatra-delete')
                                <div class="menu-item px-3">
                                  <form action="{{ route('yatra-season.destroy', $list->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete">Trash</button>
                                  </form>
                                </div>
                                @endcan
                              </div>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
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
<script src="{{asset('themes/assets/js/custom/apps/customers/list/export.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/apps/customers/list/list.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/users-search.js')}}"></script>
<script src="{{asset('themes/assets/js/custom/utilities/modals/users-search.js')}}"></script>
@endsection
