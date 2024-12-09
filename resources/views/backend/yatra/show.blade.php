@extends('backend.layouts.master')

@section('styles')
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
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Yatra Devotee Details</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('yatra.index')}}" class="text-muted text-hover-primary">Yatra Management</a>
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
                        <a href="{{ route('yatra.edit', $show->id)}}" class="btn btn-primary">
                        <i class="ki-outline ki-pencil fs-2"></i>Edit</a>
                      </div>
                      @endcan
                      @can('yatra-delete')
                      <div class="d-flex ms-3 justify-content-end" data-kt-user-table-toolbar="base">
                        <form action="{{ route('yatra.destroy', $show->id)}}" method="post">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure to delete this data?')" title="Delete"><i class="ki-outline ki-trash fs-2"></i>Trash</button>
                        </form>
                      </div>
                      @endcan
                      @can('yatra-edit')
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
                                        <input type="hidden" value="{{$show->devotee_id}}" name="devotee" id="devotee" />
                                        <input type="hidden" value="{{$show->yatra_id}}" name="yatra" id="yatra" />
                                        <input type="hidden" value="{{$show->yatra_seasons_id}}" name="seasons" id="seasons" />
                                        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Payment Create</button>
                                      </div>
                                    </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="d-flex ms-3 justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#yatradocument">
                        <i class="ki-outline ki-file fs-2"></i>Document</a>
                      </div>

                      <div class="modal fade" id="yatradocument" tabindex="-1" aria-hidden="true">
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
                                    <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
                                        <div class="form-group">
                                            <label for="file">File</label>
                                            <input type="file" name="file" id="file" class="form-control" />
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6 col-lg-6 mb-4">
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
                                        <input type="hidden" value="{{$show->devotee_id}}" name="devotee" id="devotee" />
                                        <input type="hidden" value="{{$show->yatra_id}}" name="yatra" id="yatra" />
                                        <input type="hidden" value="{{$show->yatra_seasons_id}}" name="seasons" id="seasons" />
                                        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Payment Create</button>
                                      </div>
                                    </div>
                              </form>
                            </div>
                          </div>
                        </div>
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

                    <h3 class="mb-2">Season Details</h3>
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
                            <td>{{$getseason->getyatra->title}}</td>
                            <td>{{$getseason->name}}</td>
                            <td>Rs. {{$getseason->price}}</td>
                            <td>{{$getseason->pricedetails}}</td>
                            <td>{{$getseason->route}}</td>
                            <td>
                              @if($getseason->status == 'Completed') <span class="badge badge-light-success">Completed</span> @endif
                              @if($getseason->status == 'Active') <span class="badge badge-light-success">Active</span> @endif
                              @if($getseason->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
                              @if($getseason->status == 'Trash') <span class="badge badge-light-danger">Trash</span> @endif
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <h3 class="mt-5 mb-2">Devotee Details</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                              <th>Devotee</th>
                              <th>Yatra</th>
                              <th>Season</th>
                              <th>Branch</th>
                              <th>Room</th>
                              <th>Contact</th>
                              <th>Other Travel</th>
                              <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{$show->getdevotee->firstname}} {{$show->getdevotee->middlename}} {{$show->getdevotee->surname}}</td>
                            <td>{{$show->getyatra->title}}</td>
                            <td>{{$show->getyatraseason->name}}</td>
                            <td>{{$show->getbranch->title}}</td>
                            <td>{{$show->contact}}</td>
                            <td>@if($show->othertravel == 1) Yes @else No @endif</td>
                            <td>
                              @if($show->status == 'Confirmed') <span class="badge badge-success">Confirmed</span> @endif
                              @if($show->status == 'Partial Payment') <span class="badge badge-light-info">Partial Payment</span> @endif
                              @if($show->status == 'Hold') <span class="badge badge-secondary">Hold</span> @endif
                              @if($show->status == 'Cancelled') <span class="badge badge-light-danger">Cancelled</span> @endif
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <h3 class="mt-5 mb-2">Payment Details</h3>
                    <strong>Total Paid: </strong>Rs. {{$yatrapayments->sum('amount')}}, <strong>Remaining: </strong>Rs. {{$getseason->price - $yatrapayments->sum('amount')}}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                              <th>Amount</th>
                              <th>Paid By</th>
                              <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                          @if($yatrapayments->count() != NULL)
                          @foreach($yatrapayments as $yatrapayment)
                          <tr>
                            <td>{{$yatrapayment->amount}}</td>
                            <td>{{$yatrapayment->paidby}}</td>
                            <td>{{$yatrapayment->created_at}}</td>
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                      </table>
                    </div>

                    <h3 class="mt-5 mb-2">Document Details</h3>
                    @if($yatradocuments->count() != NULL)
                    <ul>
                      @foreach($yatradocuments as $yatradocument)
                      <li><a href="{{ route('yatraimport.show', ['imageName' => $yatradocument->file]) }}" target="_blank">{{$yatradocument->type}}</a></li>
                      @endforeach
                    </ul>
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
@endsection
