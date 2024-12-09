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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Occupations Management</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('occupations.index')}}" class="text-muted text-hover-primary">Occupations Management</a>
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


                    <form method="get" action="{{route('occupationsearch')}}" enctype="multipart/form-data">
                      <!--begin::Card-->
                      <div class="card mb-7">

                        <!--begin::Card body-->
                        <div class="card-body">
                          <!--begin::Compact form-->
                          <div class="d-flex align-items-center">
                            <!--begin::Input group-->
                            <div class="position-relative w-md-600px me-md-2">
                              <i class="ki-outline ki-magnifier fs-3 text-gray-500 position-absolute top-50 translate-middle ms-6" style="z-index:9999;"></i>
                              <input class="form-control ps-10" value="" placeholder="Search Occupations" id="search" name="search" @if(isset($_GET['search'])) value="{{$_GET['search']}}" @endif  autocomplete="off" required  />
                            </div>
                            <!--end::Input group-->
                            <!--begin:Action-->
                            <div class="d-flex align-items-center me-2">
                              <button type="submit" class="btn btn-primary me-5">Search</button>
                            </div>
                            <div id="search_list"></div>
                          </div>
                          </div>
                        </div>
                    </form>


                <div class="card">
                  <div class="card-header border-0 pt-6">
                    <div class="card-toolbar">
                      <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <i class="ki-outline ki-plus fs-2"></i>Add Occupation</button>
                        @if (Route::currentRouteName() == 'occupationtrash')
                        <a href="{{route('occupations.index')}}" type="button" class="btn btn-primary ms-2">
                        <i class="ki-outline ki-file fs-2"></i>All Lists</a>
                        @else
                        <a href="{{route('occupationtrash')}}" type="button" class="btn btn-primary ms-2">
                        <i class="ki-outline ki-trash fs-2"></i>Trash Folder</a>
                        @endif
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
                              <form method="post" action="{{ route('occupations.store') }}" enctype="multipart/form-data">
                                @csrf
                                  <div class="row">
                                      <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                          <div class="form-group">
                                              <label for="catname">Occupation Name</label>
                                              <input type="text" class="form-control" name="name" id="name" required />
                                          </div>
                                      </div>
                                      <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                          <div class="form-group">
                                              <label for="parent">Parent</label>
                                              <select class="form-control" data-control="select2" id="parent" name="parent">
                                                  <option value="">Select One</option>
                                                  @if($parentlists->count() != NULL)
                                                    @foreach($parentlists as $plist)
                                                      <option value="{{$plist->id}}">{{$plist->title}}</option>
                                                    @endforeach
                                                  @endif
                                              </select>
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
                              <th>SN</th>
                              <th>Name</th>
                              <th>Devotees</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php $i = ($lists->perPage() * ($lists->currentPage() - 1)) + 1;; @endphp
                          @foreach($lists as $list)
                          <tr>
                            <td>{{$i}}</td>
                            <td><a href="{{ route('occupations.show', $list->id)}}">{{$list->title}}</a></td>
                            <td>
                              @php
                              $getdevotees = \App\Models\Devotees::where('occupations', $list->id)->get();
                              echo $getdevotees->count();
                              @endphp
                            </td>
                            <td>
                              @if($list->status == 'Active') <span class="badge badge-light-success">Active</span> @endif
                              @if($list->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
                            </td>
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <!--begin::Menu-->
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                                  @if (Route::currentRouteName() == 'occupationtrash')
                                  @can('occupations-edit')
                                  <div class="menu-item px-3">
                                    <a href="{{ route('occupations.edit', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-pencil fs-2"></i> Edit</a>
                                  </div>
                                  @endcan
                                  @can('occupations-delete')
                                  <div class="menu-item px-3">
                                    <a href="{{ route('occupationrestore', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-arrows-loop fs-2"></i> Restore</a>
                                  </div>
                                  <div class="menu-item px-3">
                                    <form action="{{ route('occupations.destroy', $list->id)}}" method="post">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i> Permanently Delete</button>
                                    </form>
                                  </div>
                                  @endcan
                                  @else
                                  @can('occupations-edit')
                                  <div class="menu-item px-3">
                                    <a href="{{ route('occupations.edit', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-pencil fs-2"></i> Edit</a>
                                  </div>
                                  @endcan
                                  @can('occupations-delete')
                                  <div class="menu-item px-3">
                                    <a href="{{ route('occupationmovetotrash', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-trash fs-2"></i> Trash</a>
                                  </div>
                                  @endcan
                                  @endif
                              </div>
                            </td>
                          </tr>
                          @if(count($list->subcategory))
                            @include('backend.occupations.subCategoryList',['subcategories' => $list->subcategory])
                          @endif
                          <?php $i++; ?>
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
