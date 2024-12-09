@extends('backend.layouts.master')
@section('styles')
<link href="{{asset('themes/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('themes/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">
                @if (Route::currentRouteName() == 'devoteetrash')
                Devotee Management (Trash)
                @else
                Devotee Management
                @endif
                </h1>
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

                <form method="get" action="{{route('devoteesearch')}}" enctype="multipart/form-data">
                  @csrf
                  <!--begin::Card-->
                  <div class="card mb-7">

                    <!--begin::Card body-->
                    <div class="card-body">
                      <!--begin::Compact form-->
                      <div class="d-flex align-items-center">
                        <!--begin::Input group-->
                        <div class="position-relative w-md-600px me-md-2">
                          <!--<input class="form-control" value="" placeholder="Search devotee by name or email or mobile or initiated name..." id="search" name="search" />-->
                          <select class="form-control" name="search[]" id="search" multiple required>
                            <option value="">Search devotee by name or email or mobile or initiated name...</option>
                            @if($devotees->count() != NULL)
                              @foreach($devotees as $devotee)
                              <?php $name = ''; ?>
                              <?php if($devotee->firstname != NULL){ $name .= Crypt::decrypt($devotee->firstname).'-'; } ?>
                              <?php if($devotee->middlename != NULL){ $name .= Crypt::decrypt($devotee->middlename).'-'; } ?>
                              <?php if($devotee->surname != NULL){ $name .= Crypt::decrypt($devotee->surname); } ?>
                              <option value="{{$devotee->id}}"
                                data-kt-rich-content-email="<?php if($devotee->email_enc != NULL){ echo Crypt::decrypt($devotee->email_enc); } ?>"
                                data-kt-rich-content-mobile="<?php if($devotee->mobile_enc != NULL){ echo Crypt::decrypt($devotee->mobile_enc); } ?>"
                                data-kt-rich-content-initiation="@if(Helper::getinitiationrow($devotee->id)) {{Helper::getinitiationrow($devotee->id)->initiation_name}} @endif"
                                 @if(isset($_GET['devotee']) && ($_GET['devotee'] == $devotee->id)) selected @endif
                                >{{$name}}
                                </option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                        <div class="d-flex align-items-center">
                          <button type="submit" class="btn btn-primary me-5">Search</button>  <a href="{{route('devotees.index')}}" class="btn btn-primary me-5">Reset</a>
                          <a href="#" id="kt_horizontal_search_advanced_link" class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#kt_advanced_search_form">Advanced Search</a>
                        </div>
                        <div id="search_list"></div>
                      </div>
                      <div class="collapse" id="kt_advanced_search_form">
                        <div class="separator separator-dashed mt-9 mb-6"></div>
                        <div class="row g-8 mb-8">
                          <div class="col-xxl-12">
                            <div class="row g-8">
                              <div class="col-lg-4">
                                <label class="fs-6 form-label fw-bold text-gray-900" for="daterange">Select Date Range</label>
                                <input type="text" class="form-control" name="daterange" id="daterange"  @if(isset($_GET['daterange'])) value="{{$_GET['daterange']}}" @endif autocomplete="off" />
                              </div>
                              <div class="col-lg-2">
                                <label class="fs-6 form-label fw-bold text-gray-900" for="mentor">Mentor</label>
                                <select class="form-select" data-control="select2" name="mentor" id="mentor">
                                  <option value="">Select One</option>
                                  @if($mentors->count() != NULL)
                                    @foreach($mentors as $mentor)
                                      <option value="{{$mentor->id}}" @if(isset($_GET['mentor']) && ($_GET['mentor'] == $mentor->id)) selected @endif>{{Crypt::decrypt($mentor->getdevotee->firstname)}} {{Crypt::decrypt($mentor->getdevotee->middlename)}} {{Crypt::decrypt($mentor->getdevotee->surname)}}</option>
                                    @endforeach
                                  @endif
                                </select>
                              </div>
                              <div class="col-lg-3">
                                <label class="fs-6 form-label fw-bold text-gray-900" for="initiationtype">Initiation Type</label>
                                <select class="form-select" data-control="select2" name="initiationtype" id="initiationtype">
                                  <option value="">Select One</option>
                                  <option value="Sheltered" @if(isset($_GET['initiationtype']) && ($_GET['initiationtype'] == 'Sheltered')) selected @endif>Sheltered</option>
                                  <option value="Harinam Initiation" @if(isset($_GET['initiationtype']) && ($_GET['initiationtype'] == 'Harinam Initiation')) selected @endif>Harinam Initiation</option>
                                  <option value="Brahman Initiation" @if(isset($_GET['initiationtype']) && ($_GET['initiationtype'] == 'Brahman Initiation')) selected @endif>Brahman Initiation</option>
                                </select>
                              </div>
                              <div class="col-lg-3">
                                <label class="fs-6 form-label fw-bold text-gray-900" for="initiationby">Initiation By</label>
                                <select class="form-select" data-control="select2" name="initiationby" id="initiationby">
                                  <option value="">Select One</option>
                                @if($gurus->count() != NULL)
                                  @foreach($gurus as $guru)
                                    <option value="{{$guru->id}}" @if(isset($_GET['initiationby']) && ($_GET['initiationby'] == $guru->id)) selected @endif>{{$guru->name}}</option>
                                  @endforeach
                                @endif
                              </select>
                              </div>
                            </div>
                            <div class="row g-8 mt-3">
                              <div class="col-lg-3">
                                <label class="fs-6 form-label fw-bold text-gray-900" for="bloodgroup">Blood Group</label>
                                <select class="form-select" name="bloodgroup">
                                  <option value="">Select Blood Group</option>
                                  <option value="A+" @if(isset($_GET['bloodgroup']) && ($_GET['bloodgroup'] == 'A+')) selected @endif>A+</option>
                                  <option value="A-" @if(isset($_GET['bloodgroup']) && ($_GET['bloodgroup'] == 'A-')) selected @endif>A-</option>
                                  <option value="B+" @if(isset($_GET['bloodgroup']) && ($_GET['bloodgroup'] == 'B+')) selected @endif>B+</option>
                                  <option value="B-" @if(isset($_GET['bloodgroup']) && ($_GET['bloodgroup'] == 'B-')) selected @endif>B-</option>
                                  <option value="O+" @if(isset($_GET['bloodgroup']) && ($_GET['bloodgroup'] == 'O+')) selected @endif>O+</option>
                                  <option value="O-" @if(isset($_GET['bloodgroup']) && ($_GET['bloodgroup'] == 'O-')) selected @endif>O-</option>
                                  <option value="AB+" @if(isset($_GET['bloodgroup']) && ($_GET['bloodgroup'] == 'AB+')) selected @endif>AB+</option>
                                  <option value="AB-" @if(isset($_GET['bloodgroup']) && ($_GET['bloodgroup'] == 'AB-')) selected @endif>AB-</option>
                                </select>
                              </div>
                              <div class="col-lg-2">
                                <label class="fs-6 form-label fw-bold text-gray-900" for="education">Education</label>
                                <select class="form-select" name="education">
                                  <option value="">Select Education</option>
                                  <option value="Literate" @if(isset($_GET['education']) && ($_GET['education'] == 'Literate')) selected @endif>Literate</option>
                                  <option value="District Level" @if(isset($_GET['education']) && ($_GET['education'] == 'District Level')) selected @endif>District Level</option>
                                  <option value="SLC-SEE" @if(isset($_GET['education']) && ($_GET['education'] == 'SLC-SEE')) selected @endif>SLC/SEE</option>
                                  <option value="+2" @if(isset($_GET['education']) && ($_GET['education'] == '+2')) selected @endif>+2</option>
                                  <option value="Bachelor" @if(isset($_GET['education']) && ($_GET['education'] == 'Bachelor')) selected @endif>Bachelor</option>
                                  <option value="Master" @if(isset($_GET['education']) && ($_GET['education'] == 'Master')) selected @endif>Master</option>
                                </select>
                              </div>
                              <div class="col-lg-3">
                                <label class="fs-6 form-label fw-bold text-gray-900" for="occupation">Occupation</label>
                                <select class="form-select" data-control="select2" name="occupation" id="occupation">
                                  <option value="">Select One</option>
                                  @if($occupations->count() != NULL)
                                    @foreach($occupations as $occupation)
                                      <option value="{{$occupation->id}}" @if(isset($_GET['occupation']) && ($_GET['occupation'] == $occupation->id)) selected @endif>{{$occupation->title}}</option>

                                      @if ($occupation->subcategory)
                                          @foreach ($occupation->subcategory as $child)
                                              <option value="{{ $child->id }}" @if(isset($_GET['occupation']) && ($_GET['occupation'] == $occupation->id)) selected @endif>&nbsp;&nbsp;-- {{ $child->title }}</option>
                                          @endforeach
                                      @endif
                                    @endforeach
                                  @endif
                                </select>
                              </div>
                              <div class="col-lg-2">
                                <label class="fs-6 form-label fw-bold text-gray-900" for="gotra">Gotra</label>
                                <select class="form-select" data-control="select2" name="gotra" id="gotra">
                                  <option value="">Select One</option>
                                  <option value="⁠Agasti" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Agasti')) selected @endif>⁠Agasti</option>
                                  <option value="⁠Angira" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Angira')) selected @endif>⁠Angira</option>
                                  <option value="⁠Atri" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Atri')) selected @endif>⁠Atri</option>
                                  <option value="⁠Aatreya" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Aatreya')) selected @endif>⁠Aatreya</option>
                                  <option value="⁠Bharadwaaj" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Bharadwaaj')) selected @endif>⁠Bharadwaaj</option>
                                  <option value="⁠Dhananjaya" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Dhananjaya')) selected @endif>⁠Dhananjaya</option>
                                  <option value="⁠Garg" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Garg')) selected @endif>⁠Garg</option>
                                  <option value="⁠Gautam" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Gautam')) selected @endif>⁠Gautam</option>
                                  <option value="⁠Ghrita Kaushik" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Ghrita Kaushik')) selected @endif>⁠Ghrita Kaushik</option>
                                  <option value="⁠Kapil" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Kapil')) selected @endif>⁠Kapil</option>
                                  <option value="⁠Kashyap" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Kashyap')) selected @endif>⁠Kashyap</option>
                                  <option value="⁠Kaudinya" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Kaudinya')) selected @endif>⁠Kaudinya</option>
                                  <option value="⁠Kausalya" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Kausalya')) selected @endif>⁠Kausalya</option>
                                  <option value="⁠Kausik" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Kausik')) selected @endif>⁠Kausik</option>
                                  <option value="⁠Kundin" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Kundin')) selected @endif>⁠Kundin</option>
                                  <option value="⁠Mandabya" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Mandabya')) selected @endif>⁠Mandabya</option>
                                  <option value="⁠Maudagalya" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Maudagalya')) selected @endif>⁠Maudagalya</option>
                                  <option value="⁠Parasar" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Parasar')) selected @endif>⁠Parasar</option>
                                  <option value="⁠Ravi" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Ravi')) selected @endif>⁠Ravi</option>
                                  <option value="⁠Sankhyayan" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Sankhyayan')) selected @endif>⁠Sankhyayan</option>
                                  <option value="⁠Shandilya" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Shandilya')) selected @endif>⁠Shandilya</option>
                                  <option value="⁠Upamanyu" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Upamanyu')) selected @endif>⁠Upamanyu</option>
                                  <option value="⁠Vishwamitra" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Vishwamitra')) selected @endif>⁠Vishwamitra</option>
                                  <option value="⁠Vatsa" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Vatsa')) selected @endif>⁠Vatsa</option>
                                  <option value="⁠Vashishta" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Vashishta')) selected @endif>⁠Vashishta</option>
                                  <option value="⁠Adhigata (Dashnami Sanyasi)" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Adhigata (Dashnami Sanyasi)')) selected @endif>⁠Adhigata (Dashnami Sanyasi)</option>
                                  <option value="⁠Kashyap (Dashnami Sanyasi)" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Kashyap (Dashnami Sanyasi)')) selected @endif>⁠Kashyap (Dashnami Sanyasi)</option>
                                  <option value="⁠Bhaveswa (Dashnami Sanyasi)" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Bhaveswa (Dashnami Sanyasi)')) selected @endif>⁠Bhaveswa (Dashnami Sanyasi)</option>
                                  <option value="⁠Bhrigu (Dashnami Sanyasi)" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Bhrigu (Dashnami Sanyasi)')) selected @endif>⁠Bhrigu (Dashnami Sanyasi)</option>
                                  <option value="⁠Achyuta" @if(isset($_GET['gotra']) && ($_GET['gotra'] == '⁠Achyuta')) selected @endif>⁠Achyuta</option>
                                </select>
                              </div>
                              <div class="col-lg-2">
                                <label class="fs-6 form-label fw-bold text-gray-900" for="branch">Branch</label>
                                <select class="form-select" name="branch">
                                  <option value="">Select Branch</option>
                                  @if($branches->count() != NULL)
                                    @foreach($branches as $branch)
                                      <option value="{{$branch->id}}" @if(isset($_GET['branch']) && ($_GET['branch'] == $branch->id)) selected @endif>{{$branch->title}}</option>
                                    @endforeach
                                  @endif
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" name="filter" value="true" />
                </form>


                <div class="card">
                  <div class="card-header border-0 pt-6">
                    <div class="card-toolbar">
                      <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        @can('devotee-create')<a href="{{route('devotees.create')}}" class="btn btn-primary me-3"><i class="ki-outline ki-plus"></i>Add Devotee</a>@endcan
                        @if (Route::currentRouteName() == 'devoteetrash')
                        <a href="{{route('devotees.index')}}" type="button" class="btn btn-primary me-3">
                        <i class="ki-outline ki-file fs-2"></i>All Lists</a>
                        @else
                        <a href="{{route('devoteetrash')}}" type="button" class="btn btn-primary me-3">
                        <i class="ki-outline ki-trash fs-2"></i>Trash Folder</a>
                        @endif
                        @can('devotee-create')<a href="{{route('devoteesimportget')}}" class="btn btn-primary me-3"><i class="ki-outline bi-upload"></i>CSV Devotee Import</a>@endcan
                        @role('Admin')<a type="button" class="btn btn-primary me-3" href="{{route('devotee.excel.export')}}"><i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i> Export Devotee</a>@endrole
                        @can('devotee-create')
                          <a href="" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#searchbyid"><i class="ki-outline bi-search"></i>Search by ID</a>
                          <div class="modal fade" id="searchbyid" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                              <div class="modal-content">
                                <div class="modal-header" id="kt_modal_add_user_header">
                                  <h2 class="fw-bold d-block">Enter Devotee ID</h2>
                                  <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                    <i class="ki-outline ki-cross fs-1"></i>
                                  </div>
                                </div>
                                <div class="modal-body">
                                  <form method="post" action="{{ route('searchbyid') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-2">
                                        <div class="col-md-8 col-sm-8 col-lg-8 mb-8">
                                        <p>If ID is: IN-024-<strong>20000</strong>, Please use the last bold text only.</p>
                                          <div class="form-group">
                                              <input type="number" class="form-control" name="id" id="id" required />
                                          </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-lg-4 mt-9">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Search</button>
                                            </div>
                                        </div>
                                      </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endcan
                        <a href="{{route('devoteeqrscan')}}" class="btn btn-primary me-3"><i class="ki-outline ki-scan-barcode fs-2"></i> QR Scan</a>
                        <a href="{{route('devoteeusersync')}}" class="btn btn-primary me-3"><i class="ki-outline ki-arrows-loop fs-2"></i> User Sync</a>
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
                        <table class="table table-bordered" id="devoteetable">
                        <thead>
                            <tr>
                              <!--<th class="w-20px pe-2">
  															<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
  																<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#devoteetable .form-check-input" value="1" />
  															</div>
  														</th>-->
                              <th>SN</th>
                              <th>Name</th>
                              <th>Initiation Name</th>
                              <th>Email</th>
                              <th>Mobile</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php $i = ($lists->perPage() * ($lists->currentPage() - 1)) + 1;; @endphp
                          @foreach($lists as $list)
                          <tr>
														<!--<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>-->
                            <td><?php echo $i; ?></td>
                            <td><a href="{{ route('devotees.show', $list->id)}}">
                              @if($list->firstname != NULL){{Crypt::decrypt($list->firstname)}}@endif @if($list->middlename != NULL){{Crypt::decrypt($list->middlename)}}@endif @if($list->surname != NULL){{Crypt::decrypt($list->surname)}}@endif</a></td>
                            <td>@if(Helper::getinitiationrow($list->id)){{Helper::getinitiationrow($list->id)->initiation_name}}@endif</td>
                            <td>@if($list->email_enc != NULL){{Crypt::decrypt($list->email_enc)}}@endif</td>
                            <td>{{$list->countrycode}} @if($list->mobile_enc != NULL){{Crypt::decrypt($list->mobile_enc)}}@endif</td>
                            <td>
                              @if($list->status == 'Active') <span class="badge badge-light-success">Active</span> @endif
                              @if($list->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
                              @if($list->status == 'imported') <span class="badge badge-light-primary">imported</span> @endif
                              @if($list->status == 'Trash') <span class="badge badge-light-danger">Trash</span> @endif
                            </td>
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <!--begin::Menu-->
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                                @if (Route::currentRouteName() == 'devoteetrash')
                                @can('devotee-delete')
                                <div class="menu-item px-3">
                                  <a href="{{ route('devoteerestore', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-arrows-loop fs-2"></i> Restore</a>
                                </div>
                                <div class="menu-item px-3">
                                  <form action="{{ route('devotees.destroy', $list->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i> Permanently Delete</button>
                                  </form>
                                </div>
                                @endcan
                                @else
                                @can('devotee-list')
                                <div class="menu-item px-3">
                                  <a href="{{ route('devotees.show', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-eye fs-2"></i> View</a>
                                </div>
                                @endcan
                                @can('devotee-edit')
                                <div class="menu-item px-3">
                                  <a href="{{ route('devotees.edit', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-pencil fs-2"></i> Edit</a>
                                </div>
                                @endcan
                                @can('devotee-delete')
                                <div class="menu-item px-3">
                                  <a href="{{ route('devoteemovetotrash', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-trash fs-2"></i> Trash</a>
                                </div>
                                @endcan
                                @endif
                              </div>
                            </td>
                          </tr>
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

@section('scripts')
@php
$today = date('Y-m-d');
$nextdate = date('Y-m-d', strtotime('+5 year'));
@endphp
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="{{asset('themes/assets/plugins/global/plugins.bundle.js')}}"></script>
<script type="text/javascript">
var start = moment().subtract(29, "days");
var end = moment();

function cb(start, end) {
    $("#daterange").html(start.format("yyyy-MM-dd")+","+end.format("yyyy-MM-DD"));
}

$("#daterange").daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
    "Today": [moment(), moment()],
    "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
    "Last 7 Days": [moment().subtract(6, "days"), moment()],
    "Last 30 Days": [moment().subtract(29, "days"), moment()],
    "This Month": [moment().startOf("month"), moment().endOf("month")],
    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
  },
  locale: {
        format: "yyyy-MM-DD"
    }
}, cb);

