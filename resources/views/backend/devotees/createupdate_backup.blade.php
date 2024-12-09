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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">@if (isset($edit)) Edit @else Add @endif Devotee</h1>
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

                    @if (isset($edit))
                        <form action="{{ route('devotees.update', $edit->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @else
                        <form action="{{ route('devotees.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                      @csrf
                        <div class="row">
                        <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="firstname">First Name <span class="required"></span></label>
                                    <input type="text" class="form-control" name="firstname" id="firstname" value="{{ old('firstname', $edit->firstname ?? '') }}" required />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="middlename">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename" id="middlename" value="{{ old('middlename', $edit->middlename ?? '') }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="surname">Surname <span class="required"></span></label>
                                    <input type="text" class="form-control" name="surname" id="surname" value="{{ old('surname', $edit->surname ?? '') }}" required />
                                </div>
                            </div>
                          </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="mentor">Mentor</label>
                                    <select class="form-control" data-control="select2" name="mentor" id="mentor">
                                      <option value="">Select One</option>
                                      @if($mentors->count() != NULL)
                                        @foreach($mentors as $mentor)
                                          <option value="{{$mentor->id}}" @if (isset($edit)) {{ old('mentor', $edit->mentor == $mentor->id ? 'selected' : '' ?? '') }} @endif>{{$mentor->getdevotee->firstname}} {{$mentor->getdevotee->middlename}} {{$mentor->getdevotee->surname}}</option>
                                        @endforeach
                                      @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="initiatedname">Initiation Name</label>
                                    <input type="text" class="form-control" name="initiatedname" id="initiatedname" value="{{ old('initiatedname', $edit->initiated ?? '') }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                <div class="form-group">
                                    <label for="initiatedtype">Initiation Type</label>
                                    <select class="form-control" data-control="select2" name="initiatedtype" id="initiatedtype">
                                      <option value="">Select One</option>
                                      <option value="Sheltered" @if (isset($edit)) {{ old('initiatedtype', $edit->initiatedtype == 'Sheltered' ? 'selected' : '' ?? '') }} @endif>Sheltered</option>
                                      <option value="Harinam Initiation" @if (isset($edit)) {{ old('initiatedtype', $edit->initiatedtype == 'Harinam Initiation' ? 'selected' : '' ?? '') }} @endif>Harinam Initiation</option>
                                      <option value="Brahman Initiation" @if (isset($edit)) {{ old('initiatedtype', $edit->initiatedtype == 'Brahman Initiation' ? 'selected' : '' ?? '') }} @endif>Brahman Initiation</option>
                                    </select>
                                </div>
                            </div>
                          </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="initiateddate">Initiation Date</label>
                                    <input type="text" class="form-control" name="initiateddate" id="initiateddate" value="{{ old('initiateddate', $edit->initiateddate ?? '') }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="initiationby">Initiation By</label>
                                    <select class="form-control" data-control="select2" name="initiationby" id="initiationby">
                                      <option value="">Select One</option>
                                      @if($initiativegurus->count() != NULL)
                                        @foreach($initiativegurus as $initiativeguru)
                                          <option value="{{$initiativeguru->id}}" @if (isset($edit)) {{ old('initiationby', $edit->initiationby == $initiativeguru->id ? 'selected' : '' ?? '') }} @endif>{{$initiativeguru->name}}</option>
                                        @endforeach
                                      @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="gotra">Gotra</label>
                                    <input type="text" class="form-control" name="gotra" id="gotra" value="{{ old('gotra', $edit->gotra ?? '') }}" />
                                </div>
                            </div>
                          </div>

                          <div class="row">
                              <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                  <div class="form-group">
                                      <label for="email">Email <span class="required"></span></label>
                                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $edit->email ?? '') }}" required />
                                  </div>
                              </div>
                              <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                  <div class="form-group">
                                      <label for="mobile">Primary Phone (Mobile) <span class="required"></span></label>
                                      <input type="number" class="form-control" name="mobile" id="mobile" value="{{ old('mobile', $edit->mobile ?? '') }}" required />
                                  </div>
                              </div>
                              <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                  <div class="form-group">
                                      <label for="phone">Secondary Phone</label>
                                      <input type="number" class="form-control" name="phone" id="phone" value="{{ old('phone', $edit->phone ?? '') }}" />
                                  </div>
                              </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                    <div class="form-group">
                                        <label for="branch">Branch <span class="required"></span></label>
                                        <select class="form-control" name="branch" id="branch" required>
                                          <option value="">Select One</option>
                                          @if($branches->count() != NULL)
                                            @foreach($branches as $branch)
                                              <option value="{{$branch->id}}" @if (isset($edit)) {{ old('branch', $edit->branch_id == $branch->id ? 'selected' : '' ?? '') }} @endif>{{$branch->title}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                    <div class="form-group">
                                        <label for="parent">Status <span class="required"></span></label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="">Select One</option>
                                            <option value="Active" @if (isset($edit)) {{ old('status', $edit->status == 'Active' ? 'selected' : '' ?? '') }} @endif>Active</option>
                                            <option value="Draft" @if (isset($edit)) {{ old('status', $edit->status == 'Draft' ? 'selected' : '' ?? '') }} @endif>Draft</option>
                                            <option value="imported" @if (isset($edit)) {{ old('status', $edit->status == 'imported' ? 'selected' : '' ?? '') }} @endif>imported</option>
                                        </select>
                                    </div>
                                </div>
                              </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                    <div class="form-group">
                                        <label for="identitytype">Identity Type</label>
                                        <select class="form-control" name="identitytype" id="identitytype">
                                          <option value="">Select One</option>
                                          <option value="National ID" @if (isset($edit)) {{ old('identitytype', $edit->identitytype == 'National ID' ? 'selected' : '' ?? '') }} @endif>National ID</option>
                                          <option value="Citizenship" @if (isset($edit)) {{ old('identitytype', $edit->identitytype == 'Citizenship' ? 'selected' : '' ?? '') }} @endif>Citizenship</option>
                                          <option value="Passport" @if (isset($edit)) {{ old('identitytype', $edit->identitytype == 'Passport' ? 'selected' : '' ?? '') }} @endif>Passport</option>
                                          <option value="Vote Card" @if (isset($edit)) {{ old('identitytype', $edit->identitytype == 'Vote Card' ? 'selected' : '' ?? '') }} @endif>Vote Card</option>
                                          <option value="Student Card" @if (isset($edit)) {{ old('identitytype', $edit->identitytype == 'Student Card' ? 'selected' : '' ?? '') }} @endif>Student Card</option>
                                          <option value="Profession Card" @if (isset($edit)) {{ old('identitytype', $edit->identitytype == 'Profession Card' ? 'selected' : '' ?? '') }} @endif>Profession Card</option>
                                          <option value="Iskcon Card" @if (isset($edit)) {{ old('identitytype', $edit->identitytype == 'Iskcon Card' ? 'selected' : '' ?? '') }} @endif>Iskcon Card</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                    <div class="form-group">
                                        <label for="identityno">Identity No</label>
                                        <input type="text" class="form-control" name="identityno" id="identityno" value="{{ old('identityno', $edit->identityid ?? '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                    <div class="form-group">
                                        <label for="identityimage">Identity Image</label>
                                        <input type="file" class="form-control" name="identityimage" id="identityimage" />
                                        <input type="hidden" class="custom-file-input" value="{{ old('identityimage', $edit->identityimage ?? '') }}" name="identity_old" />
                                        @if (isset($edit) && $edit->identityimage != '')
                                        <div class="mt-2">
                                            <input type="checkbox" class="custom-control-input" id="removeid" name="removeid" value="1" />
                                            <label class="custom-control-label" for="removeid">Remove Identity</label>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                      <div class="form-group">
                                          <label for="dob">Date of Birth</label>
                                          <input type="text" class="form-control form-control-solid" name="dob" id="dob" value="{{ old('dob', $edit->dob ?? '') }}" />
                                      </div>
                                  </div>
                                  <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                      <div class="form-group">
                                          <label for="bloodgroup">Blood Group</label>
                                          <select class="form-control" name="bloodgroup" id="bloodgroup">
                                            <option value="">Select One</option>
                                            <option value="A+" @if (isset($edit)) {{ old('status', $edit->bloodgroup == 'A+' ? 'selected' : '' ?? '') }} @endif>A+</option>
                                            <option value="A-" @if (isset($edit)) {{ old('status', $edit->bloodgroup == 'A-' ? 'selected' : '' ?? '') }} @endif>A-</option>
                                            <option value="B+" @if (isset($edit)) {{ old('status', $edit->bloodgroup == 'B+' ? 'selected' : '' ?? '') }} @endif>B+</option>
                                            <option value="B-" @if (isset($edit)) {{ old('status', $edit->bloodgroup == 'B-' ? 'selected' : '' ?? '') }} @endif>B-</option>
                                            <option value="O+" @if (isset($edit)) {{ old('status', $edit->bloodgroup == 'O+' ? 'selected' : '' ?? '') }} @endif>O+</option>
                                            <option value="O-" @if (isset($edit)) {{ old('status', $edit->bloodgroup == 'O-' ? 'selected' : '' ?? '') }} @endif>O-</option>
                                            <option value="AB+" @if (isset($edit)) {{ old('status', $edit->bloodgroup == 'AB+' ? 'selected' : '' ?? '') }} @endif>AB+</option>
                                            <option value="AB-" @if (isset($edit)) {{ old('status', $edit->bloodgroup == 'AB-' ? 'selected' : '' ?? '') }} @endif>AB-</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                      <div class="form-group">
                                          <label for="gender">Gender</label>
                                          <select class="form-control" name="gender" id="gender">
                                            <option value="">Select One</option>
                                            <option value="Male" @if (isset($edit)) {{ old('status', $edit->gender == 'Male' ? 'selected' : '' ?? '') }} @endif>Male</option>
                                            <option value="Female" @if (isset($edit)) {{ old('status', $edit->gender == 'Female' ? 'selected' : '' ?? '') }} @endif>Female</option>
                                            <option value="Other" @if (isset($edit)) {{ old('status', $edit->gender == 'Other' ? 'selected' : '' ?? '') }} @endif>Other</option>
                                            <option value="Rather not say" @if (isset($edit)) {{ old('status', $edit->gender == 'Rather not say' ? 'selected' : '' ?? '') }} @endif>Rather not say</option>
                                          </select>
                                      </div>
                                  </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                        <div class="form-group">
                                            <label for="education">Education</label>
                                            <select class="form-control" name="education" id="education">
                                              <option value="">Select One</option>
                                              <option value="Literate" @if (isset($edit)) {{ old('status', $edit->education == 'Literate' ? 'selected' : '' ?? '') }} @endif>Literate</option>
                                              <option value="District Level" @if (isset($edit)) {{ old('status', $edit->education == 'District Level' ? 'selected' : '' ?? '') }} @endif>District Level</option>
                                              <option value="SLC-SEE" @if (isset($edit)) {{ old('status', $edit->education == 'SLC-SEE' ? 'selected' : '' ?? '') }} @endif>SLC/SEE</option>
                                              <option value="+2" @if (isset($edit)) {{ old('status', $edit->education == '+2' ? 'selected' : '' ?? '') }} @endif>+2</option>
                                              <option value="Bachelor" @if (isset($edit)) {{ old('status', $edit->education == 'Bachelor' ? 'selected' : '' ?? '') }} @endif>Bachelor</option>
                                              <option value="Master" @if (isset($edit)) {{ old('status', $edit->education == 'Master' ? 'selected' : '' ?? '') }} @endif>Master</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                        <div class="form-group">
                                            <label for="occupation">Occupation</label>
                                            <input type="text" class="form-control" name="occupation" id="occupation" value="{{ old('occupation', $edit->occupation ?? '') }}" />
                                        </div>
                                    </div>
                                  </div>


                                    <h4>Permanent Address</h4>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                            <div class="form-group">
                                                <label for="pprovince">Province</label>
                                                <select class="form-control" name="province" id="province">
                                                  <option value="">Select One</option>
                                                  <option value="Bagmati" @if (isset($edit)) {{ old('province', $edit->pprovince == 'Bagmati' ? 'selected' : '' ?? '') }} @endif>Bagmati</option>
                                                  <option value="Gandaki" @if (isset($edit)) {{ old('province', $edit->pprovince == 'Gandaki' ? 'selected' : '' ?? '') }} @endif>Gandaki</option>
                                                  <option value="Karnali" @if (isset($edit)) {{ old('province', $edit->pprovince == 'Karnali' ? 'selected' : '' ?? '') }} @endif>Karnali</option>
                                                  <option value="Koshi" @if (isset($edit)) {{ old('province', $edit->pprovince == 'Koshi' ? 'selected' : '' ?? '') }} @endif>Koshi</option>
                                                  <option value="Lumbini" @if (isset($edit)) {{ old('province', $edit->pprovince == 'Lumbini' ? 'selected' : '' ?? '') }} @endif>Lumbini</option>
                                                  <option value="Madhesh" @if (isset($edit)) {{ old('province', $edit->pprovince == 'Madhesh' ? 'selected' : '' ?? '') }} @endif>Madhesh</option>
                                                  <option value="Sudurpashchim" @if (isset($edit)) {{ old('province', $edit->pprovince == 'Sudurpashchim' ? 'selected' : '' ?? '') }} @endif>Sudurpashchim</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                            <div class="form-group">
                                                <label for="pdistrict">District</label>
                                                <input type="text" class="form-control" name="pdistrict" id="pdistrict" value="{{ old('pdistrict', $edit->pdistrict ?? '') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                            <div class="form-group">
                                                <label for="pmuni">Rural / Urban Municipality</label>
                                                <input type="text" class="form-control" name="pmuni" id="pmuni" value="{{ old('pmuni', $edit->pmuni ?? '') }}" />
                                            </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-8 col-sm-8 col-lg-8 mb-8">
                                              <div class="form-group">
                                                  <label for="ptole">Tole</label>
                                                  <input type="text" class="form-control" name="ptole" id="ptole" value="{{ old('ptole', $edit->ptole ?? '') }}" />
                                              </div>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                              <div class="form-group">
                                                  <label for="pwardno">Ward No</label>
                                                  <input type="text" class="form-control" name="pwardno" id="pwardno" value="{{ old('pwardno', $edit->pwardno ?? '') }}" />
                                              </div>
                                          </div>
                                        </div>

                                        <h4>Temporary Address</h4>

                                        <div class="mt-5 mb-5"><input type="checkbox" class="form-check-input" id="filladdress" name="filladdress"/> Same as Permanent Address<br /></div>

                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="tprovince">Province</label>
                                                    <select class="form-control" name="tprovince" id="tprovince">
                                                      <option value="">Select One</option>
                                                      <option value="Bagmati" @if (isset($edit)) {{ old('province', $edit->tprovince == 'Bagmati' ? 'selected' : '' ?? '') }} @endif>Bagmati</option>
                                                      <option value="Gandaki" @if (isset($edit)) {{ old('province', $edit->tprovince == 'Gandaki' ? 'selected' : '' ?? '') }} @endif>Gandaki</option>
                                                      <option value="Karnali" @if (isset($edit)) {{ old('province', $edit->tprovince == 'Karnali' ? 'selected' : '' ?? '') }} @endif>Karnali</option>
                                                      <option value="Koshi" @if (isset($edit)) {{ old('province', $edit->tprovince == 'Koshi' ? 'selected' : '' ?? '') }} @endif>Koshi</option>
                                                      <option value="Lumbini" @if (isset($edit)) {{ old('province', $edit->tprovince == 'Lumbini' ? 'selected' : '' ?? '') }} @endif>Lumbini</option>
                                                      <option value="Madhesh" @if (isset($edit)) {{ old('province', $edit->tprovince == 'Madhesh' ? 'selected' : '' ?? '') }} @endif>Madhesh</option>
                                                      <option value="Sudurpashchim" @if (isset($edit)) {{ old('province', $edit->tprovince == 'Sudurpashchim' ? 'selected' : '' ?? '') }} @endif>Sudurpashchim</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="tdistrict">District</label>
                                                    <input type="text" class="form-control" name="tdistrict" id="tdistrict" value="{{ old('tdistrict', $edit->tdistrict ?? '') }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="tmuni">Rural / Urban Municipality</label>
                                                    <input type="text" class="form-control" name="tmuni" id="tmuni" value="{{ old('tmuni', $edit->tmuni ?? '') }}" />
                                                </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-8 col-sm-8 col-lg-8 mb-8">
                                                  <div class="form-group">
                                                      <label for="ttole">Tole</label>
                                                      <input type="text" class="form-control" name="ttole" id="ttole" value="{{ old('ttole', $edit->ttole ?? '') }}" />
                                                  </div>
                                              </div>
                                              <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                  <div class="form-group">
                                                      <label for="twardno">Ward No</label>
                                                      <input type="text" class="form-control" name="twardno" id="twardno" value="{{ old('twardno', $edit->twardno ?? '') }}" />
                                                  </div>
                                              </div>
                                            </div>

                          <div class="row">
                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">@if (isset($edit)) Update @else Create @endif Devotee</button>
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
<script type="text/javascript">
$(document).ready(function() {
  $("#dob").flatpickr();
  $("#initiateddate").flatpickr();
});

$(document).ready(function(){
  $("#filladdress").on("click", function(){
    if (this.checked) {
      $("#tprovince").val($("#province").val());
      $("#tdistrict").val($("#pdistrict").val());
      $("#tmuni").val($("#pmuni").val());
      $("#ttole").val($("#ptole").val());
      $("#twardno").val($("#pwardno").val());
    }
    else {
      $("#tprovince").val('');
      $("#tdistrict").val('');
      $("#tmuni").val('');
      $("#ttole").val('');
      $("#twardno").val('');
    }
    });
});
</script>
@endsection
