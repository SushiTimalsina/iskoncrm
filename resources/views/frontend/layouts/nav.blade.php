<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-xxl">
        <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
            <a href="index.html" class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img src="{{ asset('front_themes/assets/img/favicon/iskcon_logo.jpg') }}" alt="image-description"
                        style=" width:64px; height:52px;">
                </span>
                <span class="app-brand-text demo menu-text fw-bold">ISKCON Nepal</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i class="ti ti-x ti-md align-middle"></i>
            </a>
        </div>

        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="ti ti-menu-2 ti-md"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">




                <!-- Style Switcher -->
                <li class="nav-item dropdown-style-switcher dropdown">
                    <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                        href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i class="ti ti-md"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                <span class="align-middle"><i class="ti ti-sun ti-md me-3"></i>Light</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                <span class="align-middle"><i class="ti ti-moon-stars ti-md me-3"></i>Dark</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                <span class="align-middle"><i
                                        class="ti ti-device-desktop-analytics ti-md me-3"></i>System</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- / Style Switcher-->




                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                        data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            @if ($view->photo != null)
                                <img src="{{ route('devoteephoto.show', ['imageName' => $view->photo]) }}"
                                    alt="user image" alt class="rounded-circle" />
                            @else
                                <img src="{{ asset('front_themes/assets/img/avatars/avatar.png') }}" alt="user image"
                                    alt class="rounded-circle" />
                            @endif
                            {{-- <img src   ="../../assets/img/avatars/avatar.png" alt class="rounded-circle" /> --}}
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item mt-0" href="pages-account-settings-account.html">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar avatar-online">
                                            @if ($view->photo != null)
                                                <img src="{{ route('devoteephoto.show', ['imageName' => $view->photo]) }}"
                                                    alt="user image" alt class="rounded-circle" />
                                            @else
                                                <img src="{{ asset('front_themes/assets/img/avatars/avatar.png') }}"
                                                    alt="user image" alt class="rounded-circle" />
                                            @endif
                                            {{-- <img src="../../assets/img/avatars/1.png" alt class="rounded-circle" /> --}}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ strtoupper(Crypt::decrypt($user->name)) }}</h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider my-1 mx-n2"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="pages-profile-user.html">
                                <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">My
                                    Profile</span>
                            </a>
                        </li>




                        <li>
                            <div class="d-grid px-2 pt-2 pb-1">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">@csrf
                                </form>

                                <a class="btn btn-sm btn-danger d-flex" href="{{ route('logout') }}" target="_blank"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <small class="align-middle">Logout</small>
                                    <i class="ti ti-logout ms-2 ti-14px"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>

        <!-- Search Small Screens -->
        <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
            <input type="text" class="form-control search-input border-0" placeholder="Search..."
                aria-label="Search..." />
            <i class="ti ti-x search-toggler cursor-pointer"></i>
        </div>
    </div>
</nav>
