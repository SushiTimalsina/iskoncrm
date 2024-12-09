@extends('backend.layouts.master')

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
                                    Edit Course</h1>
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                    <li class="breadcrumb-item text-muted">
                                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                    </li>
                                    <li class="breadcrumb-item text-muted">
                                        <a href="{{ route('course-taken.index') }}"
                                            class="text-muted text-hover-primary">Taken Course Lists</a>
                                    </li>
                                </ul>
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Page title wrapper-->
                        <!--begin::Navbar-->
                        @include('backend.layouts.usermenu')
                        <!--end::Navbar-->
                    </div>
                    <!--end::Header wrapper-->
                </div>
                <!--end::Header container-->
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                @include('backend.layouts.leftmenu')





                <!--end::Sidebar-->
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card header-->

                                    <!--end::Card header-->
                                    <!--begin::Card body-->
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


                                        <form method="post" action="{{ route('course-taken.update', $edit->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                        <div class="form-group">
                                                            <label for="devotee">Devotee</label>
                                                            <select class="form-control" name="devotee" id="devotee"
                                                                required>
                                                                <option value="">Select One</option>
                                                                @if ($devotees->count() != null)
                                                                    @foreach ($devotees as $devotee)
                                                                        <option value="{{ $devotee->id }}"
                                                                            {{ $edit->devotee_id == $devotee->id ? 'selected' : '' }}
                                                                            data-kt-rich-content-email="<?php echo $devotee->email; ?>"
                                                                            data-kt-rich-content-mobile="<?php echo $devotee->mobile; ?>"
                                                                            data-kt-rich-content-initiation="@if (Helper::getinitiationrow($devotee->id)) {{ Helper::getinitiationrow($devotee->id)->initiation_name }} @endif">
                                                                            {{ $devotee->firstname }}
                                                                            {{ $devotee->middlename }}
                                                                            {{ $devotee->surname }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                        <div class="form-group">
                                                            <label for="branch">Branch</label>
                                                            <select class="form-select form-select-sm"
                                                                data-control="select2" name="branch" id="branch"
                                                                required>
                                                                <option value="">Select One</option>
                                                                @if ($branches->count() != null)
                                                                    @foreach ($branches as $branch)
                                                                        <option value="{{ $branch->id }}"
                                                                            {{ $edit->branch_id == $branch->id ? 'selected' : '' }}>
                                                                            {{ $branch->title }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                        <div class="form-group">
                                                            <label for="course">Course</label>
                                                            <select class="form-select form-select-sm"
                                                                data-control="select2" name="course" id="course"
                                                                required>
                                                                <option value="">Select One</option>
                                                                @if ($courses->count() != null)
                                                                    @foreach ($courses as $course)
                                                                        <option value="{{ $course->id }}"
                                                                            {{ $edit->course_id == $course->id ? 'selected' : '' }}>
                                                                            {{ $course->title }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-select form-select-sm"
                                                                data-control="select2" name="status" id="status"
                                                                required>
                                                                <option value="">Select One</option>
                                                                <option value="Completed"
                                                                    {{ $edit->status == 'Completed' ? 'selected' : '' }}>
                                                                    Completed</option>
                                                                <option value="Droped"
                                                                    {{ $edit->status == 'Droped' ? 'selected' : '' }}>
                                                                    Droped</option>
                                                                <option value="Ongoing"
                                                                    {{ $edit->status == 'Ongoing' ? 'selected' : '' }}>
                                                                    Ongoing</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                        <div class="form-group">
                                                            <label for="fromdate">From Date</label>
                                                            <input type="text" class="form-control" name="fromdate"
                                                                id="fromdate" value="{{ $edit->fromdate }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                        <div class="form-group">
                                                            <label for="todate">To Date</label>
                                                            <input type="text" class="form-control" name="todate"
                                                                id="todate" value="{{ $edit->todate }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                        <div class="form-group">
                                                            <label for="attendmarks">Attend Marks</label>
                                                            <input type="number" class="form-control" name="attendmarks"
                                                                id="attendmarks" value="{{ $edit->attendmarks }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                                        <button type="submit"
                                                            class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Content container-->
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
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
@endsection

@section('scripts')
    @php
        $today = date('Y-m-d');
        echo $today;
        $nextdate = date('Y-m-d', strtotime('+5 year'));
    @endphp
    <script type="text/javascript">
        $(document).ready(function() {
            $("#fromdate").flatpickr({
                dateFormat: "Y-m-d",
                disable: [{
                    from: '{{ $today }}',
                    to: '{{ $nextdate }}'
                }]
            });
            $("#todate").flatpickr({
                dateFormat: "Y-m-d",
                disable: [{
                    from: '{{ $today }}',
                    to: '{{ $nextdate }}'
                }]
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
