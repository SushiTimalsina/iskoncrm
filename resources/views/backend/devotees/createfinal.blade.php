@extends('backend.layouts.master')

@section('styles')
    <link href="{{ asset('themes/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('nepalidate/nepali.datepicker.v4.0.5.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header d-flex" data-kt-sticky="true"
                data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky"
                data-kt-sticky-offset="{default: false, lg: '300px'}">
                <!--begin::Header container-->
                <div class="app-container container-fluid d-flex align-items-stretch" id="kt_app_header_container">
                    <!--begin::Header wrapper-->
                    <div class="app-header-wrapper d-flex flex-stack w-100">
                        <!--begin::Logo wrapper-->
                        @include('backend.layouts.mobile-logo')
                        <!--end::Logo wrapper-->
                        <!--begin::Page title wrapper-->
                        <div id="kt_app_header_page_title_wrapper">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
                                data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_page_title_wrapper'}"
                                class="page-title d-flex flex-column justify-content-center me-3 mb-6 mb-lg-0">
                                <!--begin::Title-->
                                <h1
                                    class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">
                                    Create Devotee</h1>
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                    <li class="breadcrumb-item text-muted">
                                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                    </li>
                                    <li class="breadcrumb-item text-muted">
                                        <a href="{{ route('devotees.index') }}"
                                            class="text-muted text-hover-primary">Devotee Management</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @include('backend.layouts.usermenu')
                    </div>
                </div>
            </div>
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                @include('backend.layouts.leftmenu')

                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card">
                                    <div class="card-body pr-5 pl-5">
                                        @if (session()->get('success'))
                                            <div class="alert alert-success">
                                                <div class="alert-body">{{ session()->get('success') }}</div>
                                            </div>
                                        @endif

                                        @if (session()->get('error'))
                                            <div class="alert alert-danger">
                                                <div class="alert-body">{{ session()->get('error') }}</div>
                                            </div>
                                        @endif

                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <form action="{{ route('devotees.store') }}" method="POST"
                                            enctype="multipart/form-data" class="devoteeform">
                                            @csrf
                                            <h4 class="mb-2">General Info</h4>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="firstname">First Name <span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            name="firstname" id="firstname" autocomplete="off"
                                                            value="{{ $devotee->firstname ?? '' }}" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="middlename">Middle Name</label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            name="middlename" id="middlename" autocomplete="off"
                                                            value="{{ $devotee->middlename ?? '' }}" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="surname">Surname <span class="required"></span></label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            name="surname" id="surname" autocomplete="off"
                                                            value="{{ $devotee->surname ?? '' }}" readonly />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="dobtype">Date of Birth Type</label>
                                                        <select class="form-control" name="dobtype" id="dobtype">
                                                            <option value="" disabled selected>Select One</option>
                                                            <option value="AD">AD</option>
                                                            <option value="BS">BS</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="dob">Date of Birth</label>
                                                        <input type="text" class="form-control" name="dobad"
                                                            id="dobad" autocomplete="off" />
                                                        <input type="text" class="form-control" name="dobbs"
                                                            id="dobbs" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="occupation">Occupation</label>
                                                        <select class="form-control" data-control="select2"
                                                            name="occupation" id="occupation">
                                                            <option value="">Select One</option>
                                                            @if ($occupations->count() != null)
                                                                @foreach ($occupations as $occupation)
                                                                    <option value="{{ $occupation->id }}">
                                                                        {{ $occupation->title }}</option>

                                                                    @if ($occupation->subcategory)
                                                                        @foreach ($occupation->subcategory as $child)
                                                                            <option value="{{ $child->id }}">
                                                                                &nbsp;&nbsp;-- {{ $child->title }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="gotra">Gotra</label>
                                                        <select class="form-control" data-control="select2"
                                                            name="initiationby" id="initiationby">
                                                            <option value="">Select One</option>
                                                            <option value="⁠Agasti">⁠Agasti</option>
                                                            <option value="⁠Angira">⁠Angira</option>
                                                            <option value="⁠Atri">⁠Atri</option>
                                                            <option value="⁠Aatreya">⁠Aatreya</option>
                                                            <option value="⁠Bharadwaaj">⁠Bharadwaaj</option>
                                                            <option value="⁠Dhananjaya">⁠Dhananjaya</option>
                                                            <option value="⁠Garg">⁠Garg</option>
                                                            <option value="⁠Gautam">⁠Gautam</option>
                                                            <option value="⁠Ghrita Kaushik">⁠Ghrita Kaushik</option>
                                                            <option value="⁠Kapil">⁠Kapil</option>
                                                            <option value="⁠Kashyap">⁠Kashyap</option>
                                                            <option value="⁠Kaudinya">⁠Kaudinya</option>
                                                            <option value="⁠Kausalya">⁠Kausalya</option>
                                                            <option value="⁠Kausik">⁠Kausik</option>
                                                            <option value="⁠Kundin">⁠Kundin</option>
                                                            <option value="⁠Mandabya">⁠Mandabya</option>
                                                            <option value="⁠Maudagalya">⁠Maudagalya</option>
                                                            <option value="⁠Parasar">⁠Parasar</option>
                                                            <option value="⁠Ravi">⁠Ravi</option>
                                                            <option value="⁠Sankhyayan">⁠Sankhyayan</option>
                                                            <option value="⁠Shandilya">⁠Shandilya</option>
                                                            <option value="⁠Upamanyu">⁠Upamanyu</option>
                                                            <option value="⁠Vishwamitra">⁠Vishwamitra</option>
                                                            <option value="⁠Vatsa">⁠Vatsa</option>
                                                            <option value="⁠Vashishta">⁠Vashishta</option>
                                                            <option value="⁠Adhigata (Dashnami Sanyasi)">⁠Adhigata
                                                                (Dashnami Sanyasi)</option>
                                                            <option value="⁠Kashyap (Dashnami Sanyasi)">⁠Kashyap (Dashnami
                                                                Sanyasi)</option>
                                                            <option value="⁠Bhaveswa (Dashnami Sanyasi)">⁠Bhaveswa
                                                                (Dashnami Sanyasi)</option>
                                                            <option value="⁠Bhrigu (Dashnami Sanyasi)">⁠Bhrigu (Dashnami
                                                                Sanyasi)</option>
                                                            <option value="Basista">Basista</option>
                                                            <option value="Sanil">Sanil</option>
                                                            <option value="Sandily">Sandily</option>
                                                            <option value="Man">Man</option>
                                                            <option value="Kaushila">Kaushila</option>
                                                            <option value="Bhagat">Bhagat</option>
                                                            <option value="Kundaliya">Kundaliya</option>
                                                            <option value="⁠Achyuta">⁠Achyuta</option>
                                                            <option value="Matkale">Matkale</option>
                                                            <option value="Bhiratri">Bhiratri</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control form-control-solid"
                                                            name="email" id="email" autocomplete="off"
                                                            value="{{ $devotee->email ?? '' }}" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-lg-2 mb-4">
                                                    <div class="form-group">
                                                        <label for="country_code">Country Code</label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            name="country_code" id="country_code" autocomplete="off"
                                                            value="{{ $devotee->countrycode ?? '' }}" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="mobile">Primary Phone (Mobile)</label>
                                                        <input type="number" class="form-control form-control-solid"
                                                            name="mobile" id="mobile" autocomplete="off"
                                                            value="{{ $devotee->mobile ?? '' }}" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="phone">Secondary Phone</label>
                                                        <input type="number" class="form-control" name="phone"
                                                            id="phone" autocomplete="off"
                                                            value="{{ old('phone', $edit->phone ?? '') }}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="bloodgroup">Blood Group</label>
                                                        <select class="form-control" name="bloodgroup" id="bloodgroup">
                                                            <option value="">Select One</option>
                                                            <option value="A+">A+</option>
                                                            <option value="A-">A-</option>
                                                            <option value="B+">B+</option>
                                                            <option value="B-">B-</option>
                                                            <option value="O+">O+</option>
                                                            <option value="O-">O-</option>
                                                            <option value="AB+">AB+</option>
                                                            <option value="AB-">AB-</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="gender">Gender</label>
                                                        <input type="text" class="form-control form-control-solid"
                                                            name="gender" id="gender" autocomplete="off"
                                                            value="{{ $devotee->gender ?? '' }}" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="education">Education</label>
                                                        <select class="form-control" name="education" id="education">
                                                            <option value="">Select One</option>
                                                            <option value="Literate">Literate</option>
                                                            <option value="Primary">Primary</option>
                                                            <option value="Upper Primary">Upper Primary</option>
                                                            <option value="Secondary">Secondary</option>
                                                            <option value="Higher Secondary">Higher Secondary</option>
                                                            <option value="District Level">District Level</option>
                                                            <option value="Vocational">Vocational</option>
                                                            <option value="SLC/SEE">SLC/SEE</option>
                                                            <option value="+2">+2</option>
                                                            <option value="Diploma">Diploma</option>
                                                            <option value="Bachelor">Bachelor</option>
                                                            <option value="Master">Master</option>
                                                            <option value="Doctorate(PHD)">Doctorate(PHD)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="mentor">Mentor</label>
                                                        <select class="form-control" data-control="select2"
                                                            name="mentor" id="mentor">
                                                            <option value="">Select One</option>
                                                            @if ($mentors->count() != null)
                                                                @foreach ($mentors as $mentor)
                                                                    <option value="{{ $mentor->id }}">
                                                                        @if ($mentor->getdevotee->firstname != null)
                                                                            {{ Crypt::decrypt($mentor->getdevotee->firstname) }}
                                                                        @endif
                                                                        @if ($mentor->getdevotee->middlename != null)
                                                                            {{ Crypt::decrypt($mentor->getdevotee->middlename) }}
                                                                        @endif
                                                                        @if ($mentor->getdevotee->surname != null)
                                                                            {{ Crypt::decrypt($mentor->getdevotee->surname) }}
                                                                        @endif
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="maritalstatus">Marital Status</label>
                                                        <select class="form-control" data-control="select2"
                                                            name="maritalstatus" id="maritalstatus">
                                                            <option value="">Select One</option>
                                                            <option value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                            <option value="Widowed">Widowed</option>
                                                            <option value="Divorced">Divorced</option>
                                                            <option value="Separated">Separated</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="mt-10 mb-5"><input type="checkbox"
                                                            class="form-check-input" value="1" id="lifemember"
                                                            name="lifemember" /> Life Member<br />
                                                    </div>
                                                </div>
                                            </div>

                                            <h4 class="mt-5">Identity Details</h4>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="nationality">Nationality</label>
                                                        <select class="form-control" name="nationality" id="nationality"
                                                            data-control="select2">
                                                            <option value="Afghan">Afghan</option>
                                                            <option value="Albanian">Albanian</option>
                                                            <option value="Algerian">Algerian</option>
                                                            <option value="American">American</option>
                                                            <option value="Andorran">Andorran</option>
                                                            <option value="Angolan">Angolan</option>
                                                            <option value="Antiguan">Antiguan</option>
                                                            <option value="Argentine">Argentine</option>
                                                            <option value="Armenian">Armenian</option>
                                                            <option value="Australian">Australian</option>
                                                            <option value="Austrian">Austrian</option>
                                                            <option value="Azerbaijani">Azerbaijani</option>
                                                            <option value="Bahamian">Bahamian</option>
                                                            <option value="Bahraini">Bahraini</option>
                                                            <option value="Bangladeshi">Bangladeshi</option>
                                                            <option value="Barbadian">Barbadian</option>
                                                            <option value="Belarusian">Belarusian</option>
                                                            <option value="Belgian">Belgian</option>
                                                            <option value="Belizean">Belizean</option>
                                                            <option value="Beninese">Beninese</option>
                                                            <option value="Bhutanese">Bhutanese</option>
                                                            <option value="Bolivian">Bolivian</option>
                                                            <option value="Bosnian">Bosnian</option>
                                                            <option value="Botswanan">Botswanan</option>
                                                            <option value="Brazilian">Brazilian</option>
                                                            <option value="British">British</option>
                                                            <option value="Bruneian">Bruneian</option>
                                                            <option value="Bulgarian">Bulgarian</option>
                                                            <option value="Burkinabe">Burkinabe</option>
                                                            <option value="Burmese">Burmese</option>
                                                            <option value="Burundian">Burundian</option>
                                                            <option value="Cambodian">Cambodian</option>
                                                            <option value="Cameroonian">Cameroonian</option>
                                                            <option value="Canadian">Canadian</option>
                                                            <option value="Cape Verdean">Cape Verdean</option>
                                                            <option value="Central African">Central African</option>
                                                            <option value="Chadian">Chadian</option>
                                                            <option value="Chilean">Chilean</option>
                                                            <option value="Chinese">Chinese</option>
                                                            <option value="Colombian">Colombian</option>
                                                            <option value="Comorian">Comorian</option>
                                                            <option value="Congolese">Congolese</option>
                                                            <option value="Costa Rican">Costa Rican</option>
                                                            <option value="Croatian">Croatian</option>
                                                            <option value="Cuban">Cuban</option>
                                                            <option value="Cypriot">Cypriot</option>
                                                            <option value="Czech">Czech</option>
                                                            <option value="Danish">Danish</option>
                                                            <option value="Djiboutian">Djiboutian</option>
                                                            <option value="Dominican">Dominican</option>
                                                            <option value="Dutch">Dutch</option>
                                                            <option value="East Timorese">East Timorese</option>
                                                            <option value="Ecuadorean">Ecuadorean</option>
                                                            <option value="Egyptian">Egyptian</option>
                                                            <option value="Emirati">Emirati</option>
                                                            <option value="Equatorial Guinean">Equatorial Guinean</option>
                                                            <option value="Eritrean">Eritrean</option>
                                                            <option value="Estonian">Estonian</option>
                                                            <option value="Ethiopian">Ethiopian</option>
                                                            <option value="Fijian">Fijian</option>
                                                            <option value="Finnish">Finnish</option>
                                                            <option value="French">French</option>
                                                            <option value="Gabonese">Gabonese</option>
                                                            <option value="Gambian">Gambian</option>
                                                            <option value="Georgian">Georgian</option>
                                                            <option value="German">German</option>
                                                            <option value="Ghanaian">Ghanaian</option>
                                                            <option value="Greek">Greek</option>
                                                            <option value="Grenadian">Grenadian</option>
                                                            <option value="Guatemalan">Guatemalan</option>
                                                            <option value="Guinean">Guinean</option>
                                                            <option value="Guyanese">Guyanese</option>
                                                            <option value="Haitian">Haitian</option>
                                                            <option value="Honduran">Honduran</option>
                                                            <option value="Hungarian">Hungarian</option>
                                                            <option value="Icelandic">Icelandic</option>
                                                            <option value="Indian">Indian</option>
                                                            <option value="Indonesian">Indonesian</option>
                                                            <option value="Iranian">Iranian</option>
                                                            <option value="Iraqi">Iraqi</option>
                                                            <option value="Irish">Irish</option>
                                                            <option value="Israeli">Israeli</option>
                                                            <option value="Italian">Italian</option>
                                                            <option value="Ivorian">Ivorian</option>
                                                            <option value="Jamaican">Jamaican</option>
                                                            <option value="Japanese">Japanese</option>
                                                            <option value="Jordanian">Jordanian</option>
                                                            <option value="Kazakh">Kazakh</option>
                                                            <option value="Kenyan">Kenyan</option>
                                                            <option value="Kiribati">Kiribati</option>
                                                            <option value="Kuwaiti">Kuwaiti</option>
                                                            <option value="Kyrgyz">Kyrgyz</option>
                                                            <option value="Laotian">Laotian</option>
                                                            <option value="Latvian">Latvian</option>
                                                            <option value="Lebanese">Lebanese</option>
                                                            <option value="Liberian">Liberian</option>
                                                            <option value="Libyan">Libyan</option>
                                                            <option value="Liechtenstein">Liechtenstein</option>
                                                            <option value="Lithuanian">Lithuanian</option>
                                                            <option value="Luxembourger">Luxembourger</option>
                                                            <option value="Macedonian">Macedonian</option>
                                                            <option value="Malagasy">Malagasy</option>
                                                            <option value="Malawian">Malawian</option>
                                                            <option value="Malaysian">Malaysian</option>
                                                            <option value="Maldivian">Maldivian</option>
                                                            <option value="Malian">Malian</option>
                                                            <option value="Maltese">Maltese</option>
                                                            <option value="Marshallese">Marshallese</option>
                                                            <option value="Mauritanian">Mauritanian</option>
                                                            <option value="Mauritian">Mauritian</option>
                                                            <option value="Mexican">Mexican</option>
                                                            <option value="Micronesian">Micronesian</option>
                                                            <option value="Moldovan">Moldovan</option>
                                                            <option value="Monegasque">Monegasque</option>
                                                            <option value="Mongolian">Mongolian</option>
                                                            <option value="Montenegrin">Montenegrin</option>
                                                            <option value="Moroccan">Moroccan</option>
                                                            <option value="Mozambican">Mozambican</option>
                                                            <option value="Namibian">Namibian</option>
                                                            <option value="Nauruan">Nauruan</option>
                                                            <option value="Nepalese" selected>Nepalese</option>
                                                            <option value="New Zealander">New Zealander</option>
                                                            <option value="Nicaraguan">Nicaraguan</option>
                                                            <option value="Nigerian">Nigerian</option>
                                                            <option value="Nigerien">Nigerien</option>
                                                            <option value="North Korean">North Korean</option>
                                                            <option value="Norwegian">Norwegian</option>
                                                            <option value="Omani">Omani</option>
                                                            <option value="Pakistani">Pakistani</option>
                                                            <option value="Palauan">Palauan</option>
                                                            <option value="Panamanian">Panamanian</option>
                                                            <option value="Papua New Guinean">Papua New Guinean</option>
                                                            <option value="Paraguayan">Paraguayan</option>
                                                            <option value="Peruvian">Peruvian</option>
                                                            <option value="Philippine">Philippine</option>
                                                            <option value="Polish">Polish</option>
                                                            <option value="Portuguese">Portuguese</option>
                                                            <option value="Qatari">Qatari</option>
                                                            <option value="Romanian">Romanian</option>
                                                            <option value="Russian">Russian</option>
                                                            <option value="Rwandan">Rwandan</option>
                                                            <option value="Saint Lucian">Saint Lucian</option>
                                                            <option value="Salvadoran">Salvadoran</option>
                                                            <option value="Samoan">Samoan</option>
                                                            <option value="San Marinese">San Marinese</option>
                                                            <option value="Sao Tomean">Sao Tomean</option>
                                                            <option value="Saudi">Saudi</option>
                                                            <option value="Senegalese">Senegalese</option>
                                                            <option value="Serbian">Serbian</option>
                                                            <option value="Seychellois">Seychellois</option>
                                                            <option value="Sierra Leonean">Sierra Leonean</option>
                                                            <option value="Singaporean">Singaporean</option>
                                                            <option value="Slovak">Slovak</option>
                                                            <option value="Slovenian">Slovenian</option>
                                                            <option value="Solomon Islander">Solomon Islander</option>
                                                            <option value="Somali">Somali</option>
                                                            <option value="South African">South African</option>
                                                            <option value="South Korean">South Korean</option>
                                                            <option value="South Sudanese">South Sudanese</option>
                                                            <option value="Spanish">Spanish</option>
                                                            <option value="Sri Lankan">Sri Lankan</option>
                                                            <option value="Sudanese">Sudanese</option>
                                                            <option value="Surinamer">Surinamer</option>
                                                            <option value="Swazi">Swazi</option>
                                                            <option value="Swedish">Swedish</option>
                                                            <option value="Swiss">Swiss</option>
                                                            <option value="Syrian">Syrian</option>
                                                            <option value="Taiwanese">Taiwanese</option>
                                                            <option value="Tajik">Tajik</option>
                                                            <option value="Tanzanian">Tanzanian</option>
                                                            <option value="Thai">Thai</option>
                                                            <option value="Togolese">Togolese</option>
                                                            <option value="Tongan">Tongan</option>
                                                            <option value="Trinidadian">Trinidadian</option>
                                                            <option value="Tunisian">Tunisian</option>
                                                            <option value="Turkish">Turkish</option>
                                                            <option value="Turkmen">Turkmen</option>
                                                            <option value="Tuvaluan">Tuvaluan</option>
                                                            <option value="Ugandan">Ugandan</option>
                                                            <option value="Ukrainian">Ukrainian</option>
                                                            <option value="Uruguayan">Uruguayan</option>
                                                            <option value="Uzbek">Uzbek</option>
                                                            <option value="Vanuatuan">Vanuatuan</option>
                                                            <option value="Venezuelan">Venezuelan</option>
                                                            <option value="Vietnamese">Vietnamese</option>
                                                            <option value="Yemeni">Yemeni</option>
                                                            <option value="Zambian">Zambian</option>
                                                            <option value="Zimbabwean">Zimbabwean</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="identitytype">Identity Type</label>
                                                        <select class="form-control" name="identitytype"
                                                            id="identitytype">
                                                            <option value="">Select One</option>
                                                            <option value="Birth Certificate">Birth Certificate</option>
                                                            <option value="License">License</option>
                                                            <option value="National ID">National ID</option>
                                                            <option value="Citizenship">Citizenship</option>
                                                            <option value="Passport">Passport</option>
                                                            <option value="Vote Card">Vote Card</option>
                                                            <option value="Student Card">Student Card</option>
                                                            <option value="Profession Card">Profession Card</option>
                                                            <option value="Iskcon Card">Iskcon Card</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="identityno">Identity No</label>
                                                        <input type="text" class="form-control" name="identityno"
                                                            id="identityno" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="identityimage">Identity Image</label>
                                                        <input type="file" class="form-control" name="identityimage"
                                                            id="identityimage" autocomplete="off" />
                                                    </div>
                                                </div>
                                            </div>


                                            <h4>Permanent Address</h4>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="province">Province</label>
                                                        <select class="form-control" name="province" id="province">
                                                            <option value="">Select Province</option>
                                                            @foreach ($provincesData as $province)
                                                                <option value="{{ $province->id }}">
                                                                    {{ $province->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="pdistrict">District</label>
                                                        <select class="form-control" name="pdistrict" id="district">
                                                            <option value="">Select District</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="pmuni">Rural / Urban Municipality</label>
                                                        <select class="form-control" name="pmuni" id="category">
                                                            @foreach ($categoriesdata as $category)
                                                                <option value="{{ $category->name }}">
                                                                    {{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-lg-8 mb-8">
                                                    <div class="form-group">
                                                        <label for="ptole">Municipality</label>
                                                        <select class="form-control" name="ptole" id="municipalities">
                                                            <option value="">Select Municipality</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="pwardno">Ward No</label>
                                                        <input type="text" class="form-control"
                                                            name="pwardno"id="ward" autocomplete="off" value=""
                                                            min="0" max="99" maxlength="2"
                                                            oninput="if(this.value.length > 2) this.value = this.value.slice(0,2);">
                                                    </div>
                                                </div>
                                            </div>



                                            <h4>Temporary Address</h4>

                                            <div class="mt-5 mb-5"><input type="checkbox" class="form-check-input"
                                                    id="filladdress" name="filladdress" /> Same as Permanent Address<br />
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="tprovince">Province</label>
                                                        <select class="form-control" name="tprovince" id="tprovince">
                                                            <option value="">Select Province</option>
                                                            @foreach ($provincesData as $province)
                                                                <option value="{{ $province->id }}">
                                                                    {{ $province->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="tdistrict">District</label>
                                                        <select class="form-control" name="tdistrict" id="tdistrict">
                                                            <option value="">Select District</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="tmuni">Rural / Urban Municipality</label>
                                                        <select class="form-control" name="tmuni" id="tcategory">
                                                            @foreach ($categoriesdata as $category)
                                                                <option value="{{ $category->id }}">
                                                                    {{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-lg-8 mb-8">
                                                    <div class="form-group">
                                                        <label for="ttmuni">Municipality</label>
                                                        <select class="form-control" name="ttole" id="ttole">
                                                            <option value="">Select Municipality</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="twardno">Ward No</label>
                                                        <input type="text" class="form-control" name="twardno"
                                                            id="twardno" autocomplete="off" value=""
                                                            min="0" max="99" maxlength="2"
                                                            oninput="if(this.value.length > 2) this.value = this.value.slice(0,2);">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                                    <button type="submit"
                                                        class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create
                                                        Devotee</button>
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.copyrights')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('nepalidate/nepali.datepicker.v4.0.5.min.js') }}"></script>
    @php
        $today = date('Y-m-d');
        $nextdate = date('Y-m-d', strtotime('+5 year'));
    @endphp
    <script type="text/javascript">
        $(document).ready(function() {
            $("#dobad").flatpickr({
                dateFormat: "Y-m-d",
                disable: [{
                    from: '{{ $today }}',
                    to: '{{ $nextdate }}'
                }]
            });
        });
        document.addEventListener('DOMContentLoaded', (event) => {
            const fillAddressCheckbox = document.getElementById('filladdress');
            const tprovince = document.getElementById('tprovince');
            const tdistrict = document.getElementById('tdistrict');
            const tcategory = document.getElementById('tcategory');
            const tmunicipalities = document.getElementById('tmunicipalities');
            const twardno = document.getElementById('twardno');

            function toggleTemporaryAddressFields(disable) {
                tprovince.disabled = disable;
                tdistrict.disabled = disable;
                tcategory.disabled = disable;
                tmunicipalities.disabled = disable;
                twardno.disabled = disable;
            }

            fillAddressCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // Copy values from permanent address fields to temporary address fields
                    tprovince.value = document.getElementById('province').value;
                    // Trigger change event for the province select box
                    tprovince.dispatchEvent(new Event('change'));

                    setTimeout(() => {
                        tdistrict.value = document.getElementById('district').value;
                        tdistrict.dispatchEvent(new Event('change'));

                        setTimeout(() => {
                            tcategory.value = document.getElementById('category').value;
                            tcategory.dispatchEvent(new Event('change'));

                            setTimeout(() => {
                                tmunicipalities.value = document.getElementById(
                                    'municipalities').value;
                            }, 500); // Adjust the delay as needed
                        }, 500); // Adjust the delay as needed
                    }, 500); // Adjust the delay as needed

                    twardno.value = document.getElementById('ward').value;

                    // Disable temporary address fields
                    toggleTemporaryAddressFields(true);
                } else {
                    // Clear temporary address fields
                    tprovince.value = '';
                    tdistrict.value = '';
                    tcategory.value = '';
                    tmunicipalities.value = '';
                    twardno.value = '';

                    // Enable temporary address fields
                    toggleTemporaryAddressFields(false);
                }
            });
        });
    </script>

    <script>
        var provincesData = @json($provincesData);
        var categoriesData = @json($categoriesdata);

        $(document).ready(function() {
            $('#province').on('change', function() {
                var provinceId = $(this).val();
                $('#district').empty().append('<option value="">Select District</option>');
                $('#municipalities').empty().append('<option value="">Select Municipality</option>');
                $('#ward').val('');

                if (provinceId) {
                    var districts = provincesData.find(province => province.id == provinceId).districts;
                    populateDropdown('#district', districts);
                }
            });

            $('#district').on('change', function() {
                var districtId = $(this).val();
                $('#municipalities').empty().append('<option value="">Select Municipality</option>');
                $('#ward').val('');

                if (districtId) {
                    var district = provincesData.flatMap(province => province.districts)
                        .find(district => district.id == districtId);
                    // Optionally, you can pre-select the Category dropdown here
                    populateDropdown('#category', categoriesData, 'id', 'name', district.category_id);
                }
            });

            $('#category').on('change', function() {
                var categoryId = $(this).val();
                $('#municipalities').empty().append('<option value="">Select Municipality</option>');
                $('#ward').val('');

                if (categoryId) {
                    var districtId = $('#district').val();
                    var district = provincesData.flatMap(province => province.districts)
                        .find(district => district.id == districtId);
                    var municipalities = district.municipalities.filter(municipality => municipality
                        .category_id == categoryId);
                    populateDropdown('#municipalities', municipalities, 'id', 'name');
                }
            });



            // Function to populate dropdown based on data
            function populateDropdown(selector, data, valueField = 'id', textField = 'name', selectedValue = null) {
                var dropdown = $(selector);
                dropdown.empty().append('<option value="">Select</option>');
                data.forEach(function(item) {
                    if (item[valueField] == selectedValue) {
                        dropdown.append('<option value="' + item[valueField] + '" selected>' + item[
                            textField] + '</option>');
                    } else {
                        dropdown.append('<option value="' + item[valueField] + '">' + item[textField] +
                            '</option>');
                    }
                });
            }
        });
    </script>
    <script>
        var provincesData = @json($provincesData);
        var categoriesData = @json($categoriesdata);

        $(document).ready(function() {
            $('#tprovince').on('change', function() {
                var provinceId = $(this).val();
                $('#tdistrict').empty().append('<option value="">Select District</option>');
                $('#tmunicipalities').empty().append('<option value="">Select Municipality</option>');
                $('#tward').val('');

                if (provinceId) {
                    var districts = provincesData.find(province => province.id == provinceId).districts;
                    populateDropdown('#tdistrict', districts);
                }
            });

            $('#tdistrict').on('change', function() {
                var districtId = $(this).val();
                $('#tmunicipalities').empty().append('<option value="">Select Municipality</option>');
                $('#tward').val('');

                if (districtId) {
                    var district = provincesData.flatMap(province => province.districts)
                        .find(district => district.id == districtId);
                    // Optionally, you can pre-select the Category dropdown here
                    populateDropdown('#tcategory', categoriesData, 'id', 'name', district.category_id);
                }
            });

            $('#tcategory').on('change', function() {
                var categoryId = $(this).val();
                $('#tmunicipalities').empty().append('<option value="">Select Municipality</option>');
                $('#tward').val('');

                if (categoryId) {
                    var districtId = $('#tdistrict').val();
                    var district = provincesData.flatMap(province => province.districts)
                        .find(district => district.id == districtId);
                    var municipalities = district.municipalities.filter(municipality => municipality
                        .category_id == categoryId);
                    populateDropdown('#tmunicipalities', municipalities, 'id', 'name');
                }
            });

            $('#tmunicipalities').on('change', function() {
                var municipalityId = $(this).val();
                $('#tward').val('');

                if (municipalityId) {
                    var municipality = $('#municipalities option:selected').text();
                    $('#tward').val(municipality);
                }
            });

            // Function to populate dropdown based on data
            function populateDropdown(selector, data, valueField = 'id', textField = 'name', selectedValue = null) {
                var dropdown = $(selector);
                dropdown.empty().append('<option value="">Select</option>');
                data.forEach(function(item) {
                    if (item[valueField] == selectedValue) {
                        dropdown.append('<option value="' + item[valueField] + '" selected>' + item[
                            textField] + '</option>');
                    } else {
                        dropdown.append('<option value="' + item[valueField] + '">' + item[textField] +
                            '</option>');
                    }
                });
            }

        });
    </script>
    <script type="text/javascript">
        /* Select your element */
        var elm = document.getElementById("dobbs");

        /* Initialize Datepicker with options */
        elm.nepaliDatePicker({
            ndpYear: true,
            ndpMonth: true
        });
    </script>

    <script type="text/javascript">
        $('#dobtype').on('change', function() {
            if ((this.value == 'AD')) {
                $("#dobad").show();
                $("#dobbs").hide();
            }
            if ((this.value == 'BS')) {
                $("#dobbs").show();
                $("#dobad").hide();
            }
        });
        $("#dobad").hide();
        $("#dobbs").hide();
    </script>
@endsection
