<div class="app-navbar flex-stack flex-shrink-0" id="kt_app_aside_navbar">
	<div class="d-flex align-items-center me-lg-10">
		<div class="app-navbar-item" id="kt_header_user_menu_toggle">

			<div class="d-flex flex-row  align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-start">
				@php
				$user = Auth::guard('admin')->user();
				$getuser = \App\Models\Admin::find($user->id);
				@endphp
				@php
				if($getuser->devotee_id != NULL){
					$getdevotee = \App\Models\Devotees::find($getuser->devotee_id);
					if($getdevotee->photo != NULL){
				@endphp
					<div class="cursor-pointer symbol symbol-40px flex-column me-4"><img src="{{ route('devoteephoto.show', ['imageName' => $getdevotee->photo]) }}" alt="user" /></div>
				@php } else{ @endphp
					<div class="cursor-pointer symbol symbol-40px flex-column me-4"><img src="{{asset('images/user.jpg')}}" alt="user" /></div>
				@php } } else{ @endphp
					<div class="cursor-pointer symbol symbol-40px flex-column me-4"><img src="{{asset('images/user.jpg')}}" alt="user" /></div>
				@php } @endphp


				<div class="app-navbar-user-name text-gray-900 text-hover-primary fs-5 fw-bold flex-column">Hare Krishna, @if($user->name != NULL){{Crypt::decrypt($user->name)}}@endif<br /><span class="app-navbar-user-info text-gray-600 fw-semibold fs-7 d-block">{{{ isset($user->name) ? $user->email : $user->email }}} @if($user->is_admin == 1)<span class="badge badge-primary">Super Admin</span>@endif @if($user->is_admin == 2)<span class="badge badge-primary">Branch Head</span>@endif  @if($user->is_admin == 0)<span class="badge badge-primary">User</span>@endif @if($user->branch_id != NULL)<span class="badge badge-success">{{$user->getbranch->title}}</span>@endif</span>
				</div>

			</div>


			<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
					<div class="menu-item px-3">
						<div class="menu-content d-flex align-items-center px-3">
							<div class="d-flex flex-column">
								<div class="fw-bold d-flex align-items-center fs-5">@if($user->name != NULL){{Crypt::decrypt($user->name)}}@endif</div>
								{{{ isset($user->name) ? $user->email : $user->email }}}
							</div>
						</div>
					</div>
					<div class="separator my-2"></div>
					<div class="menu-item px-5">
						@if(!empty($user->devotee_id))<a href="{{ route('devotees.show', $user->devotee_id)}}" class="menu-link px-5">My Profile</a>@endif
					</div>
					<div class="separator my-2"></div>
					<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
						<a href="#" class="menu-link px-5">
							<span class="menu-title position-relative">Mode
							<span class="ms-5 position-absolute translate-middle-y top-50 end-0">
								<i class="ki-outline ki-night-day theme-light-show fs-2"></i>
								<i class="ki-outline ki-moon theme-dark-show fs-2"></i>
							</span></span>
						</a>
						<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
							<div class="menu-item px-3 my-0">
								<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
									<span class="menu-icon" data-kt-element="icon">
										<i class="ki-outline ki-night-day fs-2"></i>
									</span>
									<span class="menu-title">Light</span>
								</a>
							</div>
							<div class="menu-item px-3 my-0">
								<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
									<span class="menu-icon" data-kt-element="icon">
										<i class="ki-outline ki-moon fs-2"></i>
									</span>
									<span class="menu-title">Dark</span>
								</a>
							</div>
							<div class="menu-item px-3 my-0">
								<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
									<span class="menu-icon" data-kt-element="icon">
										<i class="ki-outline ki-screen fs-2"></i>
									</span>
									<span class="menu-title">System</span>
								</a>
							</div>
						</div>
					</div>
					<div class="menu-item px-5">
						<a class="menu-link px-5" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>
						<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">@csrf</form>
					</div>
				</div>
		</div>
	</div>
	@include('backend.layouts.notifications')
</div>
