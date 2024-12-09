@extends('backend.layouts.master')

@section('styles')
<link href="{{asset('themes/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('themes/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Service Attendance</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('sewa-attend.index')}}" class="text-muted text-hover-primary">Service Management</a>
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
                  <form method="get" action="{{route('attendsewasearch')}}" enctype="multipart/form-data">
                    <!--begin::Card-->
                    <div class="card mb-7">

                      <!--begin::Card body-->
                      <div class="card-body">
                        <!--begin::Compact form-->
                        <div class="row align-items-center">
                          <div class="col-md-2 col-md-2 col-lg-2">
                            <label class="fs-6 form-label fw-bold text-gray-900" for="daterange">Select Date Range</label>
                            <input type="text" class="form-control" name="daterange" id="daterange" @if(isset($_GET['daterange'])) value="{{$_GET['daterange']}}" @endif autocomplete="off" />
                          </div>
                          <div class="col-md-3 col-md-3 col-lg-3">
                            <label class="fs-6 form-label fw-bold text-gray-900" for="devotee">Devotee</label>
                            <select class="form-control" name="devotee" id="devotee">
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
                          <div class="col-lg-2">
                            <label class="fs-6 form-label fw-bold text-gray-900" for="branch">Department</label>
                            <select class="form-select" name="department" data-control="select2">
                              <option value="">Select Department</option>
                              @if($departments->count() != NULL)
                                @foreach($departments as $department)
                                  <option value="{{$department->id}}" @if(isset($_GET['department']) && ($_GET['department'] == $department->id)) selected @endif>{{$department->title}}</option>

                                  @if(count($department->subcategory))
                                    @include('backend.attendsewa.subdepartment',['subcategories' => $department->subcategory])
                                  @endif

                                @endforeach
                              @endif
                            </select>
                          </div>
                          <div class="col-lg-2">
                            <label class="fs-6 form-label fw-bold text-gray-900" for="branch">Branch</label>
                            <select class="form-select" name="branch" data-control="select2">
                              <option value="">Select Branch</option>
                              @if($branches->count() != NULL)
                                @foreach($branches as $branch)
                                  <option value="{{$branch->id}}" @if(isset($_GET['branch']) && ($_GET['branch'] == $branch->id)) selected @endif>{{$branch->title}}</option>
                                @endforeach
                              @endif
                            </select>
                          </div>
                          <div class="col-lg-2">
                            <label class="fs-6 form-label fw-bold text-gray-900" for="designation">Designation</label>
                            <select class="form-select" name="designation" data-control="select2">
                              <option value="">Select Designation</option>
                              <option value="Volunteer" @if(isset($_GET['designation']) && ($_GET['designation'] == 'Volunteer')) selected @endif>Volunteer</option>
                              <option value="Head" @if(isset($_GET['designation']) && ($_GET['designation'] == 'Head')) selected @endif>Head</option>
                            </select>
                          </div>
                          <div class="col-md-1 col-md-1 col-lg-1 pt-7">
                            <input type="hidden" name="search" value="true" />
                            <button type="submit" class="btn btn-primary me-5">Search</button>
                          </div>
                        </div>
                        </div>
                      </div>
                  </form>


                <div class="card">
                  <div class="card-header border-0 pt-6">
                    <div class="card-toolbar">
                      <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{route('sewa-attend.create')}}" class="btn btn-primary">
                        <i class="ki-outline ki-plus fs-2"></i>Add Service Attendance</a>
                      </div>
                      @if (Route::currentRouteName() == 'sewaattendtrash')
                      <a href="{{route('sewa-attend.index')}}" type="button" class="btn btn-primary ms-2">
                      <i class="ki-outline ki-file fs-2"></i>All Lists</a>
                      @else
                      <a href="{{route('sewaattendtrash')}}" type="button" class="btn btn-primary ms-2">
                      <i class="ki-outline ki-trash fs-2"></i>Trash Folder</a>
                      @endif
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
                              <th>Devotee</th>
                              <th>Branch</th>
                              <th>Service Department</th>
                              <th>Date</th>
                              <th>Designation</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = ($lists->perPage() * ($lists->currentPage() - 1)) + 1;; @endphp
                          @foreach($lists as $list)
                          <tr>
                            <td>@php echo $i; @endphp</td>
                            <td><a href="{{ route('devotees.show', $list->getdevotee->id)}}">
                              @if($list->devotee_id != NULL){{Crypt::decrypt($list->getdevotee->firstname)}}@endif
                              {{--@if($list->devotee_id != NULL){{Crypt::decrypt($list->getdevotee->middlename)}}@endif --}}
                              @if($list->devotee_id != NULL){{Crypt::decrypt($list->getdevotee->surname)}}@endif
                            </a></td>
                            <td>{{$list->getbranch->title}}</td>
                            <td>{{$list->getdepartment->title}}</td>
                            <td>{{$list->date}}</td>
                            <td>{{$list->designation}}</td>
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <!--begin::Menu-->
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                                @if (Route::currentRouteName() == 'sewaattendtrash')
                                @can('sewa-delete')
                                <div class="menu-item px-3">
                                  <a href="{{ route('sewaattendrestore', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-arrows-loop fs-2"></i> Restore</a>
                                </div>
                                <div class="menu-item px-3">
                                  <form action="{{ route('sewa-attend.destroy', $list->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i> Permanently Delete</button>
                                  </form>
                                </div>
                                @endcan
                                @else
                                @can('sewa-edit')
                                <div class="menu-item px-3">
                                  <a href="{{ route('sewa-attend.edit', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-pencil fs-2"></i> Edit</a>
                                </div>
                                @endcan
                                @can('sewa-delete')
                                <div class="menu-item px-3">
                                  <a href="{{ route('sewaattendmovetotrash', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-trash fs-2"></i> Trash</a>
                                </div>
                                @endcan
                                @endif
                              </div>
                            </td>
                          </tr>
                          @php $i++; @endphp
                          @endforeach
                        </tbody>
                      </table>
                      <div class="mt-2">{!! $lists->links() !!}</div>
                    </div>
                    @else
                    <div class="demo-spacing-0"><div class="alert alert-primary" role="alert"><div class="alert-body">No listing found!</div></div></div>
                    @endif

                    <!--<div id="kt_docs_fullcalendar_populated"></div>-->

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
</script>
@endsection
