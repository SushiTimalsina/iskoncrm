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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Edit Yatra Category</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('yatra-category.index')}}" class="text-muted text-hover-primary">Yatra Category Management</a>
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


                    <form method="post" action="{{ route('yatra-season.update', $edit->id ) }}" enctype="multipart/form-data">
          						@csrf
          						@method('PATCH')
                      <div class="card-body">
                          <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6 mb-2">
                                <div class="form-group">
                                    <label for="catname">Yatra Season Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{$edit->name}}" required />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6 mb-2">
                                <div class="form-group">
                                    <label for="yatra">Yatra</label>
                                    <select class="form-select form-select-sm" data-control="select2" name="yatra" id="yatra" required>
                                      <option value="">Select One</option>
                                      @if($yatracategories->count() != NULL)
                                        @foreach($yatracategories as $yatracategorie)
                                          <option value="{{$yatracategorie->id}}" {{ $edit->yatra_id == $yatracategorie->id ? 'selected' : '' }}>{{$yatracategorie->title}}</option>
                                        @endforeach
                                      @endif
                                    </select>
                                </div>
                              </div>
                              <div class="col-md-6 col-sm-6 col-lg-6 mb-2">
                                  <div class="form-group">
                                      <label for="price">Total Price</label>
                                      <input type="number" class="form-control" name="price" id="price" value="{{$edit->price}}" required />
                                  </div>
                              </div>
                              <div class="col-md-6 col-sm-6 col-lg-6 mb-2">
                                  <div class="form-group">
                                      <label for="pricedetails">Price Details</label>
                                      <select class="form-control" id="pricedetails" name="pricedetails" required>
                                          <option value="One Way" {{ $edit->pricedetails == 'One Way' ? 'selected' : '' }}>One Way</option>
                                          <option value="Two Way" {{ $edit->pricedetails == 'Two Way' ? 'selected' : '' }}>Two Way</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-6 col-sm-6 col-lg-6 mb-2">
                                  <div class="form-group">
                                      <label for="route">Route</label>
                                      <input type="text" class="form-control" name="route" id="route" value="{{$edit->route}}" required />
                                  </div>
                              </div>
                              <div class="col-md-6 col-sm-6 col-lg-6 mb-2">
                                  <div class="form-group">
                                      <label for="parent">Status</label>
                                      <select class="form-control" id="status" name="status" required>
                                        <option value="Active" {{ $edit->status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Draft" {{ $edit->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Trash" {{ $edit->status == 'Trash' ? 'selected' : '' }}>Trash</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                  <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Update</button>
                              </div>
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
