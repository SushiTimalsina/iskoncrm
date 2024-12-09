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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Batch Details</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('course-batch.index')}}" class="text-muted text-hover-primary">Batch Management</a>
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
                      @can('course-edit')
                      <div class="d-flex ms-3 justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{ route('course-batch.edit', $show->id)}}" class="btn btn-primary">
                        <i class="ki-outline ki-pencil fs-2"></i>Edit</a>
                      </div>
                      @endcan
                      @can('course-delete')
                      <div class="d-flex ms-3 justify-content-end" data-kt-user-table-toolbar="base">
                        <form action="{{ route('course-batch.destroy', $show->id)}}" method="post">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i>Trash</button>
                        </form>
                      </div>
                      @endcan
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

                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-lg-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                              <tr>
                                <th>Name</th>
                                <td>{{$show->name}}</td>
                              </tr>
                              <tr>
                                <th>Course</th>
                                <td>{{$show->getcourse->title}}</td>
                              </tr>
                              <tr>
                                <th>Facilitator</th>
                                <td><a href="{{ route('devotees.show', Helper::getdevoteebyfacilitator($show->facilitators_id)->id) }}">
                                  @if(Helper::getdevoteebyfacilitator($show->facilitators_id) != NULL){{Crypt::decrypt(Helper::getdevoteebyfacilitator($show->facilitators_id)->firstname)}}@endif
                                  @if(Helper::getdevoteebyfacilitator($show->facilitators_id) != NULL){{Crypt::decrypt(Helper::getdevoteebyfacilitator($show->facilitators_id)->middlename)}}@endif
                                  @if(Helper::getdevoteebyfacilitator($show->facilitators_id) != NULL){{Crypt::decrypt(Helper::getdevoteebyfacilitator($show->facilitators_id)->surname)}}@endif
                                </a>
                                </td>
                              </tr>
                              <tr>
                                <th>Branch</th>
                                <th>{{$show->getbranch->title}}</th>
                              </tr>
                              <tr>
                                <th>Certificate</th>
                                <th>@if($show->certificate != NULL)<a href="{{ route('certificate.show', ['imageName' => $show->certificate]) }}" target="_blank">View</a>@endif</th>
                              </tr>
                              <tr>
                                <th>Full Marks</th>
                                <th>{{$show->fullmarks}}</th>
                              </tr>
                            </table>
                          </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-lg-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                              <tr>
                                <th>Exam Type</th>
                                <th>{{$show->examtype}}</th>
                              </tr>
                              <tr>
                                <th>Fee</th>
                                <th>Rs. {{$show->fee}}</th>
                              </tr>
                              <tr>
                                <th>Date</th>
                                <td><strong>Start Date: </strong> {{$show->start_date}}<br /><strong>End Date: </strong>{{$show->end_date}}</td>
                              </tr>
                              <tr>
                                <th>Type</th>
                                <td>{{$show->type}}</td>
                              </tr>
                              <tr>
                                <th>Unit</th>
                                <td>{{$show->unit}} {{$show->unitdays}}</td>
                              </tr>
                              <tr>
                                <th>Status</th>
                                <td>
                                  @if($show->status == 'Completed') <span class="badge badge-light-success">Completed</span> @endif
                                  @if($show->status == 'Active') <span class="badge badge-light-primary">Active</span> @endif
                                  @if($show->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
                                  @if($show->status == 'Not Started') <span class="badge badge-light-info">Not Started</span> @endif
                                  @if($show->status == 'In Progress') <span class="badge badge-light-warning">In Progress</span> @endif
                                  @if($show->status == 'Trash') <span class="badge badge-light-danger">Trash</span> @endif
                                </td>
                              </tr>
                            </table>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card mt-5">
                  <div class="card-header border-0 pt-6">
                    <h3 class="pt-5">Devotees</h3>
                    <div class="card-toolbar">
                    @if($show->status != 'Completed')
                      @can('course-create')
                      <div class="d-flex" data-kt-user-table-toolbar="base">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <i class="ki-outline ki-plus fs-2"></i>Add Devotee</button>
                      </div>
                      <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_user_header">
                              <h2 class="fw-bold">Add Devotee</h2>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                              </div>
                            </div>
                            <div class="modal-body">
                              <form method="post" action="{{ route('course-batch-devotee.store') }}" enctype="multipart/form-data">
                                @csrf
                                  <div class="row">
                                      <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                        <div class="form-group">
                                            <label for="devotee">Devotee</label>
                                            <select class="form-control" name="devotees[]" id="devotee" multiple required>
                                              <option value="">Select One</option>
                                              @if($devotees->count() != NULL)
                                                @foreach($devotees as $devotee)
                                                <option value="{{$devotee->id}}"
                                                  data-kt-rich-content-email="<?php if($devotee->email_enc != NULL){ echo Crypt::decrypt($devotee->email_enc); } ?>"
                                                  data-kt-rich-content-mobile="<?php if($devotee->mobile_enc != NULL){ echo Crypt::decrypt($devotee->mobile_enc); } ?>"
                                                  data-kt-rich-content-initiation="@if(Helper::getinitiationrow($devotee->id)) {{Helper::getinitiationrow($devotee->id)->initiation_name}} @endif"
                                                   @if(isset($_GET['devotee']) && ($_GET['devotee'] == $devotee->id)) selected @endif
                                                  >
                                                  <?php if($devotee->firstname != NULL){ echo Crypt::decrypt($devotee->firstname); } ?>
                                                  <?php if($devotee->middlename != NULL){ echo Crypt::decrypt($devotee->middlename); } ?>
                                                  <?php if($devotee->surname != NULL){ echo Crypt::decrypt($devotee->surname); } ?>
                                                  </option>
                                                @endforeach
                                              @endif
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                        <input type="hidden" value="{{$show->id}}" name="batch" id="batch" />
                                        <input type="hidden" value="{{$show->branch_id}}" name="branch" id="branch" />
                                        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
                                      </div>
                                    </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="d-flex ms-2" data-kt-user-table-toolbar="base">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_payment">
                        <i class="ki-outline ki-dollar fs-2"></i>Add Payment</button>
                      </div>
                      <div class="modal fade" id="add_payment" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_user_header">
                              <h2 class="fw-bold">Add Payment</h2>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                              </div>
                            </div>
                            <div class="modal-body">
                              <form method="post" action="{{ route('coursedonationstore') }}" enctype="multipart/form-data">
                                @csrf
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                      <div class="form-group">
                                          <label for="devotee">Devotee</label>
                                          <select class="form-control paymentdevotee" name="devotee" id="devoteepay" required>
                                            <option value="">Select One</option>
                                            @if($related_devotees->count() != NULL)
                                              @foreach($related_devotees as $devotee)
                                                  <option value="{{$devotee->devotee_id}}"
                                                    data-kt-rich-content-email="<?php if(Helper::getdevoteebyid($devotee->devotee_id)->email_enc != NULL){ echo Crypt::decrypt(Helper::getdevoteebyid($devotee->devotee_id)->email_enc); } ?>"
                                                    data-kt-rich-content-mobile="<?php if(Helper::getdevoteebyid($devotee->devotee_id)->mobile_enc != NULL){ echo Crypt::decrypt(Helper::getdevoteebyid($devotee->devotee_id)->mobile_enc); } ?>"
                                                    data-kt-rich-content-initiation="@if(Helper::getinitiationrow($devotee->id)) {{Helper::getinitiationrow($devotee->id)->initiation_name}} @endif"
                                                     @if(isset($_GET['devotee']) && ($_GET['devotee'] == $devotee->id)) selected @endif
                                                    >
                                                    <?php if(Helper::getdevoteebyid($devotee->devotee_id)->firstname != NULL){ echo Crypt::decrypt(Helper::getdevoteebyid($devotee->devotee_id)->firstname); } ?>
                                                    <?php if(Helper::getdevoteebyid($devotee->devotee_id)->middlename != NULL){ echo Crypt::decrypt(Helper::getdevoteebyid($devotee->devotee_id)->middlename); } ?>
                                                    <?php if(Helper::getdevoteebyid($devotee->devotee_id)->surname != NULL){ echo Crypt::decrypt(Helper::getdevoteebyid($devotee->devotee_id)->surname); } ?>
                                                    </option>
                                              @endforeach
                                            @endif
                                          </select>
                                      </div>
                                    </div>


                                    <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="number" name="amount" id="amount" class="form-control" />
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                          <div class="form-group">
                                              <label for="paidby">Paid By</label>
                                              <select class="form-select form-select-sm" data-control="select2" name="paidby" id="paidby" required>
                                                <option value="">Select One</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Esewa">Esewa</option>
                                                <option value="Khalti">Khalti</option>
                                                <option value="Connect IPS">Connect IPS</option>
                                                <option value="Mobile Banking">Mobile Banking</option>
                                                <option value="Other">Other</option>
                                              </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                            <div class="form-group">
                                                <label for="voucher">Voucher No.</label>
                                                <input type="text" name="voucher" id="voucher" class="form-control" />
                                            </div>
                                          </div>
                                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                        <input type="hidden" value="{{$show->id}}" name="batch" id="batch" />
                                        <input type="hidden" value="{{$show->branch_id}}" name="branch" id="branch" />
                                        <input type="hidden" value="{{$show->name}}" name="name" id="name" />
                                        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Payment Create</button>
                                      </div>
                                    </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="d-flex ms-2" data-kt-user-table-toolbar="base">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_attendance">
                        <i class="ki-outline ki-calendar fs-2"></i>Add Attendance</button>
                      </div>
                      <div class="modal fade" id="add_attendance" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_user_header">
                              <h2 class="fw-bold">Attendance</h2>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                              </div>
                            </div>
                            <div class="modal-body">
                                  <div class="row">
                                      <div class="col-md-6 col-sm-6 col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="text" class="form-control" name="date" id="date" />
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6 col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label for="time">Time</label>
                                            <select name="time" id="time" class="form-select" required>
                                              <option value="">Select One</option>
                                              <option value="10:00 AM">10:00 AM</option>
                                              <option value="11:00 AM">11:00 AM</option>
                                              <option value="12:00 PM">12:00 PM</option>
                                              <option value="1:00 PM">1:00 PM</option>
                                              <option value="2:00 PM">2:00 PM</option>
                                              <option value="3:00 PM">3:00 PM</option>
                                              <option value="4:00 PM">4:00 PM</option>
                                              <option value="5:00 PM">5:00 PM</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6 col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select name="type" id="type" class="form-select" required>
                                              <option value="">Select One</option>
                                              <option value="Present">Present</option>
                                              <option value="Late">Late</option>
                                              <option value="Absent">Absent</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                        <input type="hidden" value="{{$show->id}}" name="batchname" id="batchname" />
                                        <input type="hidden" value="{{$show->branch_id}}" name="branch" id="branch" />
                                        <input type="hidden" value="{{$show->course_id}}" name="coursename" id="coursename" />
                                        <button type="submit" id="attendance" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
                                      </div>
                                    </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endcan
                      @endif
                    </div>
                  </div>
                  <div class="card-body py-4">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="devoteetable">
                        <thead>
                            <tr>
                              @if($show->status != 'Completed')
                              <th class="w-20px pe-2">
  															<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
  																<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#devoteetable .form-check-input" id="master" />
  															</div>
  														</th>
                              @endif
                              <th>Devotee</th>
                              <th>Paid Amount</th>
                              <th>Remaining Amount</th>
                              <th>Obtained Marks</th>
                              <th>Certificate</th>
                              @if($show->status != 'Completed')
                              <th>Action</th>
                              @endif
                            </tr>
                        </thead>
                        <tbody>
                          @if($related_devotees->count() != NULL)
                          @foreach($related_devotees as $related_devotee)
                          <tr>
                            @if($show->status != 'Completed')
                            <td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" name="ids" id="productsfordel" value="{{$related_devotee->devotee_id}}" type="checkbox" />
															</div>
														</td>
                            @endif
                            <td>

                              <a href="{{ route('devotees.show', Helper::getdevoteebyid($related_devotee->devotee_id)) }}">
                                @if(Helper::getdevoteebyid($related_devotee->devotee_id)->firstname != NULL){{Crypt::decrypt(Helper::getdevoteebyid($related_devotee->devotee_id)->firstname)}}@endif
                                @if(Helper::getdevoteebyid($related_devotee->devotee_id)->middlename != NULL){{Crypt::decrypt(Helper::getdevoteebyid($related_devotee->devotee_id)->middlename)}}@endif
                                @if(Helper::getdevoteebyid($related_devotee->devotee_id)->surname != NULL){{Crypt::decrypt(Helper::getdevoteebyid($related_devotee->devotee_id)->surname)}}@endif
                              </a>
                            </td>
                            <td>{{Helper::getcoursebatchpayment($show->id, $related_devotee->devotee_id)->sum('donation')}}</td>
                            <td>{{($show->fee) - (Helper::getcoursebatchpayment($show->id, $related_devotee->devotee_id)->sum('donation'))}}</td>
                            <td>{{$related_devotee->attendmark}}</td>
                            <td>@if($show->certificate != NULL)<a href="{{route('certificatepdf', $related_devotee->id)}}">View Certificate</a>@endif</td>
                            @if($show->status != 'Completed')
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <!--begin::Menu-->
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                @can('course-edit')
                                <div class="menu-item px-3">
                                  <a class="btn btn-light d-block open-AddBookDialog" data-bs-toggle="modal" id="edit-item" data-bs-target="#addBookDialog" data-id="{{$related_devotee->id}}" data-name="{{Helper::getdevoteebyid($related_devotee->devotee_id)->firstname}} {{Helper::getdevoteebyid($related_devotee->devotee_id)->middlename}} {{Helper::getdevoteebyid($related_devotee->devotee_id)->surname}}" data-fullmark={{$show->fullmarks}}>Edit</a>
                                </div>
                                @endcan
                                @can('course-delete')
                                <div class="menu-item px-3">
                                  <form action="{{ route('course-batch-devotee.destroy', $related_devotee->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete">Trash</button>
                                  </form>
                                </div>
                                @endcan
                              </div>
                            </td>
                            @endif
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="card mt-5">
                  <div class="card-header border-0 pt-6">
                    <h3 class="pt-5">Attendance</h3>
                  </div>
                  <div class="card-body py-4">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="devoteetable">
                        <thead>
                            <tr>
                              <th>SN</th>
                              <th>Devotee</th>
                                @foreach($entryDates as $date)
                                  <th>{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}</th>
                                @endforeach
                              @if($show->status != 'Completed')
                              <th>Action</th>
                              @endif
                            </tr>
                        </thead>
                        <tbody>
                          @php $i = 1; @endphp
                          @if($related_devotees->count() != NULL)
                          @foreach($related_devotees as $related_devotee)
                          <tr>
                            <td>{{$i}}</td>
                            <td>
                              <a href="{{ route('devotees.show', Helper::getdevoteebyid($related_devotee->devotee_id)) }}">
                                @if(Helper::getdevoteebyid($related_devotee->devotee_id)->firstname != NULL){{Crypt::decrypt(Helper::getdevoteebyid($related_devotee->devotee_id)->firstname)}}@endif
                                @if(Helper::getdevoteebyid($related_devotee->devotee_id)->middlename != NULL){{Crypt::decrypt(Helper::getdevoteebyid($related_devotee->devotee_id)->middlename)}}@endif
                                @if(Helper::getdevoteebyid($related_devotee->devotee_id)->surname != NULL){{Crypt::decrypt(Helper::getdevoteebyid($related_devotee->devotee_id)->surname)}}@endif
                              </a>
                            </td>
                            @foreach($entryDates as $date)
                              @php
                                $attendancerow = isset($attendances[$related_devotee->devotee_id][$date]) ? $attendances[$related_devotee->devotee_id][$date] : null;
                              @endphp
                                <td>
                                    @if($attendancerow)
                                      @if($attendancerow->type == 'Present') <span class="badge badge-light-success">Present</span> @endif
                                      @if($attendancerow->type == 'Late') <span class="badge badge-light-info">Late</span> @endif
                                      @if($attendancerow->type == 'Absent') <span class="badge badge-light-danger">Absent</span> @endif
                                    @else
                                      <span class="badge badge-secondary">Not Listed</span>
                                    @endif
                                </td>
                            @endforeach
                            @if($show->status != 'Completed')
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <!--begin::Menu-->
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                @can('course-delete')
                                <!--<div class="menu-item px-3">
                                  <form action="{{ route('course-attend.destroy', $related_devotee->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete">Trash</button>
                                  </form>
                                </div>-->
                                @endcan
                              </div>
                            </td>
                            @endif
                          </tr>
                          @php $i++; @endphp
                          @endforeach
                          @endif
                        </tbody>
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


<div class="modal fade" id="addBookDialog" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" id="kt_modal_add_user_header">
        <h2 class="fw-bold">Edit Data</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
          <i class="ki-outline ki-cross fs-1"></i>
        </div>
      </div>
      <div class="modal-body" id="attachment-body-content">
        <div class="form-group">
          <input type="hidden" name="attendancedevotee" class="form-control" id="attendancedevotee" value="" />
          <input type="hidden" name="fullmark" class="form-control" id="fullmark" value="" />
          <input type="text" name="bookname" class="form-control" id="bookname" value="" readonly />
        </div>
        <div class="form-group mt-5">
          <label for="attendmark">Attend Mark</label>
          <input type="number" class="form-control mt-2" name="attendmark" id="attendmark" required />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="attendmarkssubmit" data-dismiss="modal">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('themes/assets/plugins/global/plugins.bundle.js')}}"></script>
