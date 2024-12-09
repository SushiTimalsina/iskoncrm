@extends('frontend.layouts.app')
@section('content')
    {{-- <div class="app-academy">
        <div class="row gy-6 mb-6">
            <div class="col-lg-6">
                <div class="card shadow-none bg-label-primary h-100">
                    <div class="card-body d-flex justify-content-between flex-wrap-reverse">
                        <div
                            class="mb-0 w-100 app-academy-sm-60 d-flex flex-column justify-content-between text-center text-sm-start">
                            <div class="card-title">
                                <h5 class="text-primary mb-2">Earn a Certificate</h5>
                                <p class="text-body w-sm-80 app-academy-xl-100">
                                    Get the right professional certificate program for you.
                                </p>
                            </div>
                            <div class="mb-0"><button class="btn btn-sm btn-primary">View Programs</button></div>
                        </div>
                        <div
                            class="w-100 app-academy-sm-40 d-flex justify-content-center justify-content-sm-end h-px-150 mb-4 mb-sm-0">
                            <img class="img-fluid scaleX-n1-rtl"
                                src="{{ asset('front_themes/assets/img/illustrations/boy-app-academy.png') }}"
                                alt="boy illustration" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-none bg-label-danger h-100">
                    <div class="card-body d-flex justify-content-between flex-wrap-reverse">
                        <div
                            class="mb-0 w-100 app-academy-sm-60 d-flex flex-column justify-content-between text-center text-sm-start">
                            <div class="card-title">
                                <h5 class="text-danger mb-2">Best Rated Courses</h5>
                                <p class="text-body app-academy-sm-60 app-academy-xl-100">
                                    Enroll now in the most popular and best rated courses.
                                </p>
                            </div>
                            <div class="mb-0"><button class="btn btn-sm btn-danger">View Courses</button></div>
                        </div>
                        <div
                            class="w-100 app-academy-sm-40 d-flex justify-content-center justify-content-sm-end h-px-150 mb-4 mb-sm-0">
                            <img class="img-fluid scaleX-n1-rtl" src="../../assets/img/illustrations/girl-app-academy.png"
                                alt="girl illustration" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div> --}}
    <div class="row g-6">
        <div class="col-xl-6 col-lg-8 col-md-8">
            <div class="card h-100">
                <div class="row h-100">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-4">
                            <img src="{{ asset('front_themes/assets/img/illustrations/add-new-roles.png') }}"
                                class="img-fluid mt-sm-4 mt-md-0" alt="add-new-roles" width="83">
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role waves-effect waves-light">
                                Add New Role
                            </button>
                            <p class="mb-0">
                                Add new role, <br>
                                if it doesn't exist.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection
