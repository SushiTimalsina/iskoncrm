<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="100px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
  <!--begin::Logo-->
  <div class="app-sidebar-logo d-none d-lg-flex flex-center pt-10 mb-3" id="kt_app_sidebar_logo">
    <!--begin::Logo image-->
    <a href="{{route('home')}}">
      <img alt="Logo" src="{{asset('images/icon.png')}}" class="h-60px" />
    </a>
    <!--end::Logo image-->
  </div>
  <div class="app-sidebar-menu d-flex flex-center overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper d-flex hover-scroll-overlay-y scroll-ps mx-2 my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu, #kt_app_sidebar" data-kt-scroll-offset="5px">
      <!--begin::Menu-->
      <div class="menu menu-column menu-rounded menu-active-bg menu-title-gray-700 menu-arrow-gray-500 menu-icon-gray-500 menu-bullet-gray-500 menu-state-primary my-auto" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item here show py-2">
          <!--begin:Menu link-->
          <a class="menu-link menu-center" href="{{ route('home') }}">
            <span class="menu-icon me-0">
              <i class="ki-outline ki-home-2 fs-2x"></i>
            </span>
          </a>
        </div>

        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
          <span class="menu-link menu-center">
            <span class="menu-icon me-0">
              <i class="branchesicon"></i>
            </span>
          </span>

          <div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto">
            @can('devotee-list')
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('devotees.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Devotee Management</span>
                  </a>
                </div>
            @endcan
            @if(auth()->user()->can('sewa-list'))
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Service Management</span>
                <span class="menu-arrow"></span>
              </span>
              <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                  <a class="menu-link" href="{{route('sewa-attend.index')}}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Service Attendance</span>
                  </a>
                </div>
                @can('department-list')
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('department.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Service Departments</span>
                  </a>
                </div>
                @endcan
              </div>
            </div>
            @endif
            @if(auth()->user()->can('course-list'))
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Courses</span>
                <span class="menu-arrow"></span>
              </span>
              <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('course-batch.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Batch Management</span>
                  </a>
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('course-facilitator.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Facilitator</span>
                  </a>
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('courses.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Courses Category</span>
                  </a>
                </div>
              </div>
            </div>
            @endif
            @if(auth()->user()->can('initiative-list'))
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Initiation & Gurus</span>
                <span class="menu-arrow"></span>
              </span>
              <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('initiation.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Initiation Management</span>
                  </a>
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('initiative-guru.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Initiation Guru</span>
                  </a>
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('mentor.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Mentor Management</span>
                  </a>
                </div>
              </div>
            </div>
            @endif
            @if(auth()->user()->can('yatra-list'))
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Yatra</span>
                <span class="menu-arrow"></span>
              </span>
              <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('yatra-season.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Yatra Season</span>
                  </a>
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('yatra-category.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Yatra Category</span>
                  </a>
                </div>
              </div>
            </div>
            @endif
            @if(auth()->user()->can('donation-list'))
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Donations</span>
                <span class="menu-arrow"></span>
              </span>
              <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('donation.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Donation</span>
                  </a>
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('guest-take-care.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Guest Take Care</span>
                  </a>
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('sewa-sankalpa.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Sewa Sankalpa</span>
                  </a>
                </div>
                @can('sewa-list')
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('sewa.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Donation Category</span>
                  </a>
                </div>
                @endcan
              </div>
            </div>
            @endif
            @if(auth()->user()->can('skills-list'))
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Occupations & Skills</span>
                <span class="menu-arrow"></span>
              </span>
              <div class="menu-sub menu-sub-accordion">
                @can('skills-list')
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('skills.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Skills</span>
                  </a>
                </div>
                @endcan
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('occupations.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Occupations</span>
                  </a>
                </div>
              </div>
            </div>
            @endif
            @if(auth()->user()->can('branch-list'))
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Branch</span>
                <span class="menu-arrow"></span>
              </span>
              <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('branch.index') }}">
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Branches</span>
                  </a>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>

        @if(auth()->user()->can('role-list') || auth()->user()->can('user-list'))
        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
          <!--begin:Menu link-->
          <span class="menu-link menu-center">
            <span class="menu-icon me-0">
              <i class="ki-outline ki-user fs-2x"></i>
            </span>
          </span>

          <div class="menu-sub menu-sub-dropdown px-2 py-4 w-200px w-lg-225px mh-75 overflow-auto">
            @can('admin-list')
            <div class="menu-item">
              <a class="menu-link" href="{{ route('admins.index') }}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Admins</span>
              </a>
            </div>
            @endcan
            @can('user-list')
            <div class="menu-item">
              <a class="menu-link" href="{{ route('users.index') }}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Users</span>
              </a>
            </div>
            @endcan
            @can('role-list')
              <div class="menu-item">
                <a class="menu-link" href="{{ route('roles.index') }}">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Roles</span>
                </a>
              </div>
              @endcan
            @can('user-list')
            <div class="menu-item">
              <a class="menu-link" href="{{route('activity-logs.index')}}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Activity Log</span>
              </a>
            </div>
            @endcan
            @can('user-list')
            <div class="menu-item">
              <a class="menu-link" href="{{route('changelog.index')}}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Changelog Management</span>
              </a>
            </div>
            @endcan
            <div class="menu-item">
              <a class="menu-link" href="{{route('changelogview')}}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Changelog</span>
              </a>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
