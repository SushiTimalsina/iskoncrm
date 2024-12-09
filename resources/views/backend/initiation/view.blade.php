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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">View Initiation</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('initiation.index')}}" class="text-muted text-hover-primary">Initiation Management</a>
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
                    @can('initiative-create')
                    <a href="{{route('initiation.store')}}" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#add_files"><i class="ki-outline ki-plus"></i>Add Files</a>
                    <div class="modal fade" id="add_files" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered mw-650px">
                        <div class="modal-content">
                          <div class="modal-header" id="kt_modal_add_user_header">
                            <h2 class="fw-bold">Add Files</h2>
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                              <i class="ki-outline ki-cross fs-1"></i>
                            </div>
                          </div>
                          <div class="modal-body">
                            <form method="post" action="{{ route('initiation-files.store') }}" enctype="multipart/form-data">
                              @csrf
                              <input type="hidden" id="initiationid" name="initiationid" value="{{$show->id}}" />
                              <div class="row mb-2">
                                <div class="form-group">
                                   <label for="files">Files Upload</label>
                                   <input type="file" class="form-control" name="files[]" id="files" multiple />
                                </div>
                              </div>
                              <div class="row mb-2">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Upload</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endcan
                    @can('initiative-edit')
                    <a href="{{route('initiation.edit', $show->id)}}" class="btn btn-primary me-3"><i class="ki-outline ki-pencil"></i>Edit</a>
                    @endcan
                    @can('initiative-delete')
                    <div class="menu-item px-3">
                      <form action="{{ route('initiation.destroy', $show->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary me-3" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash"></i>Trash</button>
                      </form>
                    </div>
                    @endcan
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

                <div class="table-responsive">
                  <table class="table table-bordered">
                    <tr>
                      <th>Devotee Name</th>
                      <td><a href="{{ route('devotees.show', $show->devotee_id)}}">{{$show->getdevotee->firstname}} {{$show->getdevotee->middlename}} {{$show->getdevotee->surname}}</a></td>
                    </tr>
                    <tr>
                      <th>Guru</th>
                      <td><a href="{{ route('devotees.show', $show->getinitiationguru->name)}}">{{Helper::getdevoteebyinitiationguruid($show->initiation_guru_id)->firstname}} {{Helper::getdevoteebyinitiationguruid($show->initiation_guru_id)->middlename}} {{Helper::getdevoteebyinitiationguruid($show->initiation_guru_id)->surname}}</a></td>
                    </tr>
                    <tr>
                      <th>Initation Name</th>
                      <td>{{$show->initiation_name}}</td>
                    </tr>
                    <tr>
                      <th>Initiated Date</th>
                      <td>{{$show->initiation_date}}</td>
                    </tr>
                    <tr>
                      <th>Initiation Type</th>
                      <td>{{$show->initiation_type}}</td>
                    </tr>
                    <tr>
                      <th>Witness</th>
                      <td>{{Helper::getdevoteebymentor($show->witness)->firstname}} {{Helper::getdevoteebymentor($show->witness)->middlename}} {{Helper::getdevoteebymentor($show->witness)->surname}}</td>
                    </tr>
                    <tr>
                      <th>Remarks</th>
                      <td>{{$show->remarks}}</td>
                    </tr>
                    <tr>
                      <th>Files</th>
                      <td>
                        @if(!empty($files))
                        <ul>
                          @foreach($files as $file)
                            <li>
                              <span class="d-inline-block"><a href="{{ route('initiationfile.show', ['imageName' => $file->photo]) }}" target="_blank">{{$file->photo}}</a></span>
                              @can('initiative-delete')
                                <form action="{{ route('initiation-files.destroy', $file->id)}}" method="post" class="d-inline-block">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash text-primary "></i></button>
                                </form>
                              @endcan
                            </li>
                          @endforeach
                        </ul>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <th>Disciple Confirm</th>
                      <td>
                        @if($show->discipleconfirm == 1) <span class="badge badge-light-success">Confirmed</span> @endif
                        @if($show->discipleconfirm == 0) <span class="badge badge-light-danger">Not Confirmed</span> @endif
                      </td>
                    </tr>
                    <tr>
                      <th>Created By</th>
                      <td>{{$show->createdby}}<br />{{ \Carbon\Carbon::parse($show->created_at)->diffForhumans() }}</td>
                    </tr>
                    <tr>
                      <th>Updated By</th>
                      <td>@if($show->updatedby != NULL){{$show->updatedby}}<br />{{ \Carbon\Carbon::parse($show->updated_at)->diffForhumans() }}@endif</td>
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
