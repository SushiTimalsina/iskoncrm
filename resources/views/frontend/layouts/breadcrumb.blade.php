<?php
$str = date('Y', strtotime($view->created_at));
$str1 = substr($str, 1);
?>
<div class="row">

    <div class="col-12">
        <div class="card mb-6">
            <div class="user-profile-header-banner">
                <img src="{{ asset('front_themes/assets/img/pages/banner.jpeg') }}" alt="Banner image"
                    class="rounded-top" />
            </div>
            <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    {{-- @if ($view->photo != null)
                        <a href="{{ route('devoteephoto.show', ['imageName' => $view->photo]) }}"
                            data-fancybox="gallery"><img
                                src="{{ route('devoteephoto.show', ['imageName' => $view->photo]) }}"
                                alt="image" /></a>
                    @else
                        <div class="symbol symbol-100px mb-2"><img src="{{ asset('images/user.jpg') }}"
                                alt="image" /></div>
                    @endif --}}

                    {{-- <img src="{{ asset('front_themes/assets/img/avatars/avatar.png') }}" alt="user image"
                        class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" /> --}}
                    @if ($view->photo != null)
                        <img src="{{ route('devoteephoto.show', ['imageName' => $view->photo]) }}" alt="user image"
                            class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" />
                    @else
                        <img src="{{ asset('front_themes/assets/img/avatars/avatar.png') }}" alt="user image"
                            class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" />
                    @endif

                </div>
                <div class="flex-grow-1 mt-3 mt-lg-5">
                    <div
                        class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                        <div class="user-profile-info">
                            <h4 class="mb-2 mt-lg-6">{{ strtoupper(Crypt::decrypt($user->name)) }}

                                @if ($initiation && $initiation->initiation_name)
                                    ({{ strtoupper($initiation->initiation_name) }})
                                @endif


                            </h4>
                            <ul
                                class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">
                                <li class="list-inline-item d-flex gap-2 align-items-center">
                                    <i class="fa-solid fa-briefcase"></i></i><span class="fw-medium">
                                        @if ($view->member != null)
                                            <span class="badge bg-primary">Life Member</span>
                                        @endif
                                    </span>
                                </li>
                                <li class="list-inline-item d-flex gap-2 align-items-center">
                                    <i class="ti ti-map-pin ti-lg"></i><span
                                        class="fw-medium">{{ $view->getbranch->title }}</span>
                                </li>
                                <li class="list-inline-item d-flex gap-2 align-items-center">
                                    <i class="ti ti-calendar ti-lg"></i><span class="fw-medium">
                                        Joined {{ \Carbon\Carbon::parse($view->created_at)->diffForhumans() }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-6">

                            <div class="mt-4 d-flex justify-content-end">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalCenter">
                                    <i class="fa-solid fa-qrcode me-1"> </i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle"> My Qr</h5>

                                            </div>
                                            <div class="modal-body">
                                                {!! QrCode::size(280)->generate('IN-' . $str1 . '-' . $view->id) !!}


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn btn-label-secondary"
                                                    data-bs-dismiss="modal">
                                                    Close
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Navbar pills -->
<div class="row">
    <div class="col-md-12">
        <div class="nav-align-top">
            <ul class="nav nav-pills flex-column flex-sm-row mb-6 gap-2 gap-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('userdashboard') ? 'active' : '' }}"
                        href="{{ route('userdashboard') }}">
                        <i class="ti-sm ti ti-user-check me-1_5"></i> Profile
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('coursedashboard') ? 'active' : '' }}"
                        href="{{ route('coursedashboard') }}">
                        <i class="fa-solid fa-award me-1_5"></i> Courses
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('donationdashboard') ? 'active' : '' }}"
                        href="{{ route('donationdashboard') }}">
                        <i class="fa-solid fa-hands-holding-circle me-1_5"></i> Donations
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('sewadashboard') ? 'active' : '' }}"
                        href="{{ route('sewadashboard') }}">
                        <i class="fa-solid fa-hand-holding-hand me-1_5"></i> Sewa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages-profile-booksread.html"><i class="fa-solid fa-book-open me-1_5"></i>
                        Books Read</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--/ Navbar pills -->