@php
$today = date('Y-m-d');
$nextdate = date('Y-m-d', strtotime('+5 year'));
@endphp
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
$('#devotee').select2({
    placeholder: "Select an option",
    templateSelection: optionFormat,
    templateResult: optionFormat
});
$('#devoteepay').select2({
    placeholder: "Select an option",
    templateSelection: optionFormat,
    templateResult: optionFormat
});
</script>
<script type="text/javascript">
  $(document).ready(function() {
      $("#date").flatpickr();
  });
</script>

<script type="text/javascript">
$(function(e){
  $('#attendance').click(function(e){
    e.preventDefault();
    var all_ids = [];
    var datevalue = document.getElementById('date').value;
    var timevalue = document.getElementById('time').value;
    var typevalue = document.getElementById('type').value;
    var batchvalue = document.getElementById('batchname').value;
    var coursevalue = document.getElementById('coursename').value;
    var branchvalue = document.getElementById('branch').value;
    $('input:checkbox[name=ids]:checked').each(function(){
      all_ids.push($(this).val());
    });

    if((datevalue =='') && (timevalue =='') && (typevalue =='')){
      alert("Please input all fields value and try again.");
    }else{
      $.ajax({
        url:"{{ route('getattendancepost') }}",
        type:"POST",
        data:{
          ids:all_ids,
          datevalue:datevalue,
          timevalue:timevalue,
          typevalue:typevalue,
          batchvalue:batchvalue,
          coursevalue:coursevalue,
          branchvalue:branchvalue,
          _token:'{{ csrf_token() }}'
        },

        success:function(response){
          window.location.reload();
        },

        error: function(error) {
          alert('Error Occured! Make sure you have selected at least one devotee.');
          console.log(error);
        }
      });
    }
  });
});
</script>

