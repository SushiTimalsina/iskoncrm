@extends('frontend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5">
            <!-- About User -->
            <div class="card mb-6">
                <div class="card-body">
                    <small class="card-text text-uppercase text-muted small">About</small>
                    <ul class="list-unstyled my-3 py-1">
                        <li class="d-flex align-items-center mb-4">
                            <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Full
                                Name:</span>
                            <span>Hare Krsna</span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class="fa-solid fa-cake-candles"></i><span class="fw-medium mx-2">Date of Birth:</span>
                            <span>17,Nov 2004</span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class="ti ti-crown ti-lg"></i><span class="fw-medium mx-2">Marital Status:</span>
                            <span>Single</span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class="fa-solid fa-user-graduate"></i><span class="fw-medium mx-2">Education:</span>
                            <span>+2</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-location-dot"></i><span class="fw-medium mx-2">Address:</span>
                            <span>Kalanki</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-droplet"></i><span class="fw-medium mx-2">Blood Group:</span>
                            <span>+0</span>
                        </li>
                    </ul>
                    <small class="card-text text-uppercase text-muted small">Contacts</small>
                    <ul class="list-unstyled my-3 py-1">
                        <li class="d-flex align-items-center mb-4">
                            <i class="ti ti-phone-call ti-lg"></i><span class="fw-medium mx-2">Contact:</span>
                            <span>984791720312</span>
                        </li>

                        <li class="d-flex align-items-center mb-4">
                            <i class="ti ti-mail ti-lg"></i><span class="fw-medium mx-2">Email:</span>
                            <span>haribol@gmail.com</span>
                        </li>
                    </ul>
                    <small class="card-text text-uppercase text-muted small">Legal
                        Details</small>
                    <ul class="list-unstyled my-3 py-1">
                        <li class="d-flex align-items-center mb-4">
                            <span class="fw-medium mx-2">Nationality:</span>
                            <span>Nepal</span>
                        </li>

                        <li class="d-flex align-items-center mb-4">
                            <span class="fw-medium mx-2">Identity Type:</span>
                            <span>Passport</span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <span class="fw-medium mx-2">Identity Number:</span>
                            <span>872872ABC</span>
                        </li>
                    </ul>

                    </ul>
                    <small class="card-text text-uppercase text-muted small">Skills</small>
                    <ul class="list-unstyled mb-0 mt-3 pt-1">
                        <li class="d-flex flex-wrap mb-4">
                            <span class="fw-medium me-2">Cooking</span>
                        </li>
                        <li class="d-flex flex-wrap">
                            <span class="fw-medium me-2">Preaching</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!--/ About User -->
            <!-- Profile Overview -->
            <div class="card mb-6">
                <div class="card-body">
                    <small class="card-text text-uppercase text-muted small">Overview</small>
                    <ul class="list-unstyled mb-0 mt-3 pt-1">
                        <li class="d-flex align-items-end mb-4">
                            <i class="ti ti-check ti-lg"></i><span class="fw-medium mx-2">Total
                                Department served:</span>
                            <span>13.5k</span>
                        </li>
                        <li class="d-flex align-items-end mb-4">
                            <i class="fa-solid fa-book"></i><span class="fw-medium mx-2">Books
                                Read:</span>
                            <span>6</span>
                        </li>
                        <li class="d-flex align-items-end">
                            <i class="fa-solid fa-arrows-spin"></i><span class="fw-medium mx-2">Total Sewa Days:</span>
                            <span>8</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!--/ Profile Overview -->
        </div>
    </div>
@endsection
