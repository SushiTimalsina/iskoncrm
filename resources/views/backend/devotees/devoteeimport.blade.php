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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Devotee Import</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('devotees.index')}}" class="text-muted text-hover-primary">Devotee Management</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Devotee Import</li>
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
                  <div class="card-body pr-5 pl-5">
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

                    @if(session()->has('failures'))
                      <table class="table table-danger table-bordered">
                        <tr>
                          <th>Row</th>
                          <th>Attribute</th>
                          <th>Errors</th>
                          <th>Value</th>
                        </tr>
                        @foreach(session()->get('failures') as $validation)
                        <tr>
                            <td>{{ $validation->row() }}</td>
                            <td>{{ $validation->attribute() }}</td>
                            <td>
                              <ul>
                              @foreach($validation->errors() as $e)
                                <li>{{$e}} </li>
                              @endforeach
                              </ul>
                            </td>
                            <td>{{ $validation->values()[$validation->attribute()] }}</td>
                          </tr>
                          @endforeach
                        </table>
                      @endif

                    <form method="post" action="{{ route('devoteesimport') }}" enctype="multipart/form-data">
          						@csrf
                      <div class="card-body">
                        <section>
                            <div class="row">
                              <div class="col-md-3">
                                  <div class="form-group">
                                    <input type="file" class="form-control" name="csvfile" id="csvfile" required />
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Import</button>
                                  <button type="reset" class="btn btn-outline-secondary">Reset</button>
                              </div>
                            </div>
                        </section>
                        <div class="mt-5 mb-2"><a href="{{ route('devoteeimport.show', ['imageName' => 'import-format.csv']) }}" class="btn btn-primary me-3">Download CSV Format Template</a></div>
                        <div class="mt-5 mb-2">
                          <h3>CSV Import Columns</h3>
                          <img src="{{asset('images/importcolumns.png')}}" width="60%" />
                        </div>
                      </div>
                    </form>
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