<script type="text/javascript">
$(document).on("click", ".open-AddBookDialog", function () {
     var myBookId = $(this).data('id');
     var bookname = $(this).data('name');
     var fullmark = $(this).data('fullmark');
     $(".modal-body #attendancedevotee").val( myBookId );
     $(".modal-body #bookname").val( bookname );
     $(".modal-body #fullmark").val( fullmark );
});
</script>

<script type="text/javascript">
$(function(e){
  $('#attendmarkssubmit').click(function(e){
    e.preventDefault();
    var devotee = document.getElementById('attendancedevotee').value;
    var attendmark = document.getElementById('attendmark').value;
    var fullmark = document.getElementById('fullmark').value;

    if((attendmark =='') && (devotee =='')){
      alert("Error Occured, Please try again!");
    }else{
      if(attendmark <= fullmark){
      $.ajax({
        url:"{{ route('attendmarks') }}",
        type:"POST",
        data:{
          devoteeid:devotee,
          attendmarks:attendmark,
          _token:'{{ csrf_token() }}'
        },

        success:function(response){
          window.location.reload();
        },

        error: function(error) {
          alert('Error Occured! Please try again.');
          console.log(error);
        }
      });
    }else{ alert("Attend marks seems wrong, please recheck and try again."); }
    }
  });
});
</script>
@endsection
