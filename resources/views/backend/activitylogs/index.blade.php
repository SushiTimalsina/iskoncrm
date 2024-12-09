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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Activity Management</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('activity-logs.index')}}" class="text-muted text-hover-primary">Activity Management</a>
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
                    <form method="get" action="{{route('activitysearch')}}" enctype="multipart/form-data">
                      <!--begin::Card-->
                      <div class="card mb-7">

                        <!--begin::Card body-->
                        <div class="card-body">
                          <!--begin::Compact form-->
                          <div class="row align-items-center">
                            <div class="col-md-3 col-md-3 col-lg-3">
                              <label class="fs-6 form-label fw-bold text-gray-900" for="daterange">Select Date Range</label>
                              <input type="text" class="form-control" name="daterange" id="daterange" @if(isset($_GET['daterange'])) value="{{$_GET['daterange']}}" @endif autocomplete="off" />
                            </div>
                            <div class="col-md-3 col-md-3 col-lg-3">
                              <label class="fs-6 form-label fw-bold text-gray-900" for="page">Select Page</label>
                              <select class="form-control" data-control="select2" name="page" id="page">
                                <option value="">Select One</option>
                                <option value="Devotee" @if(isset($_GET['page']) && ($_GET['page'] == 'Devotee')) selected @endif>Devotee</option>
                                <option value="Branch" @if(isset($_GET['page']) && ($_GET['page'] == 'Branch')) selected @endif>Branch</option>
                                <option value="Department" @if(isset($_GET['page']) && ($_GET['page'] == 'Department')) selected @endif>Department</option>
                                <option value="Course" @if(isset($_GET['page']) && ($_GET['page'] == 'Course')) selected @endif>Course</option>
                                <option value="Course Attend" @if(isset($_GET['page']) && ($_GET['page'] == 'Course Attend')) selected @endif>Course Attend</option>
                                <option value="Sewa" @if(isset($_GET['page']) && ($_GET['page'] == 'Sewa')) selected @endif>Sewa</option>
                                <option value="Sewa Attend" @if(isset($_GET['page']) && ($_GET['page'] == 'Sewa Attend')) selected @endif>Sewa Attend</option>
                                <option value="Donation" @if(isset($_GET['page']) && ($_GET['page'] == 'Donation')) selected @endif>Donation</option>
                                <option value="Initiation" @if(isset($_GET['page']) && ($_GET['page'] == 'Initiation')) selected @endif>Initiation</option>
                                <option value="Mentor" @if(isset($_GET['page']) && ($_GET['page'] == 'Mentor')) selected @endif>Mentor</option>
                                <option value="Yatra" @if(isset($_GET['page']) && ($_GET['page'] == 'Yatra')) selected @endif>Yatra</option>
                                <option value="Occupation" @if(isset($_GET['page']) && ($_GET['page'] == 'Occupation')) selected @endif>Occupation</option>
                                <option value="Skills" @if(isset($_GET['page']) && ($_GET['page'] == 'Skills')) selected @endif>Skills</option>
                                <option value="User" @if(isset($_GET['page']) && ($_GET['page'] == 'User')) selected @endif>User</option>
                                <option value="Roles" @if(isset($_GET['page']) && ($_GET['page'] == 'Roles')) selected @endif>Roles</option>
                              </select>
                            </div>
                            <div class="col-md-3 col-md-3 col-lg-3">
                              <label class="fs-6 form-label fw-bold text-gray-900" for="devotee">Select Devotee</label>
                              <select class="form-control" data-control="select2" name="devotee" id="devotee">
                                <option value="">Select One</option>
                                @if($users)
                                  @foreach($users as $user)
                                    <option value="{{$user->id}}" @if(isset($_GET['devotee']) && ($_GET['devotee'] == $user->id)) selected @endif>@if($user->name != NULL){{Crypt::decrypt($user->name)}}@endif</option>
                                  @endforeach
                                @endif
                              </select>
                            </div>
                            <div class="col-md-2 col-md-2 col-lg-2">
                              <input type="hidden" name="search" value="true" />
                              <button type="submit" class="btn btn-primary me-5 mt-7">Search</button>
                            </div>
                          </div>
                          </div>
                        </div>
                    </form>

                  <div class="card">
                    @can('user-delete')
                    <div class="card-header border-0 pt-6">
                      <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                          <a href="{{ route('activity-logs-delete') }}" type="button" class="btn btn-primary"><i class="ki-outline bi-trash"></i> Delete All</a>
                          <button class="btn btn-primary ms-5" id="deleteselected" onclick="return confirm('Are you sure to delete this data?')"><i class="ki-outline bi-trash"></i> Delete Selected</button>
                        </div>
                      </div>
                    </div>
                    @endcan
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


                    @if($activities->count() != NULL)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="activitylogs">
                          <thead>
                            <tr>
                              <th class="w-20px pe-2">
  															<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
  																<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#activitylogs .form-check-input" id="master" />
  															</div>
  														</th>
              							  <th>SN</th>
                              <th>Page</th>
              							  <th>Log</th>
              							  <th>User</th>
                              <th>Created</th>
              								<th>Action</th>
              							</tr>
                          </thead>
                          <tbody>
            							<?php $i = ($activities->perPage() * ($activities->currentPage() - 1)) + 1;; ?>
            							@foreach($activities as $activity)
            							<tr>
                            <td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input itemCheckbox" name="ids" value="{{$activity->id}}" type="checkbox" />
															</div>
														</td>
            								<td>{{ $i }}</td>
                            <td>{{$activity->log_name}}</td>
            								<td>{{$activity->description}}</td>
            								<td>
                              @foreach($users as $user)
                                @if($activity->causer_id == $user->id)
                                  @if($user->name != NULL){{Crypt::decrypt($user->name)}}@endif
                                @endif
                              @endforeach
            								</td>
                            <td>{{$activity->created_at}}</td>
            								<td class="product-action">
            									<form action="{{ route('activity-logs.destroy', $activity->id)}}" method="post">
            									  @csrf
            									  @method('DELETE')
            									  <button type="submit" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" onclick="return confirm('Are you sure to delete this data?')"><i class="ki-outline ki-trash fs-3"></i> Delete</button>
            									</form>
            								</td>
            							</tr>
            							<?php $i++; ?>
            							@endforeach
                          </tbody>
                      </table>
                    </div>
                    <div class="mt-2">{!! $activities->links() !!}</div>
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
$(function(e){
  $('#deleteselected').click(function(e){
    e.preventDefault();
    var all_ids = [];
    $('input:checkbox[name=ids]:checked').each(function(){
      all_ids.push($(this).val());
    });

    $.ajax({
      url:"/admin/activity-logs-destroy-selected",
      type:"POST",
      data:{
        ids:all_ids,
        _token:'{{ csrf_token() }}'
      },

      success:function(response){
        window.location.reload();
      },

      error: function(error) {
        alert('Error Occured! Make sure you have selected at least one row.');
        console.log(error);
      }
    });
  });
});




document.getElementById('deleteSelectedItems').addEventListener('click', function() {
    var selectedItems = [];
    var checkboxes = document.querySelectorAll('.itemCheckbox:checked');

    checkboxes.forEach(function(checkbox) {
        selectedItems.push(checkbox.value);
    });

    if (selectedItems.length > 0) {
        // Confirmation dialog
        if (confirm("Are you sure you want to delete the selected items?")) {
            // If user confirms, make the AJAX request
            $.ajax({
                url: '/admin/activity-logs-destroy-selected',
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}", // Laravel CSRF token
                    "ids": selectedItems
                },
                success: function(response) {
                    alert('Items deleted successfully!');
                    // Optional: Refresh the page or remove the deleted rows from the DOM
                    checkboxes.forEach(function(checkbox) {
                        checkbox.closest('tr').remove();
                    });
                },
                error: function(xhr) {
                    alert('Something went wrong. Please try again.');
                }
            });
        } else {
            alert("Action canceled.");
        }
    } else {
        alert("Please select at least one item to delete.");
    }
});

</script>
@endsection
