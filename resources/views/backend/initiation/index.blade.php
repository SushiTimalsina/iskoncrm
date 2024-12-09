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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Initiation Management</h1>
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
                  <form method="get" action="{{route('initiationsearch')}}" enctype="multipart/form-data">
                    <!--begin::Card-->
                    <div class="card mb-7">

                      <!--begin::Card body-->
                      <div class="card-body">
                        <!--begin::Compact form-->
                        <div class="d-flex align-items-center">
                          <!--begin::Input group-->
                          <div class="position-relative w-md-600px me-md-2">
                            <i class="ki-outline ki-magnifier fs-3 text-gray-500 position-absolute top-50 translate-middle ms-6" style="z-index:9999;"></i>
                            <input class="form-control ps-10" value="" placeholder="Search devotee by name or email or mobile or initiated name..." id="search" name="search" @if(isset($_GET['search'])) value="{{$_GET['search']}}" @endif  autocomplete="off"  />
                          </div>
                          <div class="d-flex align-items-center w-md-400px me-md-2">
                            <select class="form-select" data-control="select2" name="initiationguru" id="initiationguru">
                               <option value="">Select Guru</option>
                               @if ($initiativegurus->count() != null)
                                 @foreach ($initiativegurus as $initiativeguru)
                                  <option value="{{ $initiativeguru->id }}" @if(isset($_GET['initiationguru']) && ($_GET['initiationguru'] == $initiativeguru->id)) selected @endif> {{ $initiativeguru->name }} </option>
                                 @endforeach
                               @endif
                            </select>
                          </div>
                          <!--end::Input group-->
                          <!--begin:Action-->
                          <div class="d-flex align-items-center me-2">
                            <button type="submit" class="btn btn-primary me-5">Search</button>  <a href="{{route('initiation.index')}}" class="btn btn-primary me-5">Reset</a>
                          </div>
                          <div id="search_list"></div>
                        </div>
                        </div>
                      </div>
                  </form>


                <div class="card">
                  <div class="card-header border-0 pt-6">
                    <div class="card-toolbar">
                      <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{route('initiation.create')}}" class="btn btn-primary">
                        <i class="ki-outline ki-plus fs-2"></i>Add Initiation</a>
                        @if (Route::currentRouteName() == 'initiationtrash')
                        <a href="{{route('initiation.index')}}" type="button" class="btn btn-primary ms-2">
                        <i class="ki-outline ki-file fs-2"></i>All Lists</a>
                        @else
                        <a href="{{route('initiationtrash')}}" type="button" class="btn btn-primary ms-2">
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
                              <th>Guru</th>
                              <th>Initiation Name</th>
                              <th>Type</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = ($lists->perPage() * ($lists->currentPage() - 1)) + 1;; @endphp
                          @foreach($lists as $list)
                          <tr>
                            <td>@php echo $i; @endphp</td>
                            <td><a href="{{ route('devotees.show', $list->getdevotee->id)}}">
                              @if($list->getdevotee->firstname != NULL){{Crypt::decrypt($list->getdevotee->firstname)}}@endif
                              @if($list->getdevotee->middlename != NULL){{Crypt::decrypt($list->getdevotee->middlename)}}@endif
                              @if($list->getdevotee->surname != NULL){{Crypt::decrypt($list->getdevotee->surname)}}@endif
                            </a></td>
                            <td>{{Helper::getbranchbydevoteeid($list->getdevotee->branch_id)->title}}</td>
                            <td><a href="{{ route('devotees.show', $list->getinitiationguru->name)}}">
                              @if(Helper::getdevoteebyinitiationguruid($list->initiation_guru_id)->firstname != NULL){{Crypt::decrypt(Helper::getdevoteebyinitiationguruid($list->initiation_guru_id)->firstname)}}@endif
                              @if(Helper::getdevoteebyinitiationguruid($list->initiation_guru_id)->middlename != NULL){{Crypt::decrypt(Helper::getdevoteebyinitiationguruid($list->initiation_guru_id)->middlename)}}@endif
                              @if(Helper::getdevoteebyinitiationguruid($list->initiation_guru_id)->surname != NULL){{Crypt::decrypt(Helper::getdevoteebyinitiationguruid($list->initiation_guru_id)->surname)}}@endif
                            </a></td>
                            <td>{{$list->initiation_name}}</td>
                            <td><a href="{{route('initiation.show', $list->id)}}">{{$list->initiation_type}}</a></td>
                            <td class="text-end">
                              <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                              <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                              <!--begin::Menu-->
                              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                                @if (Route::currentRouteName() == 'initiationtrash')
                                @can('initiative-delete')
                                <div class="menu-item px-3">
                                  <a href="{{ route('initiationrestore', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-arrows-loop fs-2"></i> Restore</a>
                                </div>
                                <div class="menu-item px-3">
                                  <form action="{{ route('initiation.destroy', $list->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i> Permanently Delete</button>
                                  </form>
                                </div>
                                @endcan
                                @else
                                @can('initiative-edit')
                                <div class="menu-item px-3">
                                  <a href="{{ route('initiation.edit', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-pencil fs-2"></i> Edit</a>
                                </div>
                                @endcan
                                @can('initiative-delete')
                                <div class="menu-item px-3">
                                  <a href="{{ route('initiationmovetotrash', $list->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-trash fs-2"></i> Trash</a>
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
$today = date('Y-m-d');
$nextdate = date('Y-m-d', strtotime('+5 year'));
@endphp
<script src="{{asset('themes/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
  $("#datefrom").flatpickr({ dateFormat: "Y-m-d", disable: [{from:'{{$today}}', to:'{{$nextdate}}'}] });
  $("#dateto").flatpickr({ dateFormat: "Y-m-d", disable: [{from:'{{$today}}', to:'{{$nextdate}}'}] });
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
    placeholder: "Select an option",
    templateSelection: optionFormat,
    templateResult: optionFormat
});
</script>


