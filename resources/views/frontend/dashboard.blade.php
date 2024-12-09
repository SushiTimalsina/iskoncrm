{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ISKCON</title>
        <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
        <!-- Styles -->
        <style>
            html,
            body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .links a {
                background: transparent;
                border: 1px solid #B13126;
                color: #B13126;
                padding: 10px 30px;
                border-radius: 5px;
                display: inline-block;
                font-weight: 600;
                text-transform: uppercase;
                text-decoration: none;
            }

            .links a:hover {
                background: #B13126;
                color: white;
            }

            .aligncenter {
                text-align: center;
            }
        </style>
    </head>

    <body>

        <?php
        $str = date('Y', strtotime($view->created_at));
        $str1 = substr($str, 1);
        ?>
        <div class="container p-5">
            <div class="aligncenter">
                <img src="{{ asset('images/logo.jpeg') }}" width="200">
                <h1 class="mt-2 mb-2" style="font-weight:900; color:black;">Hare Krishna<br />
                    @if ($user->name != null)
                        {{ Crypt::decrypt($user->name) }}
                    @endif
                </h1>
                <h1 class="font-weight-bold" style="font-weight:900; color:black;">
                    IN-{{ $str1 }}-{{ $view->id }}</h1>
            </div>
            <div class="row align-items-center mt-2">
                <div class="col-md-6 col-sm-6 col-lg-6 aligncenter">{!! QrCode::size(280)->generate('IN-' . $str1 . '-' . $view->id) !!}</div>
                <div class="col-md-6 col-sm-6 col-lg-6">
                    <table class="customtable mt-2 mb-2">
                        <tr>
                            <th>Email</th>
                            <td>: @if ($view->email_enc != null)
                                    {{ Crypt::decrypt($view->email_enc) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>: @if ($view->countrycode != null)
                                    {{ $view->countrycode }}
                                    @endif @if ($view->mobile_enc != null)
                                        {{ Crypt::decrypt($view->mobile_enc) }}
                                    @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Profile Age</th>
                            <td>: {{ \Carbon\Carbon::parse($view->created_at)->diffForhumans() }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="aligncenter mt-3">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf
                </form>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="btn btn-primary">Logout</a>
            </div>
        </div>
    </body>

</html> --}}

@extends('frontend.layouts.app')
@section('content')
    <div class="row">
        <?php
        $str = date('Y', strtotime($view->created_at));
        $str1 = substr($str, 1);
        ?>
        <div class="col-xl-4 col-lg-5 col-md-5">
            <!-- About User -->
            <div class="card mb-6">
                <div class="card-body">
                    <small class="card-text text-uppercase text-muted small">About</small>
                    <ul class="list-unstyled my-3 py-1">
                        <li class="d-flex align-items-center mb-4">
                            <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Full
                                Name:</span>
                            <span> {{ Crypt::decrypt($user->name) }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class="ti ti-cake"></i><span class="fw-medium mx-2">Date of Birth:</span>
                            <span>
                                @if ($view->dob != null)
                                    {{ Crypt::decrypt($view->dob) }}
                                @endif
                            </span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class="ti ti-crown ti-lg"></i><span class="fw-medium mx-2">Marital Status:</span>
                            <span>
                                @if ($view->marital_status != null)
                                    {{ $view->marital_status }}
                                @endif
                            </span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class="ti ti-school"></i><span class="fw-medium mx-2">Education:</span>
                            <span>{{ $view->education }}</span>
                        </li>
                        {{-- <li class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-location-dot"></i><span class="fw-medium mx-2">Address:</span>
                            <span>Kalanki</span>
                        </li> --}}
                        <li class="d-flex align-items-center mb-2">
                            <i class="ti ti-droplet"></i><span class="fw-medium mx-2">Blood Group:</span>
                            <span>{{ $view->bloodgroup }}</span>
                        </li>
                    </ul>
                    <small class="card-text text-uppercase text-muted small">Contacts</small>
                    <ul class="list-unstyled my-3 py-1">
                        <li class="d-flex align-items-center mb-4">
                            <i class="ti ti-phone-call ti-lg"></i><span class="fw-medium mx-2">Contact:</span>
                            <span>
                                @if ($view->countrycode != null)
                                    {{ $view->countrycode }}
                                    @endif @if ($view->mobile_enc != null)
                                        {{ Crypt::decrypt($view->mobile_enc) }}
                                    @endif
                            </span>
                        </li>

                        <li class="d-flex align-items-center mb-4">
                            <i class="ti ti-mail ti-lg"></i><span class="fw-medium mx-2">Email:</span>
                            <span>
                                @if ($view->email_enc != null)
                                    {{ Crypt::decrypt($view->email_enc) }}
                                @endif
                            </span>
                        </li>
                    </ul>
                    <small class="card-text text-uppercase text-muted small">Legal
                        Details</small>
                    <ul class="list-unstyled my-3 py-1">


                        <li class="d-flex align-items-center mb-4">
                            <span class="fw-medium mx-2">Nationality:</span>
                            <span>
                                @if ($view->nationality != null)
                                    {{ $view->nationality }}
                                @endif
                            </span>
                        </li>

                        <li class="d-flex align-items-center mb-4">
                            <span class="fw-medium mx-2">Identity Type:</span>
                            <span>
                                @if ($view->identitytype != null)
                                    {{ Crypt::decrypt($view->identitytype) }}
                                @endif
                            </span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <span class="fw-medium mx-2">Identity Number:</span>
                            <span>
                                @if ($view->identityid_enc != null)
                                    {{ Crypt::decrypt($view->identityid_enc) }}
                                @endif
                            </span>
                        </li>
                    </ul>
                    <small class="card-text text-uppercase text-muted small">Skills</small>
                    <ul class="list-unstyled mb-0 mt-3 pt-1">
                        <li class="d-flex flex-wrap mb-4">
                            <span class="fw-medium me-2">
                                @if ($skills->count() != null)
                                    @foreach ($skills as $skill)
                                        <div class="d-inline-block">
                                            <span class="badge bg-info bg-glow">{{ $skill->getskill->title }} </span>
                                        </div>
                                    @endforeach
                                @endif
                            </span>
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


                        {{-- <div class="fw-bold">Permanent Address</div>
                        <div class="text-gray-600"> --}}
                        {{-- @if (isset($provincebyId))
                                {{ $provincebyId->name }}
                                <br />
                            @endif

                            @if (isset($tolebyId))
                                {{ $tolebyId->name }} - @if ($view->pwardno != null)
                                    {{ Crypt::decrypt($view->pwardno) }}
                                @endif
                                <br />
                            @endif

                            @if (isset($districtbyId))
                                {{ $districtbyId->name }} {{ $provincebyId->name }}
                            @endif --}}
                        {{-- </div> --}}
                        <li class="d-flex align-items-end mb-4">

                            <span class="fw-medium mx-2">
                                Permanent Address:</span>
                            <span>
                                @if (isset($provincebyId))
                                    {{ $provincebyId->name }}
                                @endif

                                @if (isset($tolebyId))
                                    {{ $tolebyId->name }} - @if ($view->pwardno != null)
                                        {{ Crypt::decrypt($view->pwardno) }}
                                    @endif
                                @endif

                                @if (isset($districtbyId))
                                    {{ $districtbyId->name }}
                                @endif
                            </span>
                        </li>
                        <li class="d-flex align-items-end mb-4">

                            <span class="fw-medium mx-2">
                                Temporary Address:</span>
                            <span>

                                @if (isset($tprovincebyId))
                                    {{ $tprovincebyId->name }}
                                @endif

                                @if (isset($ttolebyId))
                                    {{ $ttolebyId->name }} - @if ($view->twardno != null)
                                        {{ Crypt::decrypt($view->twardno) }}
                                    @endif
                                @endif

                                @if (isset($tdistrictbyId))
                                    {{ $tdistrictbyId->name }}
                                @endif
                            </span>
                        </li>
                        {{-- <li class="d-flex align-items-end mb-4">
                            <i class="fa-solid fa-book"></i><span class="fw-medium mx-2">Books
                                Read:</span>
                            <span>6</span>
                        </li>
                        <li class="d-flex align-items-end">
                            <i class="fa-solid fa-arrows-spin"></i><span class="fw-medium mx-2">Total Sewa Days:</span>
                            <span>8</span>
                        </li> --}}
                    </ul>
                </div>
            </div>

            <!--/ Profile Overview -->
        </div>
    </div>
@endsection

@section('scripts')
@endsection