cb(start, end);
</script>
<!--
<script>
var inputElm = document.querySelector('#search');
const usersList = [
  <?php if($devotees->count() != NULL){
    foreach($devotees as $devotee){
      if($devotee->firstname != NULL){ $devoteefirstname = Crypt::decrypt($devotee->firstname);}else{ $devoteefirstname = NULL; }
      if($devotee->middlename != NULL){ $devoteemiddlename = Crypt::decrypt($devotee->middlename);}else{ $devoteemiddlename = NULL; }
      if($devotee->email_enc != NULL){ $devoteeemail = Crypt::decrypt($devotee->email_enc);}else{ $devoteeemail = NULL; }
      if($devotee->mobile_enc != NULL){ $devoteemobile = Crypt::decrypt($devotee->mobile_enc);}else{ $devoteemobile = NULL; }
      if($devotee->surname != NULL){ $devoteesurname = Crypt::decrypt($devotee->surname);}else{ $devoteesurname = NULL; }
    ?>
    { value: <?php echo "'".$devotee->id."'"; ?>, name: <?php echo "'".$devoteefirstname.' '.$devoteemiddlename.' '.$devoteesurname."'"; ?> <?php if(Helper::getinitiationrow($devotee->id)) { ?>, initiation:<?php echo "'".Helper::getinitiationrow($devotee->id)->initiation_name."'"; }else{ ?>, initiation: 'Not Initiated'<?php } ?>, email: <?php echo "'". $devoteeemail."'"; ?>, mobile:<?php echo  "'".$devoteemobile."'"; ?>},
  <?php } } ?>
];

