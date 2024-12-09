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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Guest Take Care Details</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('guest-take-care.index')}}" class="text-muted text-hover-primary">Guest Take Care</a>
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
                            <th>Branch</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                          <tr>
                            <td>
                              <a href="{{ route('devotees.show', $show->devotee_id)}}">
                                  @if($show->devotee_id != NULL){{Crypt::decrypt($show->getdevotee->firstname)}}@endif
                                  @if($show->devotee_id != NULL){{Crypt::decrypt($show->getdevotee->middlename)}}@endif
                                  @if($show->devotee_id != NULL){{Crypt::decrypt($show->getdevotee->surname)}}@endif
                                </a>
                            </td>
                            <td>{{$show->getbranch->title}}</td>
                            <td>
                              @if($show->status == 'Active') <span class="badge badge-light-success">Active</span> @endif
                              @if($show->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
                              @if($show->status == 'Trash') <span class="badge badge-light-danger">Trash</span> @endif
                            </td>
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <!--begin::Menu-->
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                @if (Route::currentRouteName() == 'guesttakecaretrash')
                                @can('guest-take-care-delete')
                                <div class="menu-item px-3">
                                  <a href="{{ route('guesttakecarerestore', $show->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-arrows-loop fs-2"></i> Restore</a>
                                </div>
                                <div class="menu-item px-3">
                                  <form action="{{ route('guest-take-care.destroy', $show->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i> Permanently Delete</button>
                                  </form>
                                </div>
                                @endcan
                                @else
                                  @can('guest-take-care-edit')
                                  <div class="menu-item px-3">
                                    <a href="{{route('guest-take-care.edit', $show->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-pencil fs-2"></i> Edit</a>
                                  </div>
                                  @endcan
                                  @can('guest-take-care-delete')
                                  <div class="menu-item px-3">
                                    <a href="{{route('guesttakecaremovetotrash', $show->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-trash fs-2"></i> Trash</a>
                                  </div>
                                  @endcan
                                @endif
                              </div>
                            </td>
                          </tr>
                        </table>
                      </div>

                      @can('mentor-create')<button id="showadddevotee" class="btn btn-primary d-block mb-5">Add Devotee</button>@endcan

                      <div id="showadddevoteewrap" class="mt-5 w-50 mb-5" style="display:none;">
                        <form action="{{ route('mentor.destroy', $show->id)}}" method="post">
                          <select class="form-control" name="devotee" id="devotee" required>
                            <option value="">Select Devotee</option>
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
                          <button type="submit" class="btn btn-primary d-block w-20 mt-3">Add</button>
                        </form>
                      </div>


                    @if($lists->count() != NULL)
                    <h3 class="mb-3">List of Devotees</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                              <th>SN</th>
                              <th>Devotee</th>
                              <th>Branch</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php $i = 1; @endphp
                          @foreach($lists as $list)
                          <tr>
                            <td>@php echo $i; @endphp</td>
                            <td><a href="{{ route('devotees.show', $list->id)}}">
                              @if($list->firstname != NULL){{Crypt::decrypt($list->firstname)}}@endif
                              @if($list->middlename != NULL){{Crypt::decrypt($list->middlename)}}@endif
                              @if($list->surname != NULL){{Crypt::decrypt($list->surname)}}@endif</a></td>
                            <td>{{$list->getbranch->title}}</td>
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <!--begin::Menu-->
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                @can('devotee-delete')
                                <div class="menu-item px-3">
                                  <form action="{{ route('mentorupdate', $list->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete">Trash</button>
                                  </form>
                                </div>
                                @endcan
                              </div>
                            </td>
                          </tr>
                          @php $i++; @endphp
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    @else
                    <div class="demo-spacing-0"><div class="alert alert-primary" role="alert"><div class="alert-body">No devotee listing found!</div></div></div>
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
<script>
  $(document).ready(function () {
      $("#showadddevotee").click(function () {
          $("#showadddevoteewrap").toggle();
          $(this).text(function (i, text) {
              return text === "Add Devotee" ? "Hide" : "Add Devotee";
          });
      });
  });
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
    placeholder: "Add Devotee",
    templateSelection: optionFormat,
    templateResult: optionFormat
});
</script>
@endsection
