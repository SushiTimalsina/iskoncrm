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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Yatra Season Details</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('yatra-season.index')}}" class="text-muted text-hover-primary">Yatra Season Management</a>
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
                      @can('yatra-edit')
                      <div class="d-flex ms-3 justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{ route('yatra-season.edit', $show->id)}}" class="btn btn-primary">
                        <i class="ki-outline ki-pencil fs-2"></i>Edit</a>
                      </div>
                      @endcan
                      @can('yatra-delete')
                      <div class="d-flex ms-3 justify-content-end" data-kt-user-table-toolbar="base">
                        <form action="{{ route('yatra-season.destroy', $show->id)}}" method="post">
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

                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                              <th>Yatra</th>
                              <th>Season Name</th>
                              <th>Price</th>
                              <th>Price Details</th>
                              <th>Route</th>
                              <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{$show->getyatra->title}}</td>
                            <td>{{$show->name}}</td>
                            <td>Rs. {{$show->price}}</td>
                            <td>{{$show->pricedetails}}</td>
                            <td>{{$show->route}}</td>
                            <td>
                              @if($show->status == 'Completed') <span class="badge badge-light-success">Completed</span> @endif
                              @if($show->status == 'Active') <span class="badge badge-light-success">Active</span> @endif
                              @if($show->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
                              @if($show->status == 'Trash') <span class="badge badge-light-danger">Trash</span> @endif
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="card mt-5">
                  <div class="card-header border-0 pt-6">
                    <h3 class="pt-5">Devotees</h3>
                    <div class="card-toolbar">
                    @if($show->status != 'Completed')
                      @can('yatra-create')
                      <div class="d-flex ms-2" data-kt-user-table-toolbar="base">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_devotee">
                        <i class="ki-outline ki-user fs-2"></i>Add Devotee</button>
                      </div>
                      <div class="modal fade" id="add_devotee" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_user_header">
                              <h2 class="fw-bold">Add Devotee</h2>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                              </div>
                            </div>
                            <div class="modal-body">
                              <form method="post" action="{{ route('yatra.store') }}" enctype="multipart/form-data">
                                @csrf
                                  <div class="row mb-2">
                                    <div class="col-md-12 col-sm-12 col-lg-12 mb-4">
                                        <div class="form-group">
                                            <label for="devotee">Devotee</label>
                                            <select class="form-control" name="devotee" id="devotee" required>
                                              <option value="">Select One</option>
                                              @if($devotees->count() != NULL)
                                                @foreach($devotees as $devotee)
                                                  <option value="{{$devotee->id}}" data-kt-rich-content-email="<?php echo $devotee->email; ?>" data-kt-rich-content-mobile="<?php echo $devotee->mobile; ?>">{{$devotee->firstname}} {{$devotee->middlename}} {{$devotee->surname}}</option>
                                                @endforeach
                                              @endif
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-md-12 col-sm-12 col-lg-12 mb-4">
                                          <div class="form-group">
                                              <label for="branch">Branch</label>
                                              <select class="form-select form-select-sm" data-control="select2" name="branch" id="branch" required>
                                                <option value="">Select One</option>
                                                @if($branches->count() != NULL)
                                                  @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}" {{ $branch->title == 'Budhanilkantha' ? 'selected' : '' }}>{{$branch->title}}</option>
                                                  @endforeach
                                                @endif
                                              </select>
                                          </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-lg-12 mb-4">
                                          <div class="form-group">
                                              <label for="room">Room</label>
                                              <select class="form-select" data-control="select2" name="room" id="room">
                                                <option value="">Select One</option>
                                                @if($rooms->count() != NULL)
                                                  @foreach($rooms as $room)
                                                    <option value="{{$room->id}}">{{$room->title}}</option>
                                                  @endforeach
                                                @endif
                                              </select>
                                          </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-lg-12 mb-4">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-select form-select-sm" data-control="select2" name="status" id="status" required>
                                                  <option value="">Select One</option>
                                                  <option value="Confirmed">Confirmed</option>
                                                  <option value="Partial Payment">Partial Payment</option>
                                                  <option value="Hold">Hold</option>
                                                  <option value="Cancelled">Cancelled</option>
                                                </select>
                                            </div>
                                          </div>
                                      <div class="col-md-12 col-sm-12 col-lg-12 mb-4">
                                          <div class="form-group">
                                              <label for="contact">Contact</label>
                                              <input type="number" class="form-control" name="contact" id="contact">
                                          </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-lg-12 mb-4">
                                          <div class="form-group">
                                             <input type="checkbox" class="form-check-input" name="othertravel" id="othertravel" value="1" />
                                             <label for="othertravel">Other Travel with ISKCON <span class="required"></span></label>
                                          </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-lg-12 mb-4">
                                          <div class="form-group">
                                             <input type="checkbox" class="form-check-input" name="tnc" id="tnc" value="1"  required />
                                             <label for="tnc">Terms & Conditions <span class="required"></span></label>
                                          </div>
                                        </div>
                                      </div>
                                    <div class="row mb-2">
                                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                        <input type="hidden" value="{{$show->yatra_id}}" name="yatra" id="yatra" />
                                        <input type="hidden" value="{{$show->id}}" name="seasons" id="seasons" />
                                        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
                                      </div>
                                    </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="d-flex ms-3 justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentcreate">
                        <i class="ki-outline ki-dollar fs-2"></i>Payment</a>
                      </div>

                      <div class="modal fade" id="paymentcreate" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_user_header">
                              <h2 class="fw-bold">Add Payment</h2>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                              </div>
                            </div>
                            <div class="modal-body">
                              <form method="post" action="{{ route('yatra-season-payment.store') }}" enctype="multipart/form-data">
                                @csrf
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                      <div class="form-group">
                                          <label for="devotee">Devotee</label>
                                          <select class="form-control" name="devotee" id="devotee" required>
                                            <option value="">Select One</option>
                                            @if($related_devotees->count() != NULL)
                                              @foreach($related_devotees as $devotee)
                                                <option value="{{$devotee->getdevotee->id}}"
                                                  data-kt-rich-content-email="<?php echo $devotee->getdevotee->email; ?>"
                                                  data-kt-rich-content-mobile="<?php echo $devotee->getdevotee->mobile; ?>"
                                                  data-kt-rich-content-initiation="@if(Helper::getinitiationrow($devotee->getdevotee->id)) {{Helper::getinitiationrow($devotee->getdevotee->id)->initiation_name}} @endif"
                                                  >{{$devotee->getdevotee->firstname}} {{$devotee->getdevotee->middlename}} {{$devotee->getdevotee->surname}}</option>
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
                                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                        <input type="hidden" value="{{$show->yatra_id}}" name="yatra" id="yatra" />
                                        <input type="hidden" value="{{$show->id}}" name="seasons" id="seasons" />
                                        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Payment Create</button>
                                      </div>
                                    </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="d-flex ms-3 justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adddocument">
                        <i class="ki-outline ki-file fs-2"></i>Document</a>
                      </div>

                      <div class="modal fade" id="adddocument" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_user_header">
                              <h2 class="fw-bold">Add Document</h2>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                              </div>
                            </div>
                            <div class="modal-body">
                              <form method="post" action="{{ route('yatra-documents.store') }}" enctype="multipart/form-data">
                                @csrf
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                      <div class="form-group">
                                          <label for="devotee">Devotee</label>
                                          <select class="form-control" name="devotee" id="devotee2" required>
                                            <option value="">Select One</option>
                                            @if($related_devotees->count() != NULL)
                                              @foreach($related_devotees as $devotee)
                                                <option value="{{$devotee->getdevotee->id}}"
                                                  data-kt-rich-content-email="<?php echo $devotee->getdevotee->email; ?>"
                                                  data-kt-rich-content-mobile="<?php echo $devotee->getdevotee->mobile; ?>"
                                                  data-kt-rich-content-initiation="@if(Helper::getinitiationrow($devotee->getdevotee->id)) {{Helper::getinitiationrow($devotee->getdevotee->id)->initiation_name}} @endif"
                                                  >{{$devotee->getdevotee->firstname}} {{$devotee->getdevotee->middlename}} {{$devotee->getdevotee->surname}}</option>
                                              @endforeach
                                            @endif
                                          </select>
                                      </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                        <div class="form-group">
                                            <label for="file">File</label>
                                            <input type="file" name="file" id="file" class="form-control" />
                                        </div>
                                      </div>
                                      <div class="col-md-12 col-sm-12 col-lg-12 mb-2">
                                          <div class="form-group">
                                              <label for="type">Type</label>
                                              <select class="form-select form-select-sm" data-control="select2" name="type" id="type" required>
                                                <option value="">Select One</option>
                                                <option value="Citizenship">Citizenship</option>
                                                <option value="Passport">Passport</option>
                                                <option value="Birth Certificate">Birth Certificate</option>
                                                <option value="Other">Other</option>
                                              </select>
                                          </div>
                                        </div>
                                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                        <input type="hidden" value="{{$show->yatra_id}}" name="yatra" id="yatra" />
                                        <input type="hidden" value="{{$show->id}}" name="seasons" id="seasons" />
                                        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Upload</button>
                                      </div>
                                    </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endcan
                      @can('yatra-create')
                      <!--<div class="d-flex" data-kt-user-table-toolbar="base">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <i class="ki-outline ki-plus fs-2"></i>Add Devotee</button>
                      </div>-->
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
                                                    data-kt-rich-content-email="<?php echo $devotee->email; ?>"
                                                    data-kt-rich-content-mobile="<?php echo $devotee->mobile; ?>"
                                                    data-kt-rich-content-initiation="@if(Helper::getinitiationrow($devotee->id)) {{Helper::getinitiationrow($devotee->id)->initiation_name}} @endif"
                                                    >{{$devotee->firstname}} {{$devotee->middlename}} {{$devotee->surname}}</option>
                                                @endforeach
                                              @endif
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                        <input type="hidden" value="{{$show->id}}" name="batch" id="batch" />
                                        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
                                      </div>
                                    </div>
                              </form>
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
                      <table class="table table-bordered">
                      <thead>
                          <tr>
                            <th>Devotee</th>
                            <th>Yatra Season</th>
                            <th>Contact No.</th>
                            <th>Paid Amount</th>
                            <th>Remaining Amount</th>
                            <th>Documents</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @if($related_devotees->count() != NULL)
                        @foreach($related_devotees as $list)
                        <tr>
                          <td><a href="{{ route('yatra.show', $list->id)}}">{{$list->getdevotee->firstname}} {{$list->getdevotee->middlename}} {{$list->getdevotee->surname}}</a></td>
                          <td>{{$list->getyatraseason->name}}</td>
                          <td>{{$list->contact}}</td>
                          <td>{{Helper::getyatrapayment($show->id, $list->devotee_id)->sum('amount')}}</td>
                          <td>{{($show->price) - (Helper::getyatrapayment($show->id, $list->devotee_id)->sum('amount'))}}</td>
                          <td>
                            @if(Helper::getyatradocuments($show->id, $list->devotee_id)->count() != NULL)
                            <ul>
                              @foreach(Helper::getyatradocuments($show->id, $list->devotee_id) as $yatradocument)
                              <li><a href="{{ route('yatraimport.show', ['imageName' => $yatradocument->file]) }}" target="_blank">{{$yatradocument->type}}</a></li>
                              @endforeach
                            </ul>
                            @endif
                          </td>
                          <td>
                            @if($list->status == 'Confirmed') <span class="badge badge-success">Confirmed</span> @endif
                            @if($list->status == 'Partial Payment') <span class="badge badge-light-info">Partial Payment</span> @endif
                            @if($list->status == 'Hold') <span class="badge badge-secondary">Hold</span> @endif
                            @if($list->status == 'Cancelled') <span class="badge badge-light-danger">Cancelled</span> @endif
                          </td>
                          <td class="text-end">
                            <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                            <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                              @can('yatra-list')
                              <div class="menu-item px-3">
                                <a href="{{ route('yatra.show', $list->id)}}" class="btn btn-light d-block">View</a>
                              </div>
                              @endcan
                              @can('yatra-edit')
                              <div class="menu-item px-3">
                                <a href="{{ route('yatra.edit', $list->id)}}" class="btn btn-light d-block">Edit</a>
                              </div>
                              @endcan
                              @can('yatra-delete')
                              <div class="menu-item px-3">
                                <form action="{{ route('yatra.destroy', $list->id)}}" method="post">
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
@endsection

@section('scripts')
<script src="{{asset('themes/assets/plugins/global/plugins.bundle.js')}}"></script>

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

$('#devotee2').select2({
    placeholder: "Select an option",
    templateSelection: optionFormat,
    templateResult: optionFormat
});
</script>
@endsection
