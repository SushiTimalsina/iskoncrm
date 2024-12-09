<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('front_themes/assets/') }}/" data-template="horizontal-menu-template" data-style="light">

    @include('frontend.layouts.head')

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
            <div class="layout-container">
                <!-- Navbar -->
                @include('frontend.layouts.nav')
                <!-- / Navbar -->

                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Menu -->
                        {{-- @include('frontend.layouts.aside') --}}

                        <!-- / Menu -->

                        <!-- Content -->

                        <div class="container-xxl flex-grow-1 container-p-y">
                            @include('frontend.layouts.breadcrumb')
                            <!-- User Profile Content -->
                            @yield('content')
                            <!-- /User Profile Content -->

                        </div>
                        <!--/ Content -->

                        @include('frontend.layouts.footer')
                    </div>
                    <!--/ Content wrapper -->
                </div>

                <!--/ Layout container -->
            </div>
        </div>

        @include('frontend.layouts.script')
    </body>

</html>