<script>
var inputElm = document.querySelector('#search');

const usersList = [
  <?php if($devotees->count() != NULL){
    foreach($devotees as $devotee){
      if($devotee->firstname != NULL){ $devoteefirstname = Crypt::decrypt($devotee->firstname);}else{ $devoteefirstname = NULL; }
      if($devotee->middlename != NULL){ $devoteemiddlename = Crypt::decrypt($devotee->middlename);}else{ $devoteemiddlename = NULL; }
      if($devotee->email_enc != NULL){ $devoteeemail = Crypt::decrypt($devotee->email_enc);}else{ $devoteeemail = NULL; }
      if($devotee->mobile_enc != NULL){ $devoteemobile = Crypt::decrypt($devotee->mobile_enc);}else{ $devoteemobile = NULL; }
      if($devotee->surname != NULL){ $devoteesurname = Crypt::decrypt($devotee->surname);}else{ $devoteesurname = NULL; }
    ?>


    { value: <?php echo "'".$devotee->id."'"; ?>, name: <?php echo "'".$devoteefirstname.' '.$devoteemiddlename.' '.$devoteesurname."'"; ?> <?php if(Helper::getinitiationrow($devotee->id)) { ?>, initiation:<?php echo "'".Helper::getinitiationrow($devotee->id)->initiation_name."'"; }else{ ?>, initiation: 'Not Initiated'<?php } ?>, email: <?php echo "'". $devoteeemail."'"; ?>, mobile:<?php echo  "'".$devoteemobile."'"; ?>},
  <?php }} ?>
];

function tagTemplate(tagData) {
  return `
    <tag title="${(tagData.title || tagData.email || tagData.mobile || tagData.initiation)}"
            contenteditable='false'
            spellcheck='false'
            tabIndex="-1"
            class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
            ${this.getAttributes(tagData)}>
        <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
        <div class="d-flex align-items-center">
            <span class='tagify__tag-text'>${tagData.name}</span>
        </div>
    </tag>
    `
}

function suggestionItemTemplate(tagData) {
    return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item d-flex align-items-center ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            <div class="d-flex flex-column devoteetagdata">
                <strong class="fs-4 fw-bold lh-1">${tagData.name} ( ${tagData.initiation} )</strong>
                <span class="text-muted fs-5">${tagData.email} ( ${tagData.mobile} )</span>
            </div>
        </div>
    `
}

// initialize Tagify on the above input node reference
var tagify = new Tagify(inputElm, {
    tagTextProp: 'name',
    enforceWhitelist: true,
    skipInvalid: true, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: false,
        enabled: 0,
        searchKeys: ['name', 'email', 'mobile', 'initiation']
    },
    templates: {
        tag: tagTemplate,
        dropdownItem: suggestionItemTemplate
    },
    whitelist: usersList
})

tagify.on('dropdown:show dropdown:updated', onDropdownShow)
</script>
@endsection
