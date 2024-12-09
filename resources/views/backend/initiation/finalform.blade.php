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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">@if (isset($edit)) Edit @else Add @endif Initiation</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('initiation.index')}}" class="text-muted text-hover-primary">Initiation Management</a>
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
                  <!--begin::Card body-->
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


                      <form method="post" action="{{ route('initiation.store') }}" enctype="multipart/form-data">
                      @csrf
                      @if($initiation->initiation_type == 'Shelter')
                      <div class="mb-5"><strong>Devotee Name: <a href="{{ route('devotees.show', $devoteerow->id)}}">@if($devoteerow->firstname != NULL){{Crypt::decrypt($devoteerow->firstname)}}@endif
                      @if($devoteerow->middlename != NULL){{Crypt::decrypt($devoteerow->middlename)}}@endif
                      @if($devoteerow->surname != NULL){{Crypt::decrypt($devoteerow->surname)}}@endif</a></strong>, Request for <strong>{{$initiation->initiation_type}}</strong>, <strong>Branch: </strong>{{$initiation->getbranch->title}}</div>
                      <div class="row bg-light-danger alert p-5 mb-10">
                        <div class="col-md-4 col-sm-4 col-lg-4"><strong>Initiation Type: </strong>{{$initiation->initiation_type}}</div>
                      </div>
                      @endif
                      @if($initiation->initiation_type == 'Harinam Initiation')
                      <div class="mb-5"><strong>Devotee Name: {{$devoteerow->firstname}} {{$devoteerow->surname}} {{$devoteerow->surname}}</strong> <small>request for <strong>{{$initiation->initiation_type}}</strong></small></div>
                      <div class="row bg-light-danger alert p-5 mb-10">
                        @if($sheltered)
                          <div class="col-md-4 col-sm-4 col-lg-4"><strong>Shelter Date: </strong>{{$sheltered->initiation_date}} ({{ \Carbon\Carbon::parse($sheltered->initiation_date)->diffForhumans() }})</div>
                          <div class="col-md-4 col-sm-4 col-lg-4"><strong>Shelter Guru: </strong>{{$sheltered->getinitiationguru->name}}</div>
                          <div class="col-md-4 col-sm-4 col-lg-4"><strong>Shelter Witness: </strong>{{Helper::getdevoteebymentor($sheltered->witness)->firstname}} {{Helper::getdevoteebymentor($sheltered->witness)->middlename}} {{Helper::getdevoteebymentor($sheltered->witness)->surname}}</div>
                        @endif
                      </div>
                      @endif

                      @if($initiation->initiation_type == 'Brahman Initiation')
                      <div class="mb-5"><strong>Devotee Name: {{$devoteerow->firstname}} {{$devoteerow->surname}} {{$devoteerow->surname}}</strong> <small>request for <strong>{{$initiation->initiation_type}}</strong></small></div>
                      <div class="row bg-light-danger alert p-5 mb-10">
                        @if($sheltered)
                          <div class="col-md-4 col-sm-4 col-lg-4"><strong>Shelter Date: </strong>{{$sheltered->initiation_date}} ({{ \Carbon\Carbon::parse($sheltered->initiation_date)->diffForhumans() }})</div>
                          <div class="col-md-4 col-sm-4 col-lg-4"><strong>Shelter Guru: </strong>{{$sheltered->getinitiationguru->name}}</div>
                          <div class="col-md-4 col-sm-4 col-lg-4"><strong>Shelter Witness: </strong>{{Helper::getdevoteebymentor($sheltered->witness)->firstname}} {{Helper::getdevoteebymentor($sheltered->witness)->middlename}} {{Helper::getdevoteebymentor($sheltered->witness)->surname}}</div>
                        @endif
                        @if($harinaam)
                          <div class="col-md-4 col-sm-4 col-lg-4"><strong>Harinaam Date: </strong>{{$harinaam->initiation_date}} ({{ \Carbon\Carbon::parse($harinaam->initiation_date)->diffForhumans() }})</div>
                          <div class="col-md-4 col-sm-4 col-lg-4"><strong>Harinaam Guru: </strong>{{$harinaam->getinitiationguru->name}}</div>
                          <div class="col-md-4 col-sm-4 col-lg-4"><strong>Initiation Name: </strong>{{$harinaam->initiation_name}}</div>
                          <div class="col-md-4 col-sm-4 col-lg-4"><strong>Harinaam Witness: </strong>{{Helper::getdevoteebymentor($harinaam->witness)->firstname}} {{Helper::getdevoteebymentor($harinaam->witness)->middlename}} {{Helper::getdevoteebymentor($harinaam->witness)->surname}}</div>
                        @endif
                      </div>
                      @endif

                        <div class="row">
                          <div class="col-md-6 mb-4">
                             <div class="form-group">
                                <label for="initiation_name">Initiation Name</label>
                                <input type="text" class="form-control
                                @if($initiation->initiation_type == 'Shelter') form-control-solid @endif
                                @if($initiation->initiation_type == 'Brahman Initiation') form-control-solid @endif
                                " name="initiation_name" id="initiation_name"
                                @if($initiation->initiation_type == 'Shelter') readonly @endif
                                @if($initiation->initiation_type == 'Harinam Initiation') required @endif
                                 @if($initiation->initiation_type == 'Brahman Initiation') readonly value="{{$harinaam->initiation_name}}" @endif
                                />
                             </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                             <div class="form-group">
                                <label for="course">Initiation Guru <span class="required"></span></label>
                                <select class="form-select" data-control="select2" name="initiation_guru_id" id="initiation_guru_id" required>
                                   <option value="">Select One</option>
                                   @if ($initiativegurus->count() != null)
                                     @foreach ($initiativegurus as $initiativeguru)
                                      <option value="{{$initiativeguru->id}}"
                                        data-kt-rich-content-email="<?php if($initiativeguru->getdevotee->email_enc != NULL){ echo Crypt::decrypt($initiativeguru->getdevotee->email_enc); } ?>"
                                        data-kt-rich-content-mobile="<?php if($initiativeguru->getdevotee->mobile_enc != NULL){ echo Crypt::decrypt($initiativeguru->getdevotee->mobile_enc); } ?>"
                                        data-kt-rich-content-initiation="@if(Helper::getinitiationrow($initiativeguru->getdevotee->id)) {{Helper::getinitiationrow($initiativeguru->getdevotee->id)->initiation_name}} @endif"
                                        >
                                        <?php if($initiativeguru->getdevotee->firstname != NULL){ echo Crypt::decrypt($initiativeguru->getdevotee->firstname); } ?>
                                        <?php if($initiativeguru->getdevotee->middlename != NULL){ echo Crypt::decrypt($initiativeguru->getdevotee->middlename); } ?>
                                        <?php if($initiativeguru->getdevotee->surname != NULL){ echo Crypt::decrypt($initiativeguru->getdevotee->surname); } ?>
                                        </option>
                                     @endforeach
                                   @endif
                                </select>
                             </div>
                          </div>
                          <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                             <div class="form-group">
                                <label for="fromdate">Date <span class="required"></span></label>
                                <input type="text" class="form-control" name="date" id="date" required />
                             </div>
                          </div>
                          <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                            <div class="form-group">
                                <label for="witness">Witness <span class="required"></span></label>
                                <select class="form-select" data-control="select2" name="witness" id="witness">
                                  <option value="">Select One</option>
                                  @if($mentors->count() != NULL)
                                    @foreach($mentors as $mentor)
                                      <option value="{{$mentor->id}}"
                                        data-kt-rich-content-email="<?php if($mentor->getdevotee->email_enc != NULL){ echo Crypt::decrypt($mentor->getdevotee->email_enc); } ?>"
                                        data-kt-rich-content-mobile="<?php if($mentor->getdevotee->mobile_enc != NULL){ echo Crypt::decrypt($mentor->getdevotee->mobile_enc); } ?>"
                                        data-kt-rich-content-initiation="@if(Helper::getinitiationrow($mentor->getdevotee->id)) {{Helper::getinitiationrow($mentor->getdevotee->id)->initiation_name}} @endif"
                                        >
                                        <?php if($mentor->getdevotee->firstname != NULL){ echo Crypt::decrypt($mentor->getdevotee->firstname); } ?>
                                        <?php if($mentor->getdevotee->middlename != NULL){ echo Crypt::decrypt($mentor->getdevotee->middlename); } ?>
                                        <?php if($mentor->getdevotee->surname != NULL){ echo Crypt::decrypt($mentor->getdevotee->surname); } ?>
                                        </option>
                                    @endforeach
                                  @endif
                                </select>
                            </div>
                          </div>
                          <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                             <div class="form-group">
                                <label for="remarks">Remarks @if (isset($edit)) <span class="required"></span> @endif</label>
                                <input type="text" class="form-control" name="remarks" id="remarks" />
                             </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                            <div class="form-group">
                               <label for="files">Files Upload <span class="required"></span></label>
                               <input type="file" class="form-control" name="files[]" id="files" multiple required />
                            </div>
                          </div>
                          @if($initiation->initiation_type == 'Shelter')
                          <div class="col-md-12 col-sm-12 col-lg-12 mb-4">
                             <div class="form-group">
                                <input type="checkbox" class="form-check-input" name="discipleconfirm" id="discipleconfirm" value="1"  required />
                                <label for="discipleconfirm">Confirm disciple course  completion <span class="required"></span></label>
                             </div>
                             <div class="mt-5">
                               <p>NOTE : Attachment is mandatory for new devotees.<br />For the devotees with no attachhments, reason should be clearly mentioned on the Remarks</p>
                             </div>
                          </div>
                          @endif


                          <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                              <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">@if (isset($edit)) Update @else Create @endif</button>
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
$today = date('Y-m-d'); echo $today;
$nextdate = date('Y-m-d', strtotime('+5 year'));
@endphp
<script src="{{asset('themes/assets/js/custom/apps/file-manager/list.js')}}"></script>
<script src="{{asset('themes/assets/js/scripts.bundle.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $("#date").flatpickr({ dateFormat: "Y-m-d", disable: [{from:'{{$today}}', to:'{{$nextdate}}'}] });
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

<script type="text/javascript">
  $(document).ready(function(){
      $('#initiation_type').on('change', function() {
        if ( this.value == 'Shelter')
        {
          $("#initiation_name").prop("readonly", true);
          $('#initiation_name').addClass('form-control-solid');
          $('#initiation_name').val(null);
        }
        if ( this.value == 'Harinam Initiation')
        {
          $("#initiation_name").prop("readonly", false);
          $('#initiation_name').removeClass('form-control-solid');
        }
        if ( this.value == 'Brahman Initiation')
        {
          $("#initiation_name").prop("readonly", false);
          $('#initiation_name').removeClass('form-control-solid');
        }
      });
  });
</script>
@endsection
