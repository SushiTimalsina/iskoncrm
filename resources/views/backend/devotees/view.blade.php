@extends('backend.layouts.master')

@section('styles')
<link href="{{asset('themes/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">@if($view->firstname != NULL){{Crypt::decrypt($view->firstname)}} - Details @endif</h1>
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
                <li class="breadcrumb-item text-muted">Devotee Details</li>
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
      <!--begin::Content wrapper-->
      <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
          <!--begin::Content container-->
          <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Navbar-->

                @if (session()->get('success'))
                    <div class="alert alert-success">
                        <div class="alert-body">{{ session()->get('success') }}</div>
                    </div>
                @endif

                @if (session()->get('error'))
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

            <div class="card mb-6 mb-xl-9">
              <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                  <div class="rounded me-15 mb-2 devoteeprofile">
                    @if($view->photo != NULL)
                    <a href="{{ route('devoteephoto.show', ['imageName' => $view->photo]) }}" data-fancybox="gallery"><img src="{{ route('devoteephoto.show', ['imageName' => $view->photo]) }}" alt="image" /></a>
                    @else
                    <div class="symbol symbol-100px mb-2"><img src="{{ asset('images/user.jpg') }}" alt="image" /></div>
                    @endif
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8 mt-8">
                      <li class="nav-item">
                        <a href="#" class="btn btn-primary devoteeimage" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">Upload Photo<i class="ki-outline ki-down fs-2 me-0"></i></a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-150px fs-6" data-kt-menu="true">
                          <div class="menu-item px-5"><a href="{{route('profileimage', $view->id)}}" class="menu-link px-5">Use Webcam</a></div>
                          <div class="menu-item px-5"><a href="#" class="menu-link px-5" data-bs-toggle="modal" data-bs-target="#upload_profile_photo">Upload Photo</a></div>
                        </div>
                      </li>
                    </ul>
                    <div class="modal fade" id="upload_profile_photo" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered mw-650px">
                        <div class="modal-content">
                          <div class="modal-header" id="kt_modal_add_user_header">
                            <h2 class="fw-bold">Upload Profile Photo</h2>
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                              <i class="ki-outline ki-cross fs-1"></i>
                            </div>
                          </div>
                          <div class="modal-body">
                            <form method="post" action="{{ route('profileimageupdate', $view->id) }}" enctype="multipart/form-data">
                              @csrf
                              <div class="row mb-2">
                                  <div class="col-md-8 col-sm-8 col-lg-8 mb-8">
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="image" id="image" required />
                                    </div>
                                  </div>
                                  <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                      <div class="form-group">
                                          <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Upload</button>
                                      </div>
                                  </div>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--end::Image-->
                  <!--begin::Wrapper-->
                  <div class="flex-grow-1">
                    <!--begin::Head-->
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                      <!--begin::Details-->
                      <div class="d-flex flex-column">
                        <!--begin::Status-->
                        <div class="d-flex align-items-center mb-1">
                          <div class="text-red text-hover-primary fs-2 fw-bold me-3">@if($view->firstname != NULL){{Crypt::decrypt($view->firstname)}} @endif @if($view->middlename != NULL){{Crypt::decrypt($view->middlename)}} @endif @if($view->surname != NULL){{Crypt::decrypt($view->surname)}} @endif</div>

                          @if($view->member != NULL)<span class="badge badge-success d-inline me-2">Life Member</span>@endif

                          <?php
                          $str = date('Y', strtotime($view->created_at));
                          $str1 = substr($str, 1);
                          ?>
                          <span class="badge badge-light-info d-inline me-2">IN-{{$str1}}-{{$view->id}}</span>
                          <span class="badge badge-light-info d-inline me-2">{{$view->status}}</span>
                          <span class="badge badge-light-info d-inline">{{$view->getbranch->title}}</span>
                        </div>
                        @if(Helper::getinitiationrow($view->id))<div class="fs-5 fw-semibold text-muted"><strong>Initiation Name: </strong>{{Helper::getinitiationrow($view->id)->initiation_name}}</div>@endif
                      </div>
                      <!--end::Details-->
                      <!--begin::Actions-->
                      <div class="d-flex mb-4">
                        @can('devotee-create')
                        @if(Helper::getmemberusingdevoteedoesntexists($view->id))
                          <a href="{{route('devotee.relation', $view->id)}}" class="btn btn-sm btn-primary me-2">Create Family Member</a>
                        @endif
                        @if(Helper::getfamilydevoteeidsame($view->id))
                          <a href="{{route('devotee.relation', $view->id)}}" class="btn btn-sm btn-primary me-2">Create Family Member</a>
                        @endif

                        <a href="" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#add_skills">Add Skills</a>
                        <div class="modal fade" id="add_skills" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered mw-650px">
                            <div class="modal-content">
                              <div class="modal-header" id="kt_modal_add_user_header">
                                <h2 class="fw-bold">Add Skills</h2>
                                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                  <i class="ki-outline ki-cross fs-1"></i>
                                </div>
                              </div>
                              <div class="modal-body">
                                <form method="post" action="{{ route('devotee-skills.store') }}" enctype="multipart/form-data">
                                  @csrf
                                  <input type="hidden" id="devotee" name="devotee" value="{{$view->id}}" />
                                    <div class="row mb-2">
                                      <div class="col-md-12 col-sm-12 col-lg-12 mb-6">
                                          <div class="form-group">
                                              <label for="skills">Skills</label>
                                              <input type="text" id="skills" name="skills[]" class="form-control" placeholder="Enter skills name" />
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row mb-2">
                                        <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                            <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Add Skill</button>
                                        </div>
                                      </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endcan
                        @can('devotee-delete')
                        <a href="{{ route('devotees.edit', $view->id)}}" class="btn btn-sm btn-primary me-2">Edit Devotee</a>
                        @endcan
                        @can('devotee-delete')
                        <a href="{{ route('devoteemovetotrash', $view->id)}}" class="btn btn-sm btn-primary me-2">Trash Devotee</a>
                        @endcan
                      </div>
                    </div>
                    <div class="d-flex flex-wrap">
                      <div class="d-flex flex-column me-10 mb-5">
                        <table class="customtable">
                          @php
                            if($view->mentor != NULL){
                            $getdevoteerow = \App\Models\Devotees::find($view->getmentor->devotee_id); @endphp
                          <tr>
                            <th>Mentor</th>
                            <td>: <a href="{{ route('devotees.show', $getdevoteerow->id)}}"><span class="text-gray-600">
                              @if($getdevoteerow->firstname != NULL){{Crypt::decrypt($getdevoteerow->firstname)}} @endif @if($getdevoteerow->middlename != NULL){{Crypt::decrypt($getdevoteerow->middlename)}} @endif @if($getdevoteerow->surname != NULL){{Crypt::decrypt($getdevoteerow->surname)}} @endif
                            </span></a></td>
                          </tr>
                          @php } @endphp
                          <tr>
                            <th>Gotra</th>
                            <td>: {{$view->gotra}}</td>
                          </tr>
                          <tr>
                            <th>Email</th>
                            <td>: @if($view->email_enc != NULL){{Crypt::decrypt($view->email_enc)}}@endif</td>
                          </tr>
                          <tr>
                            <th>Mobile</th>
                            <td>: @if($view->countrycode != NULL) {{$view->countrycode}} @endif @if($view->mobile_enc != NULL){{Crypt::decrypt($view->mobile_enc)}}@endif</td>
                          </tr>
                          <tr>
                            <th>Phone</th>
                            <td>: @if($view->phone != NULL){{Crypt::decrypt($view->phone)}}@endif</td>
                          </tr>
                          <tr>
                            <th>Education</th>
                            <td>: {{$view->education}}</td>
                          </tr>
                          <tr>
                            <th>Occupation</th>
                            <td>: @if($view->occupations != NULL){{$view->getoccupation->title}}@endif</td>
                          </tr>
                          <tr>
                            <th>Marital Status</th>
                            <td>: {{$view->marital_status}}</td>
                          </tr>
                        </table>
                      </div>
                      <div class="d-flex flex-column me-10 mb-5">
                        <table class="customtable">
                          <tr>
                            <th>Nationality</th>
                            <td>: {{$view->nationality}}</td>
                          </tr>
                          <tr>
                            <th>Identity Type</th>
                            <td>: @if($view->identitytype != NULL){{Crypt::decrypt($view->identitytype)}}@endif</td>
                          </tr>
                          <tr>
                            <th>Identity Number</th>
                            <td>: @if($view->identityid_enc != NULL){{Crypt::decrypt($view->identityid_enc)}}@endif</td>
                          </tr>
                          @if($view->identityimage != NULL)
                          <tr>
                            <th>Identity Image</th>
                            <td>: <a href="{{ route('devoteeid.show', ['imageName' => $view->identityimage]) }}" target="_blank">{{$view->identityimage}}</a></td>
                          </tr>
                          @endif
                          <tr>
                            <th>Date of Birth</th>
                            <td>: @if($view->dob != NULL){{Crypt::decrypt($view->dob)}} {{$view->dobtype}}@endif
                            </td>
                          </tr>
                          <tr>
                            <th>Gender</th>
                            <td>: {{$view->gender}}</td>
                          </tr>
                          <tr>
                            <th>Blood Group</th>
                            <td>: {{$view->bloodgroup}}</td>
                          </tr>
                          <tr>
                            <th>Profile Age</th>
                            <td>:  {{ \Carbon\Carbon::parse($view->created_at)->diffForhumans() }}</td>
                          </tr>
                        </table>
                      </div>
                      <div class="d-flex flex-column me-10 mb-5">
                        <div class="fw-bold">Permanent Address</div>
                        <div class="text-gray-600">
                           @if(isset($provincebyId))
                               {{ $provincebyId->name }}
                               <br />
                           @endif

                           @if(isset($tolebyId))
                               {{ $tolebyId->name }} - @if($view->pwardno != NULL){{Crypt::decrypt($view->pwardno)}}@endif
                               <br />
                           @endif

                           @if(isset($districtbyId))
                               {{ $districtbyId->name }} 
                           @endif
                       </div>
                       <div class="fw-bold mt-5">Temporary Address</div>
                       <div class="text-gray-600">
                          @if(isset($tprovincebyId))
                              {{ $tprovincebyId->name }}
                              <br />
                          @endif

                          @if(isset($ttolebyId))
                              {{ $ttolebyId->name }} - @if($view->twardno != NULL){{Crypt::decrypt($view->twardno)}}@endif
                              <br />
                          @endif

                          @if(isset($tdistrictbyId))
                              {{ $tdistrictbyId->name }} 
                          @endif
                      </div>
                      </div>
                      <div class="d-flex flex-column aligncenter me-10 mb-5">
                        {!! QrCode::size(150)->generate('IN-'.$str1.'-'.$view->id) !!}
                      </div>
                    </div>
                    <div class="d-flex flex-wrap">
                      <div class="d-flex flex-column">
                        <table class="customtable">
                          <tr>
                            <th width="75">Skills</th>
                            <td>:
                              @if($skills->count() != NULL)
                                @foreach($skills as $skill)
                                <div class="d-inline-block">
                                  <span class="btn btn-light p-1">{{$skill->getskill->title}}
                                    @can('devotee-delete')
                                      <form class="d-inline-block" action="{{ route('devotee-skills.destroy', $skill->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light p-1" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash text-primary "></i></button>
                                      </form>
                                    @endcan
                                  </span>
                                </div>
                                @endforeach
                              @endif
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <!--end::Info-->
                  </div>
                  <!--end::Wrapper-->
                </div>
                <!--end::Details-->
                <div class="separator"></div>
                <!--begin::Nav-->
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                  <!--begin::Nav item-->
                  <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 active" href="#overview" data-bs-toggle="tab">Overview</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" href="#relation" data-bs-toggle="tab">Relation</a>
                  </li>
                  @can('sewa-list')
                  <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#sewalists">Sewa</a>
                  </li>
                  @endcan
                  @can('donation-list')
                  <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#donation">Donations</a>
                  </li>
                  @endcan
                  @can('course-list')
                  <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#courses">Courses</a>
                  </li>
                  @endcan
                  @can('initiative-list')
                  <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#initiative">Initiation</a>
                  </li>
                  @endcan
                </ul>
              </div>
            </div>

            <div class="row gx-6 gx-xl-9">
              <div class="tab-content" id="myTabContent">
                <div role="tabpanel" class="tab-pane fade show active" id="overview">
                </div>
                <div role="tabpanel" class="tab-pane fade show" id="relation">
                  <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                      <!--begin::Card title-->
                      <div class="card-title">
                        <h2>Relations</h2>
                      </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                      <table class="table align-middle table-row-dashed gy-5" id="sewa">
                        <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                          <tr class="text-start text-muted text-uppercase gs-0">
                            <th>Devotee Name</th>
                            <th>Relation</th>
                          </tr>
                        </thead>
                        <tbody class="fs-6 fw-semibold text-gray-600">
                          @php
                            $dataexists = Helper::getmemberusingdevoteeexists($view->id);
                          @endphp

                          @if($dataexists)
                          @php
                            $getmember = Helper::getmemberusingdevoteeid($view->id)->devotees_id;
                            $families = Helper::getalldevoteemembers($getmember);
                          @endphp
                          @foreach($families as $member)
                          <tr>
                            <td><a href="{{route('devotees.show', $member->devotee_id)}}">{{Helper::getdevoteebyid($member->devotee_id)->firstname}} {{Helper::getdevoteebyid($member->devotee_id)->middlename}} {{Helper::getdevoteebyid($member->devotee_id)->surname}}</a></td>
                            <td>{{ ucfirst($member->role) }}</td>
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                @can('sewa-list')
                <div class="tab-pane fade" id="sewalists" role="tabpanel">
                  <!--begin::Card-->
                  <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                      <!--begin::Card title-->
                      <div class="card-title">
                        <h2>Sewa Records</h2>
                      </div>
                      <!--end::Card title-->
                      <!--begin::Card toolbar-->
                      @can('sewa-create')
                      <div class="card-toolbar">
                        <!--begin::Filter-->
                        <a href="#" class="btn btn-sm btn-flex btn-light-primary" data-bs-toggle="modal" data-bs-target="#add_sewa">
                        <i class="ki-outline ki-plus-square fs-3"></i>Add Sewa</a>
                        <!--end::Filter-->
                      </div>
                      <div class="modal fade" id="add_sewa" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_user_header">
                              <h2 class="fw-bold">Add Sewa</h2>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                              </div>
                            </div>
                            <div class="modal-body">
                              <form method="post" action="{{ route('sewa-attend.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="devotee" name="devotee" value="{{$view->id}}" />
                                  <div class="row mb-2">
                                        <div class="col-md-6 col-sm-6 col-lg-6 mb-6">
                                            <div class="form-group">
                                                <label for="department">Department</label>
                                                <select class="form-select form-select-sm form-select-solid" data-control="select2" name="department" id="department" required>
                                                  <option value="">Select One</option>
                                                  @if($departments->count() != NULL)
                                                    @foreach($departments as $department)
                                                      <option value="{{$department->id}}">{{$department->title}}</option>
                                                    @endforeach
                                                  @endif
                                                </select>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6 col-sm-6 col-lg-6 mb-6">
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <input type="text" class="form-control form-control-solid" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6 mb-6">
                                            <div class="form-group">
                                                <label for="designation">Designation</label>
                                                <select class="form-select form-select-sm form-select-solid" name="designation" id="designation" required>
                                                  <option value="Volunteer">Volunteer</option>
                                                  <option value="Head">Head</option>
                                                </select>
                                            </div>
                                        </div>
                                      </div>
                                    <div class="row mb-2">
                                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                          <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
                                      </div>
                                    </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endcan
                      <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                      <!--begin::Table-->
                      @if($attendsewas->count() != NULL)
                      <table class="table align-middle table-row-dashed gy-5" id="sewa">
                        <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                          <tr class="text-start text-muted text-uppercase gs-0">
                            <th>SN</th>
                            <th>Branch</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Date</th>
                            <th>Created Date</th>
                          </tr>
                        </thead>
                        <tbody class="fs-6 fw-semibold text-gray-600">
                          <?php $i = ($attendsewas->perPage() * ($attendsewas->currentPage() - 1)) + 1;; ?>
                          @foreach($attendsewas as $attendsewa)
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td>{{$attendsewa->getbranch->title}}</td>
                            <td>{{$attendsewa->getdepartment->title}}</td>
                            <td>{{$attendsewa->designation}}</td>
                            <td>{{$attendsewa->date}}</td>
                            <td><strong>Created By: </strong>@if($attendsewa->getcreatedby->name != NULL){{Crypt::decrypt($attendsewa->getcreatedby->name)}}@endif<br /><strong>Updated By: </strong>{{$attendsewa->updated_at}}</td>
                          </tr>
                          <?php $i++; ?>
                          @endforeach
                        </tbody>
                        <!--end::Table body-->
                      </table>
                      <div class="mt-2">{!! $attendsewas->links() !!}</div>
                      @else
                      <div class="demo-spacing-0"><div class="alert alert-primary" role="alert"><div class="alert-body">No Sewa Found!</div></div></div>
                      @endif
                    </div>
                    <!--end::Card body-->
                  </div>
                  <!--end::Card-->
                  <!--begin::Card-->
                </div>
                @endcan
                @can('donation-list')
                <div class="tab-pane fade" id="donation" role="tabpanel">
                  <!--begin::Card-->
                  <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                      <!--begin::Card title-->
                      <div class="card-title">
                        <h2>Donations</h2>
                      </div>
                      <!--end::Card title-->
                      <!--begin::Card toolbar-->
                      @can('donation-create')
                      <div class="card-toolbar">
                        <!--begin::Filter-->
                        <a href="#" class="btn btn-sm btn-flex btn-light-primary" data-bs-toggle="modal" data-bs-target="#add_donation">
                        <i class="ki-outline ki-plus-square fs-3"></i>Add Donation</a>
                        <!--end::Filter-->
                      </div>
                      <div class="modal fade" id="add_donation" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_user_header">
                              <h2 class="fw-bold">Add Donation</h2>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                              </div>
                            </div>
                            <div class="modal-body">
                              <form method="post" action="{{ route('donation.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="devotee" name="devotee" value="{{$view->id}}" />
                                  <div class="row mb-2">
                                        <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                            <div class="form-group">
                                                <label for="sewa">Sewa</label>
                                                <select class="form-select form-select-sm" data-control="select2" name="sewa" id="sewa" required>
                                                  <option value="">Select One</option>
                                                  @if($sewas->count() != NULL)
                                                    @foreach($sewas as $sewa)
                                                      <option value="{{$sewa->id}}">{{$sewa->title}}</option>
                                                    @endforeach
                                                  @endif
                                                </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                              <div class="form-group">
                                                  <label for="donation">Donation Amount</label>
                                                  <input type="number" name="donation" id="donation" class="form-control" required />
                                              </div>
                                          </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                            <div class="form-group">
                                                <label for="type">Donation Type</label>
                                                <select class="form-select form-select-sm" data-control="select2" name="type" id="type" required>
                                                  <option value="">Select One</option>
                                                  <option value="Esewa">Esewa</option>
                                                  <option value="QR">QR</option>
                                                  <option value="Khalti">Khalti</option>
                                                  <option value="Nepal Pay">Nepal Pay</option>
                                                  <option value="Bank Transfer">Bank Transfer</option>
                                                  <option value="Cheque">Cheque</option>
                                                  <option value="Cash">Cash</option>
                                                  <option value="Donation Box">Donation Box</option>
                                                  <option value="Int'l Transfer">Int'l Transfer</option>
                                                  <option value="Other">Other</option>
                                                </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                              <div class="form-group">
                                                  <label for="status">Status</label>
                                                  <select class="form-select form-select-sm" data-control="select2" name="status" id="status" required>
                                                    <option value="">Select One</option>
                                                    <option value="Paid">Paid</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Schedule">Schedule</option>
                                                    <option value="Refund">Refund</option>
                                                    <option value="Cancelled">Cancelled</option>
                                                  </select>
                                              </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                                <div class="form-group">
                                                    <label for="voucher">Voucher No.</label>
                                                    <input type="text" name="voucher" id="voucher" class="form-control" />
                                                </div>
                                              </div>
                                      </div>
                                    <div class="row mb-2">
                                      <input type="hidden" name="designation" value="Head" />
                                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                          <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
                                      </div>
                                    </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endcan
                      <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                      <!--begin::Table-->
                      @if($donations->count() != NULL)


                      <div class="table-responsive">
                          <table class="table align-middle table-row-dashed gy-5" id="donationtable">
                            <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                              <tr class="text-start text-muted text-uppercase gs-0">
                                <th>SN</th>
                                <th>Branch</th>
                                <th>Donation</th>
                                <th>Paid By</th>
                                <th>Status</th>
                                <th>Voucher</th>
                              </tr>
                          </thead>
                          <tbody class="fs-6 fw-semibold text-gray-600">
                          @php $i = ($donations->perPage() * ($donations->currentPage() - 1)) + 1;; @endphp
                            @foreach($donations as $donation)
                            <tr>
                              <td>@php echo $i; @endphp</td>
                              <td>{{$donation->getbranch->title}}</td>
                              <td>{{$donation->donation}}</td>
                              <td>{{$donation->donationtype}}</td>
                              <td>
                                  @if($donation->status == 'Paid') <span class="badge badge-light-success">Paid</span> @endif
                                  @if($donation->status == 'Pending') <span class="badge badge-light-info">Pending</span> @endif
                                  @if($donation->status == 'Schedule') <span class="badge badge-light-primary">Schedule</span> @endif
                                  @if($donation->status == 'Refund') <span class="badge badge-light-danger">Refund</span> @endif
                                  @if($donation->status == 'Cancelled') <span class="badge badge-light-danger">Cancelled</span> @endif
                              </td>
                              <td>{{$donation->voucher}}</td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                          </tbody>
                        </table>
                        <div class="mt-2">{!! $donations->links() !!}</div>
                      </div>
                      @else
                      <div class="demo-spacing-0"><div class="alert alert-primary" role="alert"><div class="alert-body">No Donation Found!</div></div></div>
                      @endif
                    </div>
                  </div>
                </div>
                @endcan
                @can('course-list')
                <div class="tab-pane fade" id="courses" role="tabpanel">
                  <!--begin::Card-->
                  <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                      <!--begin::Card title-->
                      <div class="card-title">
                        <h2>Courses</h2>
                      </div>
                      <!--end::Card title-->
                      <!--begin::Card toolbar-->
                      @can('course-create')
                      
                      <div class="card-toolbar">
                        <a href="#" class="btn btn-sm btn-flex btn-light-primary" data-bs-toggle="modal" data-bs-target="#addcourse">
                        <i class="ki-outline ki-plus-square fs-3"></i>Add Course</a>
                      </div>
                      <div class="modal fade" id="addcourse" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_user_header">
                              <h2 class="fw-bold">Add Course</h2>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                              </div>
                            </div>
                            <div class="modal-body">
                              <form method="post" action="{{ route('course-taken.store') }}" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" id="devotee" name="devotee" value="{{$view->id}}" />
                                  <div class="row mb-2">
                                        <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                            <div class="form-group">
                                                <label for="course">Course</label>
                                                <select class="form-select form-select-sm" data-control="select2" name="course" id="course" required>
                                                  <option value="">Select One</option>
                                                  @if($courses->count() != NULL)
                                                    @foreach($courses as $course)
                                                      <option value="{{$course->id}}">{{$course->title}}</option>
                                                    @endforeach
                                                  @endif
                                                </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                              <div class="form-group">
                                                  <label for="certificate">Certificate</label>
                                                  <input type="file" class="form-control" name="certificate" id="certificate" />
                                              </div>
                                            </div>
                                          <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                              <div class="form-group">
                                                  <label for="status">Status</label>
                                                  <select class="form-select form-select-sm" data-control="select2" name="status" id="status" required>
                                                    <option value="">Select One</option>
                                                    <option value="Completed">Completed</option>
                                                    <option value="Droped">Droped</option>
                                                    <option value="Ongoing">Ongoing</option>
                                                  </select>
                                              </div>
                                            </div>
                                      <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                          <div class="form-group">
                                              <label for="fromdate">From Date</label>
                                              <input type="text" class="form-control" name="fromdate" id="fromdate">
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                            <div class="form-group">
                                                <label for="todate">To Date</label>
                                                <input type="text" class="form-control" name="todate" id="todate">
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                              <div class="form-group">
                                                  <label for="attendmarks">Attend Marks</label>
                                                  <input type="number" class="form-control" name="attendmarks" id="attendmarks">
                                              </div>
                                            </div>
                                      </div>
                                    <div class="row mb-2">
                                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                          <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
                                      </div>
                                    </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    
                      @endcan
                      <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                    
                      @if($attendcourses->count() != NULL)
                        <ul class="coursecertificates">
                          @foreach($attendcourses as $attendcourse)
                            @if($attendcourse->getcourse->image != NULL)<li><a href="{{ route('coursephoto.show', ['imageName' => $attendcourse->getcourse->image]) }}" data-fancybox="gallery"><img src="{{ route('coursephoto.show', ['imageName' => $attendcourse->getcourse->image]) }}" alt="image" width="100" /></a></li>@endif
                          @endforeach
                        </ul>
                      @endif
                      @if($attendcourses->count() != NULL)
                      <div class="table-responsive">
                          <table class="table align-middle table-row-dashed gy-5">
                            <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                              <tr class="text-start text-muted text-uppercase gs-0">
                                <th>SN</th>
                                <th>Branch</th>
                                <th>Course</th>
                                <th>Date</th>
                                <th>Marks</th>
                                <th>Certificate</th>
                                <th>Action</th>
                              </tr>
                          </thead>
                          <tbody class="fs-6 fw-semibold text-gray-600">
                          @php $i = ($attendcourses->perPage() * ($attendcourses->currentPage() - 1)) + 1;; @endphp
                            @foreach($attendcourses as $attendcourse)
                            <tr>
                              <td>@php echo $i; @endphp</td>
                              <td>{{$attendcourse->getbranch->title}}</td>
                              <td>{{$attendcourse->getcourse->title}}</td>
                              <td>
                                <strong>From Date: </strong>{{$attendcourse->fromdate}}<br />
                                <strong>To Date: </strong>{{$attendcourse->todate}}
                              </td>
                              <td>
                                Total: {{$attendcourse->totalmarks}}<br />
                                Attend: {{$attendcourse->attendmarks}}<br />
                                Percent: {{$attendcourse->percentage}}
                              </td>
                              <td>@if($attendcourse->certificate != NULL)<a href="{{ route('certificate.show', ['imageName' => $attendcourse->certificate]) }}" target="_blank">View</a>@endif</td>
                              <td>
                                  @can('course-edit')
                                  <a href="{{ route('course-taken.edit', $attendcourse->id)}}" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3 d-inline-flex align-middle">
                                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit">
                                      <i class="ki-outline ki-pencil fs-3"></i>
                                    </span>
                                  </a>
                                  @endcan
                                  @can('course-delete')
                                  <form action="{{ route('course-taken.destroy', $attendcourse->id)}}" method="post" class=" d-inline-flex align-middle">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" onclick="return confirm('Are you sure to delete this data?')" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Delete"><i class="ki-outline ki-trash fs-3"></i></button>
                                  </form>
                                  @endcan
                              </td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                          </tbody>
                        </table>
                        <div class="mt-2">{!! $attendcourses->links() !!}</div>
                      </div>
                      @else
                      <div class="demo-spacing-0"><div class="alert alert-primary" role="alert"><div class="alert-body">No listing found!</div></div></div>
                      @endif
                   
                    </div>
                  </div>
                </div>
                @endcan
                @can('initiative-list')
                  <div class="tab-pane fade" id="initiative" role="tabpanel">
                     <!--begin::Card-->
                     <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                           <!--begin::Card title-->
                           <div class="card-title">
                              <h2>Initation Details</h2>
                           </div>
                           <!--end::Card title-->
                           <!--begin::Card toolbar-->
                           @can('initiative-create')
                           <div class="card-toolbar">
                              <a href="#" class="btn btn-sm btn-flex btn-light-primary" data-bs-toggle="modal" data-bs-target="#addinitiation"><i class="ki-outline ki-plus-square fs-3"></i>Add Initiation</a>
                           </div>
                           <div class="modal fade" id="addinitiation" tabindex="-1"
                              aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered mw-650px">
                                 <div class="modal-content">
                                    <div class="modal-header"
                                       id="kt_modal_add_user_header">
                                       <h2 class="fw-bold">Add Initiation</h2>
                                       <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                          <i class="ki-outline ki-cross fs-1"></i>
                                       </div>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="{{ route('postfirstform') }}" enctype="multipart/form-data">
                                          @csrf
                                          <input type="hidden" id="devotee_id" name="devotee_id" value="{{ $view->id }}" />
                                          <div class="row mb-2">
                                          <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                             <div class="form-group">
                                                <label for="course">Initiation Type <span class="required"></span></label>
                                                <select class="form-select" data-control="select2" name="initiation_type" id="initiation_type" required>
                                                   <option value="">Select One</option>
                                                   <option value="Sheltered">Sheltered</option>
                                                   <option value="Harinam Initiation">Harinam Initiation</option>
                                                   <option value="Brahman Initiation">Brahman Initiation</option>
                                                </select>
                                             </div>
                                          </div>
                                          </div>
                                          <div class="row mb-2">
                                             <div
                                                class="col-12 d-flex flex-sm-row flex-column mt-2">
                                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Next</button>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           @endcan
                           <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">
                           @if ($initiationcheck->count() > 0)
                           <div class="table-responsive">
                              <table
                                 class="table align-middle table-row-dashed gy-5 table-striped">
                                 <thead
                                    class="border-bottom border-gray-200 fs-7 fw-bold">
                                    <tr
                                       class="text-start text-muted text-uppercase gs-0">
                                       <th>SN</th>
                                       <th>Initiation Name</th>
                                       <th>Initiation Guru</th>
                                       <th>Initiation Date</th>
                                       <th>Initiation Type</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody class="fs-6 fw-semibold text-gray-600">
                                   @foreach($initiationcheck as $initiation)
                                    <tr>
                                       <td>1</td>
                                       <td>{{ $initiation->initiation_name }}</td>
                                       <td><a href="{{ route('devotees.show', $initiation->getinitiationguru->name)}}">
                                         <?php if(Helper::getdevoteebyid($initiation->getinitiationguru->name)->firstname != NULL){ echo Crypt::decrypt(Helper::getdevoteebyid($initiation->getinitiationguru->name)->firstname); } ?>
                                         <?php if(Helper::getdevoteebyid($initiation->getinitiationguru->name)->middlename != NULL){ echo Crypt::decrypt(Helper::getdevoteebyid($initiation->getinitiationguru->name)->middlename); } ?>
                                         <?php if(Helper::getdevoteebyid($initiation->getinitiationguru->name)->surname != NULL){ echo Crypt::decrypt(Helper::getdevoteebyid($initiation->getinitiationguru->name)->surname); } ?>
                                       </a></td>
                                       <td>{{ $initiation->initiation_date }}</td>
                                       <td>{{ $initiation->initiation_type }}</td>
                                       <td class="text-end">
                                         <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                         <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                         <!--begin::Menu-->
                                         <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                           @can('initiative-list')
                                           <div class="menu-item px-3">
                                             <a href="{{route('initiation.show', $initiation->id)}}" class="btn btn-light d-block">View</a>
                                           </div>
                                           @endcan
                                           @can('initiative-edit')
                                           <div class="menu-item px-3">
                                             <a href="{{route('initiation.edit', $initiation->id)}}" class="btn btn-light d-block">Edit</a>
                                           </div>
                                           @endcan
                                           @can('initiative-delete')
                                           <div class="menu-item px-3">
                                             <form action="{{ route('initiation.destroy', $initiation->id)}}" method="post">
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
                           <div class="demo-spacing-0">
                              <div class="alert alert-primary" role="alert">
                                 <div class="alert-body">No listing found!</div>
                              </div>
                           </div>
                           @endif
                        </div>
                     </div>
                  </div>
                  @endcan
              </div>
            </div>
          </div>
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
    </div>
  </div>
  <!--end:::Main-->
@endsection

@section('scripts')
@php
$today = date('Y-m-d');
$nextdate = date('Y-m-d', strtotime('+5 year'));
@endphp
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $("#dob").flatpickr({ dateFormat: "Y-m-d", disable: [{from:'{{$today}}', to:'{{$nextdate}}'}] });
  $("#fromdate").flatpickr({ dateFormat: "Y-m-d", disable: [{from:'{{$today}}', to:'{{$nextdate}}'}] });
  $("#todate").flatpickr({ dateFormat: "Y-m-d", disable: [{from:'{{$today}}', to:'{{$nextdate}}'}] });
});
</script>
<?php
$myArray = array();
if($skilllists->count() != NULL){
  foreach($skilllists as $skilllist){
    $myArray[] = '"'.ucfirst($skilllist->title).'"';
  }
}
$skillsarray = implode( ', ', $myArray );
?>
<script type="text/javascript">
var input = document.querySelector("#skills");

new Tagify(input, {
    whitelist: [<?php echo $skillsarray; ?>],
    maxTags: 10,
    dropdown: {
        maxItems: 20,
        classname: "tagify__inline__suggestions",
        enabled: 0,
        closeOnSelect: false
    }
});
</script>
@endsection
