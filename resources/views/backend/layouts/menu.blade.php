<div class="app-sidebar-menu d-flex flex-center overflow-hidden flex-column-fluid">
  <!--begin::Menu wrapper-->
  <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper d-flex hover-scroll-overlay-y scroll-ps mx-2 my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu, #kt_app_sidebar" data-kt-scroll-offset="5px">
    <!--begin::Menu-->
    <div class="menu menu-column menu-rounded menu-active-bg menu-title-gray-700 menu-arrow-gray-500 menu-icon-gray-500 menu-bullet-gray-500 menu-state-primary my-auto" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
      <!--begin:Menu item-->
      <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item here show py-2">
        <!--begin:Menu link-->
        <span class="menu-link menu-center">
          <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
          </span>
        </span>
      </div>

      <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
        <!--begin:Menu link-->
        <span class="menu-link menu-center">
          <span class="menu-icon me-0">
            <i class="ki-outline ki-note fs-2x"></i>
          </span>
        </span>

        <div class="menu-sub menu-sub-dropdown px-2 py-4 w-200px w-lg-225px mh-75 overflow-auto">
          <div class="menu-item">
            <a class="menu-link" href="#">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Devotees</span>
            </a>
          </div>
        </div>
      </div>

      <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
        <!--begin:Menu link-->
        <span class="menu-link menu-center">
          <span class="menu-icon me-0">
            <i class="ki-outline ki-setting fs-2x"></i>
          </span>
        </span>

        <div class="menu-sub menu-sub-dropdown px-2 py-4 w-200px w-lg-225px mh-75 overflow-auto">
          <div class="menu-item">
            <a class="menu-link" href="#">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Sewa Category</span>
            </a>
          </div>
          <div class="menu-item">
            <a class="menu-link" href="#">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Departments</span>
            </a>
          </div>
          <div class="menu-item">
            <a class="menu-link" href="{{ route('roles.index') }}">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Branches</span>
            </a>
          </div>
        </div>
      </div>


      <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
        <!--begin:Menu link-->
        <span class="menu-link menu-center">
          <span class="menu-icon me-0">
            <i class="ki-outline ki-user fs-2x"></i>
          </span>
        </span>

        <div class="menu-sub menu-sub-dropdown px-2 py-4 w-200px w-lg-225px mh-75 overflow-auto">
          <div class="menu-item">
            <a class="menu-link" href="{{ route('roles.index') }}">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Roles</span>
            </a>
          </div>
          <div class="menu-item">
            <a class="menu-link" href="{{ route('users.index') }}">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Users</span>
            </a>
          </div>
          <div class="menu-item">
            <a class="menu-link" href="#">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Activity Log</span>
            </a>
          </div>
          <div class="menu-item">
            <a class="menu-link" href="{{route('changelog.index')}}">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Change Log</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
