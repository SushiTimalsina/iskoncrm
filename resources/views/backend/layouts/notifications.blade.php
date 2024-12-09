<div class="app-navbar-item">
  <!--begin::Menu wrapper-->
  <div class="btn btn-icon btn-custom btn-dark w-40px h-40px app-navbar-user-btn" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
    <i class="ki-outline ki-notification-on fs-1"></i>
  </div>
  <!--begin::Menu-->
  <div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px" data-kt-menu="true">
    <!--begin::Heading-->
    <div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10" style="background:#B13126;">
      <!--begin::Title-->
      <h3 class="text-white fw-semibold mb-3">Quick Links</h3>
      <!--end::Title-->
      <!--begin::Status-->
      <!--<span class="badge bg-primary text-inverse-primary py-2 px-3">25 pending tasks</span>-->
      <!--end::Status-->
    </div>
    <!--end::Heading-->
    <!--begin:Nav-->
    <div class="row g-0">
      <!--begin:Item-->
      <div class="col-6">
        <a href="{{route('donation.create')}}" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
          <i class="ki-outline ki-dollar fs-3x text-primary mb-2"></i>
          <span class="fs-5 fw-semibold text-gray-800 mb-0">Add Donation</span>
        </a>
      </div>
      <!--end:Item-->
      <!--begin:Item-->
      <div class="col-6">
        <a href="{{route('devotees.create')}}" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-bottom">
          <i class="ki-outline ki-user fs-3x text-primary mb-2"></i>
          <span class="fs-5 fw-semibold text-gray-800 mb-0">Add Devotee</span>
        </a>
      </div>
      <!--end:Item-->
      <!--begin:Item-->
      <div class="col-6">
        <a href="{{route('sewa-attend.create')}}" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end">
          <i class="ki-outline ki-calendar fs-3x text-primary mb-2"></i>
          <span class="fs-5 fw-semibold text-gray-800 mb-0">Add Sewa</span>
        </a>
      </div>
      <!--end:Item-->
      <!--begin:Item-->
      <div class="col-6">
        <a href="{{route('devotees.index')}}" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light">
          <i class="ki-outline ki-sort fs-3x text-primary mb-2"></i>
          <span class="fs-5 fw-semibold text-gray-800 mb-0">Devotees</span>
        </a>
      </div>
      <!--end:Item-->
    </div>
  </div>
</div>