function tagTemplate(tagData) {
  return `
    <tag title="${(tagData.title || tagData.email || tagData.mobile || tagData.initiation)}"
            contenteditable='false'
            spellcheck='false'
            tabIndex="-1"
            class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
            ${this.getAttributes(tagData)}>
        <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
        <div class="d-flex align-items-center">
            <span class='tagify__tag-text'>${tagData.name}</span>
        </div>
    </tag>
    `
}

function suggestionItemTemplate(tagData) {
    return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item d-flex align-items-center ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            <div class="d-flex flex-column devoteetagdata">
                <strong class="fs-4 fw-bold lh-1">${tagData.name} ( ${tagData.initiation} )</strong>
                <span class="text-muted fs-5">${tagData.email} ( ${tagData.mobile} )</span>
            </div>
        </div>
    `
}

// initialize Tagify on the above input node reference
var tagify = new Tagify(inputElm, {
    tagTextProp: 'name',
    enforceWhitelist: true,
    skipInvalid: true, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: false,
        enabled: 0,
        searchKeys: ['name', 'email', 'mobile', 'initiation']
    },
    templates: {
        tag: tagTemplate,
        dropdownItem: suggestionItemTemplate
    },
    whitelist: usersList
})

tagify.on('dropdown:show dropdown:updated', onDropdownShow)
</script>-->
<script type="text/javascript">
// Format options
const optionFormat = (item) => {
    if (!item.id) {
        return item.text;
    }

    var span = document.createElement('span');
    var template = '';

    template += '<div class="d-flex align-items-center">';
    template += '<div class="d-flex flex-column">'
    template += '<span class="fs-4 fw-bold lh-1">' + item.text + '</span>';
    template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-kt-rich-content-initiation') + '</span>';
    template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-kt-rich-content-email') + '</span>';
    template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-kt-rich-content-mobile') + '</span>';
    template += '</div>';
    template += '</div>';

    span.innerHTML = template;

    return $(span);
}

// Init Select2 --- more info: https://select2.org/
$('#search').select2({
    placeholder: "Search devotee by original name",
    templateSelection: optionFormat,
    templateResult: optionFormat
});
</script>
@endsection
