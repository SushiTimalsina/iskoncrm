@extends('backend.layouts.master')

@section('styles')
    <link href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" rel="stylesheet"
        type="text/css" />
@endsection

@section('content')

    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header d-flex" data-kt-sticky="true"
                data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky"
                data-kt-sticky-offset="{default: false, lg: '300px'}">
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
                            <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
                                data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_page_title_wrapper'}"
                                class="page-title d-flex flex-column justify-content-center me-3 mb-6 mb-lg-0">
                                <!--begin::Title-->
                                <h1
                                    class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">
                                    Facilitator Management</h1>
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                    <li class="breadcrumb-item text-muted">
                                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                    </li>
                                    <li class="breadcrumb-item text-muted">
                                        <a href="{{ route('course-facilitator.index') }}"
                                            class="text-muted text-hover-primary">Facilitator Management</a>
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
                                <form method="get" action="{{ route('coursefacilitatorsearch') }}"
                                    enctype="multipart/form-data">
                                    <div class="card mb-7">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-md-3 col-md-3 col-lg-3">
                                                    <label class="fs-6 form-label fw-bold text-gray-900"
                                                        for="devotee">Devotee</label>
                                                    <select class="form-control" name="devotee" id="devotee">
                                                        <option value="">Select One</option>
                                                        @if ($devotees->count() != null)
                                                            @foreach ($devotees as $devotee)
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
                                                    <label class="fs-6 form-label fw-bold text-gray-900"
                                                        for="course">Course</label>
                                                    <select class="form-select" name="course" data-control="select2">
                                                        <option value="">Select Course</option>
                                                        @if ($courses->count() != null)
                                                            @foreach ($courses as $course)
                                                                <option value="{{ $course->id }}" @if (isset($_GET['course']) && $_GET['course'] == $course->id) selected @endif>
                                                                    {{ $course->title }}</option>
                                                            @endforeach
                                                        @endif
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
                                                <a href="{{ route('course-facilitator.create') }}" class="btn btn-primary">
                                                    <i class="ki-outline ki-plus fs-2"></i>Add Course Facilitator</a>
                                            </div>
                                            @if (Route::currentRouteName() == 'coursefacilitatortrash')
                                            <a href="{{route('course-facilitator.index')}}" type="button" class="btn btn-primary ms-2">
                                            <i class="ki-outline ki-file fs-2"></i>All Lists</a>
                                            @else
                                            <a href="{{route('coursefacilitatortrash')}}" type="button" class="btn btn-primary ms-2">
                                            <i class="ki-outline ki-trash fs-2"></i>Trash Folder</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body py-4">
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


                                        @if ($lists->count() != null)
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>Name</th>
                                                            <th>Branch</th>
                                                            <th>Course</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @php $i = ($lists->perPage() * ($lists->currentPage() - 1)) + 1;; @endphp
                                                        @foreach ($lists as $list)
                                                            <tr>
                                                                <td>{{$i}}</td>
                                                                <td><a href="{{ route('devotees.show', $list->getdevotee->id) }}">
                                                                  @if($list->devotee_id != NULL){{Crypt::decrypt($list->getdevotee->firstname)}}@endif
                                                                  @if($list->devotee_id != NULL){{Crypt::decrypt($list->getdevotee->middlename)}}@endif
                                                                  @if($list->devotee_id != NULL){{Crypt::decrypt($list->getdevotee->surname)}}@endif
                                                                </a></td>
                                                                <td>{{$list->getbranch->title}}</td>
                                                                <td>
                                                                  <ul>
                                                                    @foreach($courses->whereIn('id', $list->course_id) as $course)
                                                                      <li>{{ $course->title }}</li>
                                                                    @endforeach
                                                                  </ul>
                                                                </td>
                                                                <td>
                                                                    @if ($list->status == 'Active')
                                                                        <span
                                                                            class="badge badge-light-success">Active</span>
                                                                    @endif
                                                                    @if ($list->status == 'Draft')
                                                                        <span class="badge badge-light-info">Draft</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="#"
                                                                        class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                                                        data-kt-menu-trigger="click"
                                                                        data-kt-menu-placement="bottom-end">Actions
                                                                        <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                                    <!--begin::Menu-->
                                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                                                        data-kt-menu="true">
                                                                          @if (Route::currentRouteName() == 'coursefacilitatortrash')
                                                                          @can('course-delete')
                                                                          <div class="menu-item px-3">
                                                                            <a href="{{ route('coursefacilitatorrestore', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-arrows-loop fs-2"></i> Restore</a>
                                                                          </div>
                                                                          <div class="menu-item px-3">
                                                                            <form action="{{ route('course-facilitator.destroy', $list->id)}}" method="post">
                                                                              @csrf
                                                                              @method('DELETE')
                                                                              <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i> Permanently Delete</button>
                                                                            </form>
                                                                          </div>
                                                                          @endcan
                                                                          @else
                                                                          @can('course-edit')
                                                                          <div class="menu-item px-3">
                                                                            <a href="{{ route('course-facilitator.edit', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-pencil fs-2"></i> Edit</a>
                                                                          </div>
                                                                          @endcan
                                                                          @can('course-delete')
                                                                          <div class="menu-item px-3">
                                                                            <a href="{{ route('coursefacilitatormovetotrash', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-trash fs-2"></i> Trash</a>
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
                                            <div class="demo-spacing-0">
                                                <div class="alert alert-primary" role="alert">
                                                    <div class="alert-body">No listing found!</div>
                                                </div>
                                            </div>
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
            template += '<span class="text-muted fs-5">' + item.element.getAttribute(
                'data-kt-rich-content-initiation') + '</span>';
            template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-kt-rich-content-email') +
                '</span>';
            template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-kt-rich-content-mobile') +
                '</span>';
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
