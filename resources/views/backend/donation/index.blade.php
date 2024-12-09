@extends('backend.layouts.master')

@section('styles')
<link href="{{asset('themes/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
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
              <!--begin::Title-->
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Donation</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('donation.index')}}" class="text-muted text-hover-primary">Donation Management</a>
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

                <form method="get" action="{{route('donationsearch')}}" enctype="multipart/form-data">
                  <!--begin::Card-->
                  <div class="card mb-7">

                    <!--begin::Card body-->
                    <div class="card-body">
                      <!--begin::Compact form-->
                      <div class="d-flex align-items-center">
                        <div class="position-relative w-md-200px me-md-2">
                          <label class="fs-6 form-label fw-bold text-gray-900" for="datefrom">Date</label>
                          <input type="text" class="form-control" name="daterange" id="daterange"  @if(isset($_GET['daterange'])) value="{{$_GET['daterange']}}" @endif autocomplete="off" />
                        </div>

                        <div class="position-relative w-md-200px me-md-2">
                          <label class="fs-6 form-label fw-bold text-gray-900" for="devotee">Devotee</label>
                          <select class="form-control" data-control="select2" name="devotee" id="devotee">
                            <option value="">Select One</option>
                            @if($devotees->count() != NULL)
                              @foreach($devotees as $devotee)
                                <option value="{{$devotee->id}}" @if(isset($_GET['devotee']) && ($_GET['devotee'] == $devotee->id)) selected @endif>
                                  @if($devotee->firstname != NULL){{Crypt::decrypt($devotee->firstname)}}@endif
                                  @if($devotee->middlename != NULL){{Crypt::decrypt($devotee->middlename)}}@endif
                                  @if($devotee->surname != NULL){{Crypt::decrypt($devotee->surname)}}@endif
                                </option>
                              @endforeach
                            @endif
                          </select>
                        </div>

                        <div class="position-relative w-md-200px me-md-2">
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

                        <div class="position-relative w-md-200px me-md-2">
                          <label class="fs-6 form-label fw-bold text-gray-900" for="sewa">Sewa</label>
                          <select class="form-select" name="sewa">
                            <option value="">Select Branch</option>
                            @if($sewas->count() != NULL)
                              @foreach($sewas as $sewa)
                                <option value="{{$sewa->id}}" @if(isset($_GET['sewa']) && ($_GET['sewa'] == $sewa->id)) selected @endif>{{$sewa->title}}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>

                        <div class="position-relative w-md-200px me-md-2">
                          <label class="fs-6 form-label fw-bold text-gray-900" for="type">Type</label>
                          <select class="form-select" name="type">
                            <option value="">Select Type</option>
                            <option value="Paid" @if(isset($_GET['type']) && ($_GET['type'] == 'Paid')) selected @endif>Paid</option>
                            <option value="Pending" @if(isset($_GET['type']) && ($_GET['type'] == 'Pending')) selected @endif>Pending</option>
                            <option value="Schedule" @if(isset($_GET['type']) && ($_GET['type'] == 'Schedule')) selected @endif>Schedule</option>
                            <option value="Refund" @if(isset($_GET['type']) && ($_GET['type'] == 'Refund')) selected @endif>Refund</option>
                            <option value="Cancelled" @if(isset($_GET['type']) && ($_GET['type'] == 'Cancelled')) selected @endif>Cancelled</option>
                          </select>
                        </div>

                        <!--end::Input group-->
                        <!--begin:Action-->
                        <div class="d-flex align-items-center mt-8">
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
                        <a href="{{route('donation.create')}}" class="btn btn-primary">
                        <i class="ki-outline ki-plus fs-2"></i>Add Donation</a>
                        @if (Route::currentRouteName() == 'donationtrash')
                        <a href="{{route('donation.index')}}" type="button" class="btn btn-primary ms-2">
                        <i class="ki-outline ki-file fs-2"></i>All Lists</a>
                        @else
                        <a href="{{route('donationtrash')}}" type="button" class="btn btn-primary ms-2">
                        <i class="ki-outline ki-trash fs-2"></i>Trash Folder</a>
                        @endif
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
                              <th>Devotee</th>
                              <th>Branch</th>
                              <th>Donation</th>
                              <th>Paid By</th>
                              <th>Status</th>
                              <th>Voucher No</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = ($lists->perPage() * ($lists->currentPage() - 1)) + 1;; @endphp
                          @foreach($lists as $list)
                          <tr>
                            <td>@php echo $i; @endphp</td>
                            <td><a href="{{ route('donation.show', $list->id)}}">
                              @if($list->getdevotee->firstname != NULL){{Crypt::decrypt($list->getdevotee->firstname)}}@endif
                              @if($list->getdevotee->middlename != NULL){{Crypt::decrypt($list->getdevotee->middlename)}}@endif
                              @if($list->getdevotee->surname != NULL){{Crypt::decrypt($list->getdevotee->surname)}}@endif
                            </a><br /><strong>Title:</strong> {{$list->title}}</td>
                            <td>{{$list->getbranch->title}}</td>
                            <td>Rs. {{$list->donation}}</td>
                            <td>{{$list->donationtype}}</td>
                            <td>
                                @if($list->status == 'Paid') <span class="badge badge-light-success">Paid</span> @endif
                                @if($list->status == 'Pending') <span class="badge badge-light-info">Pending</span> @endif
                                @if($list->status == 'Schedule') <span class="badge badge-light-primary">Schedule</span> @endif
                                @if($list->status == 'Refund') <span class="badge badge-light-danger">Refund</span> @endif
                                @if($list->status == 'Cancelled') <span class="badge badge-light-danger">Cancelled</span> @endif
                            </td>
                            <td>{{$list->voucher}}</td>
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <!--begin::Menu-->
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                                @if (Route::currentRouteName() == 'donationtrash')
                                @can('donation-delete')
                                <div class="menu-item px-3">
                                  <a href="{{ route('donationrestore', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-arrows-loop fs-2"></i> Restore</a>
                                </div>
                                <div class="menu-item px-3">
                                  <form action="{{ route('donation.destroy', $list->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i> Permanently Delete</button>
                                  </form>
                                </div>
                                @endcan
                                @else
                                @can('donation-edit')
                                <div class="menu-item px-3">
                                  <a href="{{ route('donation.edit', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-pencil fs-2"></i> Edit</a>
                                </div>
                                @endcan
                                @can('donation-delete')
                                <div class="menu-item px-3">
                                  <a href="{{ route('donationmovetotrash', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-trash fs-2"></i> Trash</a>
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
$today = date('Y-m-d'); echo $today;
$nextdate = date('Y-m-d', strtotime('+5 year'));
@endphp
<script src="{{asset('themes/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<script src="{{asset('themes/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
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
"use strict";

// Class definition
var KTGeneralFullCalendarBasicDemos = function () {
    // Private functions

    var exampleBasic = function () {
        var todayDate = moment().startOf('day');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

        var calendarEl = document.getElementById('kt_docs_fullcalendar_populated');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },

            height: 800,
            contentHeight: 780,
            aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

            nowIndicator: true,
            now: TODAY + 'T09:25:00', // just for demo

            views: {
                dayGridMonth: { buttonText: 'month' },
                timeGridWeek: { buttonText: 'week' },
                timeGridDay: { buttonText: 'day' }
            },

            initialView: 'dayGridMonth',
            initialDate: TODAY,

            editable: true,
            dayMaxEvents: true, // allow "more" link when too many events
            navLinks: true,
            events: [
                {
                    title: 'All Day Event',
                    start: YM + '-01',
                    description: 'Toto lorem ipsum dolor sit incid idunt ut',
                    className: "fc-event-danger fc-event-solid-warning"
                },
                {
                    title: 'Reporting',
                    start: YM + '-14T13:30:00',
                    description: 'Lorem ipsum dolor incid idunt ut labore',
                    end: YM + '-14',
                    className: "fc-event-success"
                },
                {
                    title: 'Company Trip',
                    start: YM + '-02',
                    description: 'Lorem ipsum dolor sit tempor incid',
                    end: YM + '-03',
                    className: "fc-event-primary"
                },
                {
                    title: 'ICT Expo 2017 - Product Release',
                    start: YM + '-03',
                    description: 'Lorem ipsum dolor sit tempor inci',
                    end: YM + '-05',
                    className: "fc-event-light fc-event-solid-primary"
                },
                {
                    title: 'Dinner',
                    start: YM + '-12',
                    description: 'Lorem ipsum dolor sit amet, conse ctetur',
                    end: YM + '-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: YM + '-09T16:00:00',
                    description: 'Lorem ipsum dolor sit ncididunt ut labore',
                    className: "fc-event-danger"
                },
                {
                    id: 1000,
                    title: 'Repeating Event',
                    description: 'Lorem ipsum dolor sit amet, labore',
                    start: YM + '-16T16:00:00'
                },
                {
                    title: 'Conference',
                    start: YESTERDAY,
                    end: TOMORROW,
                    description: 'Lorem ipsum dolor eius mod tempor labore',
                    className: "fc-event-primary"
                },
                {
                    title: 'Meeting',
                    start: TODAY + 'T10:30:00',
                    end: TODAY + 'T12:30:00',
                    description: 'Lorem ipsum dolor eiu idunt ut labore'
                },
                {
                    title: 'Lunch',
                    start: TODAY + 'T12:00:00',
                    className: "fc-event-info",
                    description: 'Lorem ipsum dolor sit amet, ut labore'
                },
                {
                    title: 'Meeting',
                    start: TODAY + 'T14:30:00',
                    className: "fc-event-warning",
                    description: 'Lorem ipsum conse ctetur adipi scing'
                },
                {
                    title: 'Happy Hour',
                    start: TODAY + 'T17:30:00',
                    className: "fc-event-info",
                    description: 'Lorem ipsum dolor sit amet, conse ctetur'
                },
                {
                    title: 'Dinner',
                    start: TOMORROW + 'T05:00:00',
                    className: "fc-event-solid-danger fc-event-light",
                    description: 'Lorem ipsum dolor sit ctetur adipi scing'
                },
                {
                    title: 'Birthday Party',
                    start: TOMORROW + 'T07:00:00',
                    className: "fc-event-primary",
                    description: 'Lorem ipsum dolor sit amet, scing'
                },
                {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: YM + '-28',
                    className: "fc-event-solid-info fc-event-light",
                    description: 'Lorem ipsum dolor sit amet, labore'
                }
            ],

            eventContent: function (info) {
                var element = $(info.el);

                if (info.event.extendedProps && info.event.extendedProps.description) {
                    if (element.hasClass('fc-day-grid-event')) {
                        element.data('content', info.event.extendedProps.description);
                        element.data('placement', 'top');
                        KTApp.initPopover(element);
                    } else if (element.hasClass('fc-time-grid-event')) {
                        element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    } else if (element.find('.fc-list-item-title').lenght !== 0) {
                        element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    }
                }
            }
        });

        calendar.render();
    }

    return {
        // Public Functions
        init: function () {
            exampleBasic();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTGeneralFullCalendarBasicDemos.init();
});
</script>
@endsection
