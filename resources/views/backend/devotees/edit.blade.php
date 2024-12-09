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
                                    @if (isset($edit))
                                        Edit
                                    @else
                                        Add
                                    @endif Devotee
                                </h1>
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
                                        <form action="{{ route('devotees.update', $edit->id) }}" method="POST" enctype="multipart/form-data" class="devoteeform">
                                                @method('PUT')
                                        @csrf
                                        <h4 class="mb-2">General Info</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                <div class="form-group">
                                                    <label for="firstname">First Name <span class="required"></span></label>
                                                    <input type="text" class="form-control" name="firstname"
                                                        id="firstname" autocomplete="off" value="@if($edit->firstname != NULL){{Crypt::decrypt($edit->firstname)}}@endif" required />
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                <div class="form-group">
                                                    <label for="middlename">Middle Name</label>
                                                    <input type="text" class="form-control" name="middlename"
                                                        id="middlename" autocomplete="off" value="@if($edit->middlename != NULL){{Crypt::decrypt($edit->middlename)}}@endif" />
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                <div class="form-group">
                                                    <label for="surname">Surname <span class="required"></span></label>
                                                    <input type="text" class="form-control" name="surname" id="surname" autocomplete="off"
                                                        value="@if($edit->surname != NULL){{Crypt::decrypt($edit->surname)}}@endif" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                <div class="form-group">
                                                    <label for="dobtype">Date of Birth Type</label>
                                                    <select class="form-control" name="dobtype" id="dobtype">
                                                        <option value="" disabled selected>Select One</option>
                                                        <option value="AD" {{ $edit->dobtype == 'AD' ? 'selected' : '' }}>AD</option>
                                                        <option value="BS" {{ $edit->dobtype == 'BS' ? 'selected' : '' }}>BS</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                <div class="form-group">
                                                    <label for="dob">Date of Birth</label>
                                                    <input type="text" class="form-control" name="dobad" id="dobad" value="@if($edit->dob != NULL){{Crypt::decrypt($edit->dob)}}@endif" autocomplete="off" />
                                                    <input type="text" class="form-control" name="dobbs" id="dobbs" value="@if($edit->dob != NULL){{Crypt::decrypt($edit->dob)}}@endif" autocomplete="off" />
                                                    <input type="text" class="form-control" name="dobdefault" id="dobdefault" value="@if($edit->dob != NULL){{Crypt::decrypt($edit->dob)}}@endif" autocomplete="off" readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                <div class="form-group">
                                                    <label for="occupation">Occupation</label>
                                                    <select class="form-select" data-control="select2" name="occupation" id="occupation">
                                                      <option value="">Select One</option>
                                                      @if($occupations->count() != NULL)
                                                        @foreach($occupations as $occupation)
                                                          <option value="{{$occupation->id}}" {{ $edit->occupations == $occupation->id ? 'selected' : '' }}>{{$occupation->title}}</option>

                                                          @if ($occupation->subcategory)
                                                              @foreach ($occupation->subcategory as $child)
                                                                  <option value="{{ $child->id }}" {{ $edit->occupations == $child->id ? 'selected' : '' }}>&nbsp;&nbsp;-- {{ $child->title }}</option>
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
                                                    <select class="form-select" data-control="select2" name="gotra" id="gotra">
                                                      <option value="">Select One</option>
                                                      <option value="⁠Agasti" {{ $edit->gotra == '⁠Agasti' ? 'selected' : '' }}>⁠Agasti</option>
                                                      <option value="⁠Angira" {{ $edit->gotra == '⁠Angira' ? 'selected' : '' }}>⁠Angira</option>
                                                      <option value="⁠Atri" {{ $edit->gotra == '⁠Atri' ? 'selected' : '' }}>⁠Atri</option>
                                                      <option value="⁠Aatreya" {{ $edit->gotra == '⁠Aatreya' ? 'selected' : '' }}>⁠Aatreya</option>
                                                      <option value="⁠Bharadwaaj" {{ $edit->gotra == '⁠Bharadwaaj' ? 'selected' : '' }}>⁠Bharadwaaj</option>
                                                      <option value="⁠Dhananjaya" {{ $edit->gotra == '⁠Dhananjaya' ? 'selected' : '' }}>⁠Dhananjaya</option>
                                                      <option value="⁠Garg" {{ $edit->gotra == '⁠Garg' ? 'selected' : '' }}>⁠Garg</option>
                                                      <option value="⁠Gautam" {{ $edit->gotra == '⁠Gautam' ? 'selected' : '' }}>⁠Gautam</option>
                                                      <option value="⁠Ghrita Kaushik" {{ $edit->gotra == 'Ghrita Kaushik' ? 'selected' : '' }}>⁠Ghrita Kaushik</option>
                                                      <option value="⁠Kapil" {{ $edit->gotra == '⁠Kapil' ? 'selected' : '' }}>⁠Kapil</option>
                                                      <option value="⁠Kashyap" {{ $edit->gotra == '⁠Kashyap' ? 'selected' : '' }}>⁠Kashyap</option>
                                                      <option value="⁠Kaudinya" {{ $edit->gotra == '⁠Kaudinya' ? 'selected' : '' }}>⁠Kaudinya</option>
                                                      <option value="⁠Kausalya" {{ $edit->gotra == '⁠Kausalya' ? 'selected' : '' }}>⁠Kausalya</option>
                                                      <option value="⁠Kausik" {{ $edit->gotra == '⁠Kausik' ? 'selected' : '' }}>⁠Kausik</option>
                                                      <option value="⁠Kundin" {{ $edit->gotra == '⁠Kundin' ? 'selected' : '' }}>⁠Kundin</option>
                                                      <option value="⁠Mandabya" {{ $edit->gotra == '⁠Mandabya' ? 'selected' : '' }}>⁠Mandabya</option>
                                                      <option value="⁠Maudagalya" {{ $edit->gotra == '⁠Maudagalya' ? 'selected' : '' }}>⁠Maudagalya</option>
                                                      <option value="⁠Parasar" {{ $edit->gotra == '⁠Parasar' ? 'selected' : '' }}>⁠Parasar</option>
                                                      <option value="⁠Ravi" {{ $edit->gotra == '⁠Ravi' ? 'selected' : '' }}>⁠Ravi</option>
                                                      <option value="⁠Sankhyayan" {{ $edit->gotra == '⁠Sankhyayan' ? 'selected' : '' }}>⁠Sankhyayan</option>
                                                      <option value="⁠Shandilya" {{ $edit->gotra == '⁠Shandilya' ? 'selected' : '' }}>⁠Shandilya</option>
                                                      <option value="⁠Upamanyu" {{ $edit->gotra == '⁠Upamanyu' ? 'selected' : '' }}>⁠Upamanyu</option>
                                                      <option value="⁠Vishwamitra" {{ $edit->gotra == '⁠Vishwamitra' ? 'selected' : '' }}>⁠Vishwamitra</option>
                                                      <option value="⁠Vatsa" {{ $edit->gotra == '⁠Vatsa' ? 'selected' : '' }}>⁠Vatsa</option>
                                                      <option value="⁠Vashishta" {{ $edit->gotra == '⁠Vashishta' ? 'selected' : '' }}>⁠Vashishta</option>
                                                      <option value="⁠Adhigata (Dashnami Sanyasi)" {{ $edit->gotra == '⁠Adhigata (Dashnami Sanyasi)' ? 'selected' : '' }}>⁠Adhigata (Dashnami Sanyasi)</option>
                                                      <option value="⁠Kashyap (Dashnami Sanyasi)" {{ $edit->gotra == '⁠Kashyap (Dashnami Sanyasi)' ? 'selected' : '' }}>⁠Kashyap (Dashnami Sanyasi)</option>
                                                      <option value="⁠Bhaveswa (Dashnami Sanyasi)" {{ $edit->gotra == '⁠Bhaveswa (Dashnami Sanyasi)' ? 'selected' : '' }}>⁠Bhaveswa (Dashnami Sanyasi)</option>
                                                      <option value="⁠Bhrigu (Dashnami Sanyasi)" {{ $edit->gotra == '⁠Bhrigu (Dashnami Sanyasi)' ? 'selected' : '' }}>⁠Bhrigu (Dashnami Sanyasi)</option>
                                                      <option value="Basista" {{ $edit->gotra == 'Basista' ? 'selected' : '' }}>Basista</option>
                                                      <option value="Sanil" {{ $edit->gotra == 'Sanil' ? 'selected' : '' }}>Sanil</option>
                                                      <option value="Sandily" {{ $edit->gotra == 'Sandily' ? 'selected' : '' }}>Sandily</option>
                                                      <option value="Man" {{ $edit->gotra == 'Man' ? 'selected' : '' }}>Man</option>
                                                      <option value="Kaushila" {{ $edit->gotra == 'Kaushila' ? 'selected' : '' }}>Kaushila</option>
                                                      <option value="Bhagat" {{ $edit->gotra == 'Bhagat' ? 'selected' : '' }}>Bhagat</option>
                                                      <option value="Kundaliya" {{ $edit->gotra == 'Kundaliya' ? 'selected' : '' }}>Kundaliya</option>
                                                      <option value="⁠Achyuta" {{ $edit->gotra == '⁠Achyuta' ? 'selected' : '' }}>⁠Achyuta</option>
                                                      <option value="Matkale" {{ $edit->gotra == 'Matkale' ? 'selected' : '' }}>Matkale</option>
                                                      <option value="Bhiratri" {{ $edit->gotra == 'Bhiratri' ? 'selected' : '' }}>Bhiratri</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                        id="email" autocomplete="off" value="@if($edit->email_enc != NULL){{Crypt::decrypt($edit->email_enc)}}@endif" />
                                                </div>
                                                <small id="result" class="form-text "></small>
                                                <p id="result"></p>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                <div class="form-group">
                                                    <label for="c">Country Code</label>
                                                    <select name="countrycode" class="form-select" data-control="select2">
                                                      <option value="" disabled selected>Select country code</option>
                                                      <option value="+93" {{ $edit->countrycode == '+93' ? 'selected' : '' }}>Afghanistan (+93)</option>
                                                      <option value="+355" {{ $edit->countrycode == '+355' ? 'selected' : '' }}>Albania (+355)</option>
                                                      <option value="+213" {{ $edit->countrycode == '+213' ? 'selected' : '' }}>Algeria (+213)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>American Samoa (+1)</option>
                                                      <option value="+376" {{ $edit->countrycode == '+376' ? 'selected' : '' }}>Andorra (+376)</option>
                                                      <option value="+244" {{ $edit->countrycode == '+244' ? 'selected' : '' }}>Angola (+244)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Anguilla (+1)</option>
                                                      <option value="+672" {{ $edit->countrycode == '+672' ? 'selected' : '' }}>Antarctica (+672)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Antigua and Barbuda (+1)</option>
                                                      <option value="+54" {{ $edit->countrycode == '+54' ? 'selected' : '' }}>Argentina (+54)</option>
                                                      <option value="+374" {{ $edit->countrycode == '+374' ? 'selected' : '' }}>Armenia (+374)</option>
                                                      <option value="+297" {{ $edit->countrycode == '+297' ? 'selected' : '' }}>Aruba (+297)</option>
                                                      <option value="+61" {{ $edit->countrycode == '+61' ? 'selected' : '' }}>Australia (+61)</option>
                                                      <option value="+43" {{ $edit->countrycode == '+43' ? 'selected' : '' }}>Austria (+43)</option>
                                                      <option value="+994" {{ $edit->countrycode == '+994' ? 'selected' : '' }}>Azerbaijan (+994)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Bahamas (+1)</option>
                                                      <option value="+973" {{ $edit->countrycode == '+973' ? 'selected' : '' }}>Bahrain (+973)</option>
                                                      <option value="+880" {{ $edit->countrycode == '+880' ? 'selected' : '' }}>Bangladesh (+880)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Barbados (+1)</option>
                                                      <option value="+375" {{ $edit->countrycode == '+375' ? 'selected' : '' }}>Belarus (+375)</option>
                                                      <option value="+32" {{ $edit->countrycode == '+32' ? 'selected' : '' }}>Belgium (+32)</option>
                                                      <option value="+501" {{ $edit->countrycode == '+501' ? 'selected' : '' }}>Belize (+501)</option>
                                                      <option value="+229" {{ $edit->countrycode == '+229' ? 'selected' : '' }}>Benin (+229)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Bermuda (+1)</option>
                                                      <option value="+975" {{ $edit->countrycode == '+975' ? 'selected' : '' }}>Bhutan (+975)</option>
                                                      <option value="+591" {{ $edit->countrycode == '+591' ? 'selected' : '' }}>Bolivia (+591)</option>
                                                      <option value="+387" {{ $edit->countrycode == '+387' ? 'selected' : '' }}>Bosnia and Herzegovina (+387)</option>
                                                      <option value="+267" {{ $edit->countrycode == '+267' ? 'selected' : '' }}>Botswana (+267)</option>
                                                      <option value="+55" {{ $edit->countrycode == '+55' ? 'selected' : '' }}>Brazil (+55)</option>
                                                      <option value="+246" {{ $edit->countrycode == '+246' ? 'selected' : '' }}>British Indian Ocean Territory (+246)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>British Virgin Islands (+1)</option>
                                                      <option value="+673" {{ $edit->countrycode == '+673' ? 'selected' : '' }}>Brunei (+673)</option>
                                                      <option value="+359" {{ $edit->countrycode == '+359' ? 'selected' : '' }}>Bulgaria (+359)</option>
                                                      <option value="+226" {{ $edit->countrycode == '+226' ? 'selected' : '' }}>Burkina Faso (+226)</option>
                                                      <option value="+257" {{ $edit->countrycode == '+257' ? 'selected' : '' }}>Burundi (+257)</option>
                                                      <option value="+855" {{ $edit->countrycode == '+855' ? 'selected' : '' }}>Cambodia (+855)</option>
                                                      <option value="+237" {{ $edit->countrycode == '+237' ? 'selected' : '' }}>Cameroon (+237)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Canada (+1)</option>
                                                      <option value="+238" {{ $edit->countrycode == '+238' ? 'selected' : '' }}>Cape Verde (+238)</option>
                                                      <option value="+345" {{ $edit->countrycode == '+345' ? 'selected' : '' }}>Cayman Islands (+345)</option>
                                                      <option value="+236" {{ $edit->countrycode == '+236' ? 'selected' : '' }}>Central African Republic (+236)</option>
                                                      <option value="+235" {{ $edit->countrycode == '+235' ? 'selected' : '' }}>Chad (+235)</option>
                                                      <option value="+56" {{ $edit->countrycode == '+56' ? 'selected' : '' }}>Chile (+56)</option>
                                                      <option value="+86" {{ $edit->countrycode == '+86' ? 'selected' : '' }}>China (+86)</option>
                                                      <option value="+61" {{ $edit->countrycode == '+61' ? 'selected' : '' }}>Christmas Island (+61)</option>
                                                      <option value="+61" {{ $edit->countrycode == '+61' ? 'selected' : '' }}>Cocos (Keeling) Islands (+61)</option>
                                                      <option value="+57" {{ $edit->countrycode == '+57' ? 'selected' : '' }}>Colombia (+57)</option>
                                                      <option value="+269" {{ $edit->countrycode == '+269' ? 'selected' : '' }}>Comoros (+269)</option>
                                                      <option value="+242" {{ $edit->countrycode == '+242' ? 'selected' : '' }}>Congo (+242)</option>
                                                      <option value="+243" {{ $edit->countrycode == '+243' ? 'selected' : '' }}>Congo, Democratic Republic of the (+243)</option>
                                                      <option value="+682" {{ $edit->countrycode == '+682' ? 'selected' : '' }}>Cook Islands (+682)</option>
                                                      <option value="+506" {{ $edit->countrycode == '+506' ? 'selected' : '' }}>Costa Rica (+506)</option>
                                                      <option value="+225" {{ $edit->countrycode == '+225' ? 'selected' : '' }}>Côte d'Ivoire (+225)</option>
                                                      <option value="+385" {{ $edit->countrycode == '+385' ? 'selected' : '' }}>Croatia (+385)</option>
                                                      <option value="+53" {{ $edit->countrycode == '+53' ? 'selected' : '' }}>Cuba (+53)</option>
                                                      <option value="+599" {{ $edit->countrycode == '+599' ? 'selected' : '' }}>Curaçao (+599)</option>
                                                      <option value="+357" {{ $edit->countrycode == '+357' ? 'selected' : '' }}>Cyprus (+357)</option>
                                                      <option value="+420" {{ $edit->countrycode == '+420' ? 'selected' : '' }}>Czech Republic (+420)</option>
                                                      <option value="+45" {{ $edit->countrycode == '+45' ? 'selected' : '' }}>Denmark (+45)</option>
                                                      <option value="+253" {{ $edit->countrycode == '+253' ? 'selected' : '' }}>Djibouti (+253)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Dominica (+1)</option>
                                                      <option value="+1809" {{ $edit->countrycode == '+1809' ? 'selected' : '' }}>Dominican Republic (+1809)</option>
                                                      <option value="+670" {{ $edit->countrycode == '+670' ? 'selected' : '' }}>East Timor (+670)</option>
                                                      <option value="+593" {{ $edit->countrycode == '+593' ? 'selected' : '' }}>Ecuador (+593)</option>
                                                      <option value="+20" {{ $edit->countrycode == '+20' ? 'selected' : '' }}>Egypt (+20)</option>
                                                      <option value="+503" {{ $edit->countrycode == '+503' ? 'selected' : '' }}>El Salvador (+503)</option>
                                                      <option value="+240" {{ $edit->countrycode == '+240' ? 'selected' : '' }}>Equatorial Guinea (+240)</option>
                                                      <option value="+291" {{ $edit->countrycode == '+291' ? 'selected' : '' }}>Eritrea (+291)</option>
                                                      <option value="+372" {{ $edit->countrycode == '+372' ? 'selected' : '' }}>Estonia (+372)</option>
                                                      <option value="+251" {{ $edit->countrycode == '+251' ? 'selected' : '' }}>Ethiopia (+251)</option>
                                                      <option value="+500" {{ $edit->countrycode == '+500' ? 'selected' : '' }}>Falkland Islands (+500)</option>
                                                      <option value="+298" {{ $edit->countrycode == '+298' ? 'selected' : '' }}>Faroe Islands (+298)</option>
                                                      <option value="+679" {{ $edit->countrycode == '+679' ? 'selected' : '' }}>Fiji (+679)</option>
                                                      <option value="+358" {{ $edit->countrycode == '+358' ? 'selected' : '' }}>Finland (+358)</option>
                                                      <option value="+33" {{ $edit->countrycode == '+33' ? 'selected' : '' }}>France (+33)</option>
                                                      <option value="+594" {{ $edit->countrycode == '+594' ? 'selected' : '' }}>French Guiana (+594)</option>
                                                      <option value="+689" {{ $edit->countrycode == '+689' ? 'selected' : '' }}>French Polynesia (+689)</option>
                                                      <option value="+241" {{ $edit->countrycode == '+241' ? 'selected' : '' }}>Gabon (+241)</option>
                                                      <option value="+220" {{ $edit->countrycode == '+220' ? 'selected' : '' }}>Gambia (+220)</option>
                                                      <option value="+995" {{ $edit->countrycode == '+995' ? 'selected' : '' }}>Georgia (+995)</option>
                                                      <option value="+49" {{ $edit->countrycode == '+49' ? 'selected' : '' }}>Germany (+49)</option>
                                                      <option value="+233" {{ $edit->countrycode == '+233' ? 'selected' : '' }}>Ghana (+233)</option>
                                                      <option value="+350" {{ $edit->countrycode == '+350' ? 'selected' : '' }}>Gibraltar (+350)</option>
                                                      <option value="+30" {{ $edit->countrycode == '+30' ? 'selected' : '' }}>Greece (+30)</option>
                                                      <option value="+299" {{ $edit->countrycode == '+299' ? 'selected' : '' }}>Greenland (+299)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Grenada (+1)</option>
                                                      <option value="+590" {{ $edit->countrycode == '+590' ? 'selected' : '' }}>Guadeloupe (+590)</option>
                                                      <option value="+591" {{ $edit->countrycode == '+591' ? 'selected' : '' }}>Guam (+1)</option>
                                                      <option value="+595" {{ $edit->countrycode == '+595' ? 'selected' : '' }}>Guatemala (+595)</option>
                                                      <option value="+224" {{ $edit->countrycode == '+224' ? 'selected' : '' }}>Guinea (+224)</option>
                                                      <option value="+245" {{ $edit->countrycode == '+245' ? 'selected' : '' }}>Guinea-Bissau (+245)</option>
                                                      <option value="+592" {{ $edit->countrycode == '+592' ? 'selected' : '' }}>Guyana (+592)</option>
                                                      <option value="+509" {{ $edit->countrycode == '+509' ? 'selected' : '' }}>Haiti (+509)</option>
                                                      <option value="+504" {{ $edit->countrycode == '+504' ? 'selected' : '' }}>Honduras (+504)</option>
                                                      <option value="+852" {{ $edit->countrycode == '+852' ? 'selected' : '' }}>Hong Kong (+852)</option>
                                                      <option value="+36" {{ $edit->countrycode == '+36' ? 'selected' : '' }}>Hungary (+36)</option>
                                                      <option value="+354" {{ $edit->countrycode == '+354' ? 'selected' : '' }}>Iceland (+354)</option>
                                                      <option value="+91" {{ $edit->countrycode == '+91' ? 'selected' : '' }}>India (+91)</option>
                                                      <option value="+62" {{ $edit->countrycode == '+62' ? 'selected' : '' }}>Indonesia (+62)</option>
                                                      <option value="+98" {{ $edit->countrycode == '+98' ? 'selected' : '' }}>Iran (+98)</option>
                                                      <option value="+964" {{ $edit->countrycode == '+964' ? 'selected' : '' }}>Iraq (+964)</option>
                                                      <option value="+353" {{ $edit->countrycode == '+353' ? 'selected' : '' }}>Ireland (+353)</option>
                                                      <option value="+972" {{ $edit->countrycode == '+972' ? 'selected' : '' }}>Israel (+972)</option>
                                                      <option value="+39" {{ $edit->countrycode == '+39' ? 'selected' : '' }}>Italy (+39)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Jamaica (+1)</option>
                                                      <option value="+81" {{ $edit->countrycode == '+81' ? 'selected' : '' }}>Japan (+81)</option>
                                                      <option value="+962" {{ $edit->countrycode == '+962' ? 'selected' : '' }}>Jordan (+962)</option>
                                                      <option value="+7" {{ $edit->countrycode == '+7' ? 'selected' : '' }}>Kazakhstan (+7)</option>
                                                      <option value="+254" {{ $edit->countrycode == '+254' ? 'selected' : '' }}>Kenya (+254)</option>
                                                      <option value="+686" {{ $edit->countrycode == '+686' ? 'selected' : '' }}>Kiribati (+686)</option>
                                                      <option value="+965" {{ $edit->countrycode == '+965' ? 'selected' : '' }}>Kuwait (+965)</option>
                                                      <option value="+996" {{ $edit->countrycode == '+996' ? 'selected' : '' }}>Kyrgyzstan (+996)</option>
                                                      <option value="+856" {{ $edit->countrycode == '+856' ? 'selected' : '' }}>Laos (+856)</option>
                                                      <option value="+371" {{ $edit->countrycode == '+371' ? 'selected' : '' }}>Latvia (+371)</option>
                                                      <option value="+961" {{ $edit->countrycode == '+961' ? 'selected' : '' }}>Lebanon (+961)</option>
                                                      <option value="+266" {{ $edit->countrycode == '+266' ? 'selected' : '' }}>Lesotho (+266)</option>
                                                      <option value="+231" {{ $edit->countrycode == '+231' ? 'selected' : '' }}>Liberia (+231)</option>
                                                      <option value="+218" {{ $edit->countrycode == '+218' ? 'selected' : '' }}>Libya (+218)</option>
                                                      <option value="+423" {{ $edit->countrycode == '+423' ? 'selected' : '' }}>Liechtenstein (+423)</option>
                                                      <option value="+370" {{ $edit->countrycode == '+370' ? 'selected' : '' }}>Lithuania (+370)</option>
                                                      <option value="+352" {{ $edit->countrycode == '+352' ? 'selected' : '' }}>Luxembourg (+352)</option>
                                                      <option value="+261" {{ $edit->countrycode == '+261' ? 'selected' : '' }}>Madagascar (+261)</option>
                                                      <option value="+265" {{ $edit->countrycode == '+265' ? 'selected' : '' }}>Malawi (+265)</option>
                                                      <option value="+60" {{ $edit->countrycode == '+60' ? 'selected' : '' }}>Malaysia (+60)</option>
                                                      <option value="+960" {{ $edit->countrycode == '+960' ? 'selected' : '' }}>Maldives (+960)</option>
                                                      <option value="+223" {{ $edit->countrycode == '+223' ? 'selected' : '' }}>Mali (+223)</option>
                                                      <option value="+356" {{ $edit->countrycode == '+356' ? 'selected' : '' }}>Malta (+356)</option>
                                                      <option value="+692" {{ $edit->countrycode == '+692' ? 'selected' : '' }}>Marshall Islands (+692)</option>
                                                      <option value="+596" {{ $edit->countrycode == '+596' ? 'selected' : '' }}>Martinique (+596)</option>
                                                      <option value="+222" {{ $edit->countrycode == '+222' ? 'selected' : '' }}>Mauritania (+222)</option>
                                                      <option value="+230" {{ $edit->countrycode == '+230' ? 'selected' : '' }}>Mauritius (+230)</option>
                                                      <option value="+262" {{ $edit->countrycode == '+262' ? 'selected' : '' }}>Mayotte (+262)</option>
                                                      <option value="+52" {{ $edit->countrycode == '+52' ? 'selected' : '' }}>Mexico (+52)</option>
                                                      <option value="+691" {{ $edit->countrycode == '+691' ? 'selected' : '' }}>Micronesia (+691)</option>
                                                      <option value="+373" {{ $edit->countrycode == '+373' ? 'selected' : '' }}>Moldova (+373)</option>
                                                      <option value="+377" {{ $edit->countrycode == '+377' ? 'selected' : '' }}>Monaco (+377)</option>
                                                      <option value="+976" {{ $edit->countrycode == '+976' ? 'selected' : '' }}>Mongolia (+976)</option>
                                                      <option value="+382" {{ $edit->countrycode == '+382' ? 'selected' : '' }}>Montenegro (+382)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Montserrat (+1)</option>
                                                      <option value="+212" {{ $edit->countrycode == '+212' ? 'selected' : '' }}>Morocco (+212)</option>
                                                      <option value="+258" {{ $edit->countrycode == '+258' ? 'selected' : '' }}>Mozambique (+258)</option>
                                                      <option value="+95" {{ $edit->countrycode == '+95' ? 'selected' : '' }}>Myanmar (+95)</option>
                                                      <option value="+264" {{ $edit->countrycode == '+264' ? 'selected' : '' }}>Namibia (+264)</option>
                                                      <option value="+674" {{ $edit->countrycode == '+674' ? 'selected' : '' }}>Nauru (+674)</option>
                                                      <option value="+977" {{ $edit->countrycode == '+977' ? 'selected' : '' }}>Nepal (+977)</option>
                                                      <option value="+31" {{ $edit->countrycode == '+31' ? 'selected' : '' }}>Netherlands (+31)</option>
                                                      <option value="+687" {{ $edit->countrycode == '+687' ? 'selected' : '' }}>New Caledonia (+687)</option>
                                                      <option value="+64" {{ $edit->countrycode == '+64' ? 'selected' : '' }}>New Zealand (+64)</option>
                                                      <option value="+505" {{ $edit->countrycode == '+505' ? 'selected' : '' }}>Nicaragua (+505)</option>
                                                      <option value="+227" {{ $edit->countrycode == '+227' ? 'selected' : '' }}>Niger (+227)</option>
                                                      <option value="+234" {{ $edit->countrycode == '+234' ? 'selected' : '' }}>Nigeria (+234)</option>
                                                      <option value="+683" {{ $edit->countrycode == '+683' ? 'selected' : '' }}>Niue (+683)</option>
                                                      <option value="+672" {{ $edit->countrycode == '+672' ? 'selected' : '' }}>Norfolk Island (+672)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Northern Mariana Islands (+1)</option>
                                                      <option value="+47" {{ $edit->countrycode == '+47' ? 'selected' : '' }}>Norway (+47)</option>
                                                      <option value="+968" {{ $edit->countrycode == '+968' ? 'selected' : '' }}>Oman (+968)</option>
                                                      <option value="+92" {{ $edit->countrycode == '+92' ? 'selected' : '' }}>Pakistan (+92)</option>
                                                      <option value="+680" {{ $edit->countrycode == '+680' ? 'selected' : '' }}>Palau (+680)</option>
                                                      <option value="+970" {{ $edit->countrycode == '+970' ? 'selected' : '' }}>Palestinian Territory (+970)</option>
                                                      <option value="+507" {{ $edit->countrycode == '+507' ? 'selected' : '' }}>Panama (+507)</option>
                                                      <option value="+675" {{ $edit->countrycode == '+675' ? 'selected' : '' }}>Papua New Guinea (+675)</option>
                                                      <option value="+595" {{ $edit->countrycode == '+595' ? 'selected' : '' }}>Paraguay (+595)</option>
                                                      <option value="+51" {{ $edit->countrycode == '+51' ? 'selected' : '' }}>Peru (+51)</option>
                                                      <option value="+63" {{ $edit->countrycode == '+63' ? 'selected' : '' }}>Philippines (+63)</option>
                                                      <option value="+48" {{ $edit->countrycode == '+48' ? 'selected' : '' }}>Poland (+48)</option>
                                                      <option value="+351" {{ $edit->countrycode == '+351' ? 'selected' : '' }}>Portugal (+351)</option>
                                                      <option value="+1787" {{ $edit->countrycode == '+1787' ? 'selected' : '' }}>Puerto Rico (+1787)</option>
                                                      <option value="+974" {{ $edit->countrycode == '+974' ? 'selected' : '' }}>Qatar (+974)</option>
                                                      <option value="+262" {{ $edit->countrycode == '+262' ? 'selected' : '' }}>Réunion (+262)</option>
                                                      <option value="+40" {{ $edit->countrycode == '+40' ? 'selected' : '' }}>Romania (+40)</option>
                                                      <option value="+7" {{ $edit->countrycode == '+7' ? 'selected' : '' }}>Russia (+7)</option>
                                                      <option value="+250" {{ $edit->countrycode == '+250' ? 'selected' : '' }}>Rwanda (+250)</option>
                                                      <option value="+508" {{ $edit->countrycode == '+508' ? 'selected' : '' }}>Saint Barthélemy (+508)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Saint Helena (+1)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Saint Kitts and Nevis (+1)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Saint Lucia (+1)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Saint Martin (+1)</option>
                                                      <option value="+590" {{ $edit->countrycode == '+590' ? 'selected' : '' }}>Saint Pierre and Miquelon (+590)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Saint Vincent and the Grenadines (+1)</option>
                                                      <option value="+685" {{ $edit->countrycode == '+685' ? 'selected' : '' }}>Samoa (+685)</option>
                                                      <option value="+378" {{ $edit->countrycode == '+378' ? 'selected' : '' }}>San Marino (+378)</option>
                                                      <option value="+239" {{ $edit->countrycode == '+239' ? 'selected' : '' }}>Sao Tome and Principe (+239)</option>
                                                      <option value="+966" {{ $edit->countrycode == '+966' ? 'selected' : '' }}>Saudi Arabia (+966)</option>
                                                      <option value="+221" {{ $edit->countrycode == '+221' ? 'selected' : '' }}>Senegal (+221)</option>
                                                      <option value="+381" {{ $edit->countrycode == '+381' ? 'selected' : '' }}>Serbia (+381)</option>
                                                      <option value="+248" {{ $edit->countrycode == '+248' ? 'selected' : '' }}>Seychelles (+248)</option>
                                                      <option value="+232" {{ $edit->countrycode == '+232' ? 'selected' : '' }}>Sierra Leone (+232)</option>
                                                      <option value="+65" {{ $edit->countrycode == '+65' ? 'selected' : '' }}>Singapore (+65)</option>
                                                      <option value="+421" {{ $edit->countrycode == '+421' ? 'selected' : '' }}>Slovakia (+421)</option>
                                                      <option value="+386" {{ $edit->countrycode == '+386' ? 'selected' : '' }}>Slovenia (+386)</option>
                                                      <option value="+677" {{ $edit->countrycode == '+677' ? 'selected' : '' }}>Solomon Islands (+677)</option>
                                                      <option value="+252" {{ $edit->countrycode == '+252' ? 'selected' : '' }}>Somalia (+252)</option>
                                                      <option value="+27" {{ $edit->countrycode == '+27' ? 'selected' : '' }}>South Africa (+27)</option>
                                                      <option value="+82" {{ $edit->countrycode == '+82' ? 'selected' : '' }}>South Korea (+82)</option>
                                                      <option value="+211" {{ $edit->countrycode == '+211' ? 'selected' : '' }}>South Sudan (+211)</option>
                                                      <option value="+34" {{ $edit->countrycode == '+34' ? 'selected' : '' }}>Spain (+34)</option>
                                                      <option value="+94" {{ $edit->countrycode == '+94' ? 'selected' : '' }}>Sri Lanka (+94)</option>
                                                      <option value="+249" {{ $edit->countrycode == '+249' ? 'selected' : '' }}>Sudan (+249)</option>
                                                      <option value="+597" {{ $edit->countrycode == '+597' ? 'selected' : '' }}>Suriname (+597)</option>
                                                      <option value="+47" {{ $edit->countrycode == '+47' ? 'selected' : '' }}>Svalbard and Jan Mayen (+47)</option>
                                                      <option value="+268" {{ $edit->countrycode == '+268' ? 'selected' : '' }}>Swaziland (+268)</option>
                                                      <option value="+46" {{ $edit->countrycode == '+46' ? 'selected' : '' }}>Sweden (+46)</option>
                                                      <option value="+41" {{ $edit->countrycode == '+41' ? 'selected' : '' }}>Switzerland (+41)</option>
                                                      <option value="+963" {{ $edit->countrycode == '+963' ? 'selected' : '' }}>Syria (+963)</option>
                                                      <option value="+886" {{ $edit->countrycode == '+886' ? 'selected' : '' }}>Taiwan (+886)</option>
                                                      <option value="+992" {{ $edit->countrycode == '+992' ? 'selected' : '' }}>Tajikistan (+992)</option>
                                                      <option value="+255" {{ $edit->countrycode == '+255' ? 'selected' : '' }}>Tanzania (+255)</option>
                                                      <option value="+66" {{ $edit->countrycode == '+66' ? 'selected' : '' }}>Thailand (+66)</option>
                                                      <option value="+670" {{ $edit->countrycode == '+670' ? 'selected' : '' }}>Timor-Leste (+670)</option>
                                                      <option value="+228" {{ $edit->countrycode == '+228' ? 'selected' : '' }}>Togo (+228)</option>
                                                      <option value="+690" {{ $edit->countrycode == '+690' ? 'selected' : '' }}>Tokelau (+690)</option>
                                                      <option value="+676" {{ $edit->countrycode == '+676' ? 'selected' : '' }}>Tonga (+676)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Trinidad and Tobago (+1)</option>
                                                      <option value="+216" {{ $edit->countrycode == '+216' ? 'selected' : '' }}>Tunisia (+216)</option>
                                                      <option value="+90" {{ $edit->countrycode == '+90' ? 'selected' : '' }}>Turkey (+90)</option>
                                                      <option value="+993" {{ $edit->countrycode == '+993' ? 'selected' : '' }}>Turkmenistan (+993)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Turks and Caicos Islands (+1)</option>
                                                      <option value="+688" {{ $edit->countrycode == '+688' ? 'selected' : '' }}>Tuvalu (+688)</option>
                                                      <option value="+256" {{ $edit->countrycode == '+256' ? 'selected' : '' }}>Uganda (+256)</option>
                                                      <option value="+380" {{ $edit->countrycode == '+380' ? 'selected' : '' }}>Ukraine (+380)</option>
                                                      <option value="+971" {{ $edit->countrycode == '+971' ? 'selected' : '' }}>United Arab Emirates (+971)</option>
                                                      <option value="+44" {{ $edit->countrycode == '+44' ? 'selected' : '' }}>United Kingdom (+44)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>United States (+1)</option>
                                                      <option value="+598" {{ $edit->countrycode == '+598' ? 'selected' : '' }}>Uruguay (+598)</option>
                                                      <option value="+998" {{ $edit->countrycode == '+998' ? 'selected' : '' }}>Uzbekistan (+998)</option>
                                                      <option value="+678" {{ $edit->countrycode == '+678' ? 'selected' : '' }}>Vanuatu (+678)</option>
                                                      <option value="+39" {{ $edit->countrycode == '+39' ? 'selected' : '' }}>Vatican City (+39)</option>
                                                      <option value="+58" {{ $edit->countrycode == '+58' ? 'selected' : '' }}>Venezuela (+58)</option>
                                                      <option value="+84" {{ $edit->countrycode == '+84' ? 'selected' : '' }}>Vietnam (+84)</option>
                                                      <option value="+1" {{ $edit->countrycode == '+1' ? 'selected' : '' }}>Wallis and Futuna (+1)</option>
                                                      <option value="+681" {{ $edit->countrycode == '+681' ? 'selected' : '' }}>Western Sahara (+681)</option>
                                                      <option value="+967" {{ $edit->countrycode == '+967' ? 'selected' : '' }}>Yemen (+967)</option>
                                                      <option value="+260" {{ $edit->countrycode == '+260' ? 'selected' : '' }}>Zambia (+260)</option>
                                                      <option value="+263" {{ $edit->countrycode == '+263' ? 'selected' : '' }}>Zimbabwe (+263)</option>
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                <div class="form-group">
                                                    <label for="mobile">Primary Phone (Mobile)</label>
                                                    <input type="number" class="form-control" name="mobile"
                                                        id="mobile" autocomplete="off" value="@if($edit->mobile_enc != NULL){{Crypt::decrypt($edit->mobile_enc)}}@endif" />
                                                </div>
                                            <small id="error-message" class="text-danger"></small>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                <div class="form-group">
                                                    <label for="phone">Secondary Phone</label>
                                                    <input type="number" class="form-control" name="phone"
                                                        id="phone" autocomplete="off" value="@if($edit->phone != NULL){{Crypt::decrypt($edit->phone)}}@endif" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="branch">Branch <span class="required"></span></label>
                                                    <select class="form-select" name="branch" id="branch" required>
                                                        <option value="">Select One</option>
                                                        @if ($branches->count() != null)
                                                            @foreach ($branches as $branch)
                                                                <option value="{{ $branch->id }}"
                                                                    {{ $edit->branch_id == $branch->id ? 'selected' : '' }}>
                                                                    {{ $branch->title }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="parent">Status <span class="required"></span></label>
                                                    <select class="form-select" id="status" name="status" required>
                                                        <option value="">Select One</option>
                                                        <option value="Active"
                                                            {{ $edit->status == 'Active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="Draft"
                                                            {{ $edit->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="bloodgroup">Blood Group</label>
                                                    <select class="form-select" name="bloodgroup" id="bloodgroup">
                                                        <option value="">Select One</option>
                                                        <option value="A+"
                                                            {{ $edit->bloodgroup == 'A+' ? 'selected' : '' }}>A+</option>
                                                        <option value="A-"
                                                            {{ $edit->bloodgroup == 'A-' ? 'selected' : '' }}>A-</option>
                                                        <option value="B+"
                                                            {{ $edit->bloodgroup == 'B+' ? 'selected' : '' }}>B+</option>
                                                        <option value="B-"
                                                            {{ $edit->bloodgroup == 'B-' ? 'selected' : '' }}>B-</option>
                                                        <option value="O+"
                                                            {{ $edit->bloodgroup == 'O+' ? 'selected' : '' }}>O+</option>
                                                        <option value="O-"
                                                            {{ $edit->bloodgroup == 'O-' ? 'selected' : '' }}>O-</option>
                                                        <option value="AB+"
                                                            {{ $edit->bloodgroup == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                        <option value="AB-"
                                                            {{ $edit->bloodgroup == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <select class="form-select" name="gender" id="gender">
                                                        <option value="">Select One</option>
                                                        <option value="Male"
                                                            {{ $edit->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female"
                                                            {{ $edit->gender == 'Female' ? 'selected' : '' }}>Female
                                                        </option>
                                                        <option value="Other"
                                                            {{ $edit->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                                        <option value="Rather not say"{{ $edit->gender == 'Rather not say' ? 'selected' : '' }}>Rather not say</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="education">Education</label>
                                                    <select class="form-select" name="education" id="education">
                                                        <option value="">Select One</option>
                                                        <option value="Literate" {{ $edit->education == 'Literate' ? 'selected' : '' }}>Literate</option>
                                                        <option value="Primary" {{ $edit->education == 'Primary' ? 'selected' : '' }}>Primary</option>
                                                        <option value="Upper Primary" {{ $edit->education == 'Upper Primary' ? 'selected' : '' }}>Upper Primary</option>
                                                        <option value="Secondary" {{ $edit->education == 'Secondary' ? 'selected' : '' }}>Secondary</option>
                                                        <option value="Higher Secondary" {{ $edit->education == 'Higher Secondary' ? 'selected' : '' }}>Higher Secondary</option>
                                                        <option value="District Level" {{ $edit->education == 'District Level' ? 'selected' : '' }}>District Level</option>
                                                        <option value="Vocational" {{ $edit->education == 'Vocational' ? 'selected' : '' }}>Vocational</option>
                                                        <option value="SLC/SEE" {{ $edit->education == 'SLC/SEE' ? 'selected' : '' }}>SLC/SEE</option>
                                                        <option value="+2" {{ $edit->education == '+2' ? 'selected' : '' }}>+2</option>
                                                        <option value="Diploma" {{ $edit->education == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                                        <option value="Bachelor" {{ $edit->education == 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
                                                        <option value="Master" {{ $edit->education == 'Master' ? 'selected' : '' }}>Master</option>
                                                        <option value="Doctorate(PHD)" {{ $edit->education == 'Doctorate(PHD)' ? 'selected' : '' }}>Doctorate(PHD)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                              <div class="form-group">
                                                  <label for="mentor">Mentor</label>
                                                  <select class="form-select" data-control="select2" name="mentor"
                                                      id="mentor">
                                                      <option value="">Select One</option>
                                                      @if ($mentors->count() != null)
                                                          @foreach ($mentors as $mentor)
                                                              <option value="{{ $mentor->id }}" {{ $edit->mentor == $mentor->id ? 'selected' : '' }}>
                                                                  @if($mentor->getdevotee->firstname != NULL){{Crypt::decrypt($mentor->getdevotee->firstname)}} @endif
                                                                  @if($mentor->getdevotee->middlename != NULL){{Crypt::decrypt($mentor->getdevotee->middlename)}} @endif
                                                                  @if($mentor->getdevotee->surname != NULL){{Crypt::decrypt($mentor->getdevotee->surname)}} @endif
                                                                </option>
                                                          @endforeach
                                                      @endif
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                              <div class="form-group">
                                                  <label for="maritalstatus">Marital Status</label>
                                                  <select class="form-control" data-control="select2" name="maritalstatus" id="maritalstatus">
                                                      <option value="">Select One</option>
                                                      <option value="Single" {{ $edit->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
                                                      <option value="Married" {{ $edit->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
                                                      <option value="Subdivision of 4 St Agnes Court, St Agnes" {{ $edit->marital_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                                      <option value="Divorced" {{ $edit->marital_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                                      <option value="Separated" {{ $edit->marital_status == 'Separated' ? 'selected' : '' }}>Separated</option>
                                                      <option value="Other" {{ $edit->marital_status == 'Other' ? 'selected' : '' }}>Other</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                            <div class="mt-10 mb-5"><input type="checkbox" class="form-check-input" value="1" {{ $edit->member == 1 ? 'selected' : '' }} id="lifemember" name="lifemember" /> Life Member<br />
                                            </div>
                                          </div>
                                        </div>

                                        <h4 class="mt-5">Identity Details</h4>

                                        <div class="row">
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                              <div class="form-group">
                                                  <label for="nationality">Nationality</label>
                                                  <select name="nationality" data-control="select2" class="form-control">
                                                    <option value="Afghan" {{ $edit->nationality == 'Afghan' ? 'selected' : '' }}>Afghan</option>
                                                    <option value="Albanian" {{ $edit->nationality == 'Albanian' ? 'selected' : '' }}>Albanian</option>
                                                    <option value="Algerian" {{ $edit->nationality == 'Algerian' ? 'selected' : '' }}>Algerian</option>
                                                    <option value="American" {{ $edit->nationality == 'American' ? 'selected' : '' }}>American</option>
                                                    <option value="Andorran" {{ $edit->nationality == 'Andorran' ? 'selected' : '' }}>Andorran</option>
                                                    <option value="Angolan" {{ $edit->nationality == 'Angolan' ? 'selected' : '' }}>Angolan</option>
                                                    <option value="Antiguan" {{ $edit->nationality == 'Antiguan' ? 'selected' : '' }}>Antiguan</option>
                                                    <option value="Argentine" {{ $edit->nationality == 'Argentine' ? 'selected' : '' }}>Argentine</option>
                                                    <option value="Armenian" {{ $edit->nationality == 'Armenian' ? 'selected' : '' }}>Armenian</option>
                                                    <option value="Australian" {{ $edit->nationality == 'Australian' ? 'selected' : '' }}>Australian</option>
                                                    <option value="Austrian" {{ $edit->nationality == 'Austrian' ? 'selected' : '' }}>Austrian</option>
                                                    <option value="Azerbaijani" {{ $edit->nationality == 'Azerbaijani' ? 'selected' : '' }}>Azerbaijani</option>
                                                    <option value="Bahamian" {{ $edit->nationality == 'Bahamian' ? 'selected' : '' }}>Bahamian</option>
                                                    <option value="Bahraini" {{ $edit->nationality == 'Bahraini' ? 'selected' : '' }}>Bahraini</option>
                                                    <option value="Bangladeshi" {{ $edit->nationality == 'Bangladeshi' ? 'selected' : '' }}>Bangladeshi</option>
                                                    <option value="Barbadian" {{ $edit->nationality == 'Barbadian' ? 'selected' : '' }}>Barbadian</option>
                                                    <option value="Belarusian" {{ $edit->nationality == 'Belarusian' ? 'selected' : '' }}>Belarusian</option>
                                                    <option value="Belgian" {{ $edit->nationality == 'Belgian' ? 'selected' : '' }}>Belgian</option>
                                                    <option value="Belizean" {{ $edit->nationality == 'Belizean' ? 'selected' : '' }}>Belizean</option>
                                                    <option value="Beninese" {{ $edit->nationality == 'Beninese' ? 'selected' : '' }}>Beninese</option>
                                                    <option value="Bhutanese" {{ $edit->nationality == 'Bhutanese' ? 'selected' : '' }}>Bhutanese</option>
                                                    <option value="Bolivian" {{ $edit->nationality == 'Bolivian' ? 'selected' : '' }}>Bolivian</option>
                                                    <option value="Bosnian" {{ $edit->nationality == 'Bosnian' ? 'selected' : '' }}>Bosnian</option>
                                                    <option value="Botswanan" {{ $edit->nationality == 'Botswanan' ? 'selected' : '' }}>Botswanan</option>
                                                    <option value="Brazilian" {{ $edit->nationality == 'Brazilian' ? 'selected' : '' }}>Brazilian</option>
                                                    <option value="British" {{ $edit->nationality == 'British' ? 'selected' : '' }}>British</option>
                                                    <option value="Bruneian" {{ $edit->nationality == 'Bruneian' ? 'selected' : '' }}>Bruneian</option>
                                                    <option value="Bulgarian" {{ $edit->nationality == 'Bulgarian' ? 'selected' : '' }}>Bulgarian</option>
                                                    <option value="Burkinabe" {{ $edit->nationality == 'Burkinabe' ? 'selected' : '' }}>Burkinabe</option>
                                                    <option value="Burmese" {{ $edit->nationality == 'Burmese' ? 'selected' : '' }}>Burmese</option>
                                                    <option value="Burundian" {{ $edit->nationality == 'Burundian' ? 'selected' : '' }}>Burundian</option>
                                                    <option value="Cambodian" {{ $edit->nationality == 'Cambodian' ? 'selected' : '' }}>Cambodian</option>
                                                    <option value="Cameroonian" {{ $edit->nationality == 'Cameroonian' ? 'selected' : '' }}>Cameroonian</option>
                                                    <option value="Canadian" {{ $edit->nationality == 'Canadian' ? 'selected' : '' }}>Canadian</option>
                                                    <option value="Cape Verdean" {{ $edit->nationality == 'Cape Verdean' ? 'selected' : '' }}>Cape Verdean</option>
                                                    <option value="Central African" {{ $edit->nationality == 'Central African' ? 'selected' : '' }}>Central African</option>
                                                    <option value="Chadian" {{ $edit->nationality == 'Chadian' ? 'selected' : '' }}>Chadian</option>
                                                    <option value="Chilean" {{ $edit->nationality == 'Chilean' ? 'selected' : '' }}>Chilean</option>
                                                    <option value="Chinese" {{ $edit->nationality == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                                    <option value="Colombian" {{ $edit->nationality == 'Colombian' ? 'selected' : '' }}>Colombian</option>
                                                    <option value="Comorian" {{ $edit->nationality == 'Comorian' ? 'selected' : '' }}>Comorian</option>
                                                    <option value="Congolese" {{ $edit->nationality == 'Congolese' ? 'selected' : '' }}>Congolese</option>
                                                    <option value="Costa Rican" {{ $edit->nationality == 'Costa Rican' ? 'selected' : '' }}>Costa Rican</option>
                                                    <option value="Croatian" {{ $edit->nationality == 'Croatian' ? 'selected' : '' }}>Croatian</option>
                                                    <option value="Cuban" {{ $edit->nationality == 'Cuban' ? 'selected' : '' }}>Cuban</option>
                                                    <option value="Cypriot" {{ $edit->nationality == 'Cypriot' ? 'selected' : '' }}>Cypriot</option>
                                                    <option value="Czech" {{ $edit->nationality == 'Czech' ? 'selected' : '' }}>Czech</option>
                                                    <option value="Danish" {{ $edit->nationality == 'Danish' ? 'selected' : '' }}>Danish</option>
                                                    <option value="Djiboutian" {{ $edit->nationality == 'Djiboutian' ? 'selected' : '' }}>Djiboutian</option>
                                                    <option value="Dominican" {{ $edit->nationality == 'Dominican' ? 'selected' : '' }}>Dominican</option>
                                                    <option value="Dutch" {{ $edit->nationality == 'Dutch' ? 'selected' : '' }}>Dutch</option>
                                                    <option value="East Timorese" {{ $edit->nationality == 'East Timorese' ? 'selected' : '' }}>East Timorese</option>
                                                    <option value="Ecuadorean" {{ $edit->nationality == 'Ecuadorean' ? 'selected' : '' }}>Ecuadorean</option>
                                                    <option value="Egyptian" {{ $edit->nationality == 'Egyptian' ? 'selected' : '' }}>Egyptian</option>
                                                    <option value="Emirati" {{ $edit->nationality == 'Emirati' ? 'selected' : '' }}>Emirati</option>
                                                    <option value="Equatorial Guinean" {{ $edit->nationality == 'Equatorial Guinean' ? 'selected' : '' }}>Equatorial Guinean</option>
                                                    <option value="Eritrean" {{ $edit->nationality == 'Eritrean' ? 'selected' : '' }}>Eritrean</option>
                                                    <option value="Estonian" {{ $edit->nationality == 'Estonian' ? 'selected' : '' }}>Estonian</option>
                                                    <option value="Ethiopian" {{ $edit->nationality == 'Ethiopian' ? 'selected' : '' }}>Ethiopian</option>
                                                    <option value="Fijian" {{ $edit->nationality == 'Fijian' ? 'selected' : '' }}>Fijian</option>
                                                    <option value="Finnish" {{ $edit->nationality == 'Finnish' ? 'selected' : '' }}>Finnish</option>
                                                    <option value="French" {{ $edit->nationality == 'French' ? 'selected' : '' }}>French</option>
                                                    <option value="Gabonese" {{ $edit->nationality == 'Gabonese' ? 'selected' : '' }}>Gabonese</option>
                                                    <option value="Gambian" {{ $edit->nationality == 'Gambian' ? 'selected' : '' }}>Gambian</option>
                                                    <option value="Georgian" {{ $edit->nationality == 'Georgian' ? 'selected' : '' }}>Georgian</option>
                                                    <option value="German" {{ $edit->nationality == 'German' ? 'selected' : '' }}>German</option>
                                                    <option value="Ghanaian" {{ $edit->nationality == 'Ghanaian' ? 'selected' : '' }}>Ghanaian</option>
                                                    <option value="Greek" {{ $edit->nationality == 'Greek' ? 'selected' : '' }}>Greek</option>
                                                    <option value="Grenadian" {{ $edit->nationality == 'Grenadian' ? 'selected' : '' }}>Grenadian</option>
                                                    <option value="Guatemalan" {{ $edit->nationality == 'Guatemalan' ? 'selected' : '' }}>Guatemalan</option>
                                                    <option value="Guinean" {{ $edit->nationality == 'Guinean' ? 'selected' : '' }}>Guinean</option>
                                                    <option value="Guyanese" {{ $edit->nationality == 'Guyanese' ? 'selected' : '' }}>Guyanese</option>
                                                    <option value="Haitian" {{ $edit->nationality == 'Haitian' ? 'selected' : '' }}>Haitian</option>
                                                    <option value="Honduran" {{ $edit->nationality == 'Honduran' ? 'selected' : '' }}>Honduran</option>
                                                    <option value="Hungarian" {{ $edit->nationality == 'Hungarian' ? 'selected' : '' }}>Hungarian</option>
                                                    <option value="Icelandic" {{ $edit->nationality == 'Icelandic' ? 'selected' : '' }}>Icelandic</option>
                                                    <option value="Indian" {{ $edit->nationality == 'Indian' ? 'selected' : '' }}>Indian</option>
                                                    <option value="Indonesian" {{ $edit->nationality == 'Indonesian' ? 'selected' : '' }}>Indonesian</option>
                                                    <option value="Iranian" {{ $edit->nationality == 'Iranian' ? 'selected' : '' }}>Iranian</option>
                                                    <option value="Iraqi" {{ $edit->nationality == 'Iraqi' ? 'selected' : '' }}>Iraqi</option>
                                                    <option value="Irish" {{ $edit->nationality == 'Irish' ? 'selected' : '' }}>Irish</option>
                                                    <option value="Israeli" {{ $edit->nationality == 'Israeli' ? 'selected' : '' }}>Israeli</option>
                                                    <option value="Italian" {{ $edit->nationality == 'Italian' ? 'selected' : '' }}>Italian</option>
                                                    <option value="Ivorian" {{ $edit->nationality == 'Ivorian' ? 'selected' : '' }}>Ivorian</option>
                                                    <option value="Jamaican" {{ $edit->nationality == 'Jamaican' ? 'selected' : '' }}>Jamaican</option>
                                                    <option value="Japanese" {{ $edit->nationality == 'Japanese' ? 'selected' : '' }}>Japanese</option>
                                                    <option value="Jordanian" {{ $edit->nationality == 'Jordanian' ? 'selected' : '' }}>Jordanian</option>
                                                    <option value="Kazakh" {{ $edit->nationality == 'Kazakh' ? 'selected' : '' }}>Kazakh</option>
                                                    <option value="Kenyan" {{ $edit->nationality == 'Kenyan' ? 'selected' : '' }}>Kenyan</option>
                                                    <option value="Kiribati" {{ $edit->nationality == 'Kiribati' ? 'selected' : '' }}>Kiribati</option>
                                                    <option value="Kuwaiti" {{ $edit->nationality == 'Kuwaiti' ? 'selected' : '' }}>Kuwaiti</option>
                                                    <option value="Kyrgyz" {{ $edit->nationality == 'Kyrgyz' ? 'selected' : '' }}>Kyrgyz</option>
                                                    <option value="Laotian" {{ $edit->nationality == 'Laotian' ? 'selected' : '' }}>Laotian</option>
                                                    <option value="Latvian" {{ $edit->nationality == 'Latvian' ? 'selected' : '' }}>Latvian</option>
                                                    <option value="Lebanese" {{ $edit->nationality == 'Lebanese' ? 'selected' : '' }}>Lebanese</option>
                                                    <option value="Liberian" {{ $edit->nationality == 'Liberian' ? 'selected' : '' }}>Liberian</option>
                                                    <option value="Libyan" {{ $edit->nationality == 'Libyan' ? 'selected' : '' }}>Libyan</option>
                                                    <option value="Liechtenstein" {{ $edit->nationality == 'Liechtenstein' ? 'selected' : '' }}>Liechtenstein</option>
                                                    <option value="Lithuanian" {{ $edit->nationality == 'Lithuanian' ? 'selected' : '' }}>Lithuanian</option>
                                                    <option value="Luxembourger" {{ $edit->nationality == 'Luxembourger' ? 'selected' : '' }}>Luxembourger</option>
                                                    <option value="Macedonian" {{ $edit->nationality == 'Macedonian' ? 'selected' : '' }}>Macedonian</option>
                                                    <option value="Malagasy" {{ $edit->nationality == 'Malagasy' ? 'selected' : '' }}>Malagasy</option>
                                                    <option value="Malawian" {{ $edit->nationality == 'Malawian' ? 'selected' : '' }}>Malawian</option>
                                                    <option value="Malaysian" {{ $edit->nationality == 'Malaysian' ? 'selected' : '' }}>Malaysian</option>
                                                    <option value="Maldivian" {{ $edit->nationality == 'Maldivian' ? 'selected' : '' }}>Maldivian</option>
                                                    <option value="Malian" {{ $edit->nationality == 'Malian' ? 'selected' : '' }}>Malian</option>
                                                    <option value="Maltese" {{ $edit->nationality == 'Maltese' ? 'selected' : '' }}>Maltese</option>
                                                    <option value="Marshallese" {{ $edit->nationality == 'Marshallese' ? 'selected' : '' }}>Marshallese</option>
                                                    <option value="Mauritanian" {{ $edit->nationality == 'Mauritanian' ? 'selected' : '' }}>Mauritanian</option>
                                                    <option value="Mauritian" {{ $edit->nationality == 'Mauritian' ? 'selected' : '' }}>Mauritian</option>
                                                    <option value="Mexican" {{ $edit->nationality == 'Mexican' ? 'selected' : '' }}>Mexican</option>
                                                    <option value="Micronesian" {{ $edit->nationality == 'Micronesian' ? 'selected' : '' }}>Micronesian</option>
                                                    <option value="Moldovan" {{ $edit->nationality == 'Moldovan' ? 'selected' : '' }}>Moldovan</option>
                                                    <option value="Monegasque" {{ $edit->nationality == 'Monegasque' ? 'selected' : '' }}>Monegasque</option>
                                                    <option value="Mongolian" {{ $edit->nationality == 'Mongolian' ? 'selected' : '' }}>Mongolian</option>
                                                    <option value="Montenegrin" {{ $edit->nationality == 'Montenegrin' ? 'selected' : '' }}>Montenegrin</option>
                                                    <option value="Moroccan" {{ $edit->nationality == 'Moroccan' ? 'selected' : '' }}>Moroccan</option>
                                                    <option value="Mozambican" {{ $edit->nationality == 'Mozambican' ? 'selected' : '' }}>Mozambican</option>
                                                    <option value="Namibian" {{ $edit->nationality == 'Namibian' ? 'selected' : '' }}>Namibian</option>
                                                    <option value="Nauruan" {{ $edit->nationality == 'Nauruan' ? 'selected' : '' }}>Nauruan</option>
                                                    <option value="Nepalese" {{ $edit->nationality == 'Nepalese' ? 'selected' : '' }}>Nepalese</option>
                                                    <option value="New Zealander" {{ $edit->nationality == 'New Zealander' ? 'selected' : '' }}>New Zealander</option>
                                                    <option value="Nicaraguan" {{ $edit->nationality == 'Nicaraguan' ? 'selected' : '' }}>Nicaraguan</option>
                                                    <option value="Nigerian" {{ $edit->nationality == 'Nigerian' ? 'selected' : '' }}>Nigerian</option>
                                                    <option value="Nigerien" {{ $edit->nationality == 'Nigerien' ? 'selected' : '' }}>Nigerien</option>
                                                    <option value="North Korean" {{ $edit->nationality == 'North Korean' ? 'selected' : '' }}>North Korean</option>
                                                    <option value="Norwegian" {{ $edit->nationality == 'Norwegian' ? 'selected' : '' }}>Norwegian</option>
                                                    <option value="Omani" {{ $edit->nationality == 'Omani' ? 'selected' : '' }}>Omani</option>
                                                    <option value="Pakistani" {{ $edit->nationality == 'Pakistani' ? 'selected' : '' }}>Pakistani</option>
                                                    <option value="Palauan" {{ $edit->nationality == 'Palauan' ? 'selected' : '' }}>Palauan</option>
                                                    <option value="Panamanian" {{ $edit->nationality == 'Panamanian' ? 'selected' : '' }}>Panamanian</option>
                                                    <option value="Papua New Guinean" {{ $edit->nationality == 'Papua New Guinean' ? 'selected' : '' }}>Papua New Guinean</option>
                                                    <option value="Paraguayan" {{ $edit->nationality == 'Paraguayan' ? 'selected' : '' }}>Paraguayan</option>
                                                    <option value="Peruvian" {{ $edit->nationality == 'Peruvian' ? 'selected' : '' }}>Peruvian</option>
                                                    <option value="Polish" {{ $edit->nationality == 'Polish' ? 'selected' : '' }}>Polish</option>
                                                    <option value="Portuguese" {{ $edit->nationality == 'Portuguese' ? 'selected' : '' }}>Portuguese</option>
                                                    <option value="Qatari" {{ $edit->nationality == 'Qatari' ? 'selected' : '' }}>Qatari</option>
                                                    <option value="Romanian" {{ $edit->nationality == 'Romanian' ? 'selected' : '' }}>Romanian</option>
                                                    <option value="Russian" {{ $edit->nationality == 'Russian' ? 'selected' : '' }}>Russian</option>
                                                    <option value="Rwandan" {{ $edit->nationality == 'Rwandan' ? 'selected' : '' }}>Rwandan</option>
                                                    <option value="Saint Lucian" {{ $edit->nationality == 'Saint Lucian' ? 'selected' : '' }}>Saint Lucian</option>
                                                    <option value="Salvadoran" {{ $edit->nationality == 'Salvadoran' ? 'selected' : '' }}>Salvadoran</option>
                                                    <option value="Samoan" {{ $edit->nationality == 'Samoan' ? 'selected' : '' }}>Samoan</option>
                                                    <option value="San Marinese" {{ $edit->nationality == 'San Marinese' ? 'selected' : '' }}>San Marinese</option>
                                                    <option value="Sao Tomean" {{ $edit->nationality == 'Sao Tomean' ? 'selected' : '' }}>Sao Tomean</option>
                                                    <option value="Saudi" {{ $edit->nationality == 'Saudi' ? 'selected' : '' }}>Saudi</option>
                                                    <option value="Senegalese" {{ $edit->nationality == 'Senegalese' ? 'selected' : '' }}>Senegalese</option>
                                                    <option value="Serbian" {{ $edit->nationality == 'Serbian' ? 'selected' : '' }}>Serbian</option>
                                                    <option value="Seychellois" {{ $edit->nationality == 'Seychellois' ? 'selected' : '' }}>Seychellois</option>
                                                    <option value="Sierra Leonean" {{ $edit->nationality == 'Sierra Leonean' ? 'selected' : '' }}>Sierra Leonean</option>
                                                    <option value="Singaporean" {{ $edit->nationality == 'Singaporean' ? 'selected' : '' }}>Singaporean</option>
                                                    <option value="Slovak" {{ $edit->nationality == 'Slovak' ? 'selected' : '' }}>Slovak</option>
                                                    <option value="Slovenian" {{ $edit->nationality == 'Slovenian' ? 'selected' : '' }}>Slovenian</option>
                                                    <option value="Solomon Islander" {{ $edit->nationality == 'Solomon Islander' ? 'selected' : '' }}>Solomon Islander</option>
                                                    <option value="Somali" {{ $edit->nationality == 'Somali' ? 'selected' : '' }}>Somali</option>
                                                    <option value="South African" {{ $edit->nationality == 'South African' ? 'selected' : '' }}>South African</option>
                                                    <option value="South Korean" {{ $edit->nationality == 'South Korean' ? 'selected' : '' }}>South Korean</option>
                                                    <option value="Spanish" {{ $edit->nationality == 'Spanish' ? 'selected' : '' }}>Spanish</option>
                                                    <option value="Sri Lankan" {{ $edit->nationality == 'Sri Lankan' ? 'selected' : '' }}>Sri Lankan</option>
                                                    <option value="Sudanese" {{ $edit->nationality == 'Sudanese' ? 'selected' : '' }}>Sudanese</option>
                                                    <option value="Surinamer" {{ $edit->nationality == 'Surinamer' ? 'selected' : '' }}>Surinamer</option>
                                                    <option value="Swazi" {{ $edit->nationality == 'Swazi' ? 'selected' : '' }}>Swazi</option>
                                                    <option value="Swedish" {{ $edit->nationality == 'Swedish' ? 'selected' : '' }}>Swedish</option>
                                                    <option value="Swiss" {{ $edit->nationality == 'Swiss' ? 'selected' : '' }}>Swiss</option>
                                                    <option value="Syrian" {{ $edit->nationality == 'Syrian' ? 'selected' : '' }}>Syrian</option>
                                                    <option value="Taiwanese" {{ $edit->nationality == 'Taiwanese' ? 'selected' : '' }}>Taiwanese</option>
                                                    <option value="Tajik" {{ $edit->nationality == 'Tajik' ? 'selected' : '' }}>Tajik</option>
                                                    <option value="Tanzanian" {{ $edit->nationality == 'Tanzanian' ? 'selected' : '' }}>Tanzanian</option>
                                                    <option value="Thai" {{ $edit->nationality == 'Thai' ? 'selected' : '' }}>Thai</option>
                                                    <option value="Togolese" {{ $edit->nationality == 'Togolese' ? 'selected' : '' }}>Togolese</option>
                                                    <option value="Tongan" {{ $edit->nationality == 'Tongan' ? 'selected' : '' }}>Tongan</option>
                                                    <option value="Trinidadian" {{ $edit->nationality == 'Trinidadian' ? 'selected' : '' }}>Trinidadian</option>
                                                    <option value="Tunisian" {{ $edit->nationality == 'Tunisian' ? 'selected' : '' }}>Tunisian</option>
                                                    <option value="Turkish" {{ $edit->nationality == 'Turkish' ? 'selected' : '' }}>Turkish</option>
                                                    <option value="Turkmen" {{ $edit->nationality == 'Turkmen' ? 'selected' : '' }}>Turkmen</option>
                                                    <option value="Tuvaluan" {{ $edit->nationality == 'Tuvaluan' ? 'selected' : '' }}>Tuvaluan</option>
                                                    <option value="Ugandan" {{ $edit->nationality == 'Ugandan' ? 'selected' : '' }}>Ugandan</option>
                                                    <option value="Ukrainian" {{ $edit->nationality == 'Ukrainian' ? 'selected' : '' }}>Ukrainian</option>
                                                    <option value="Uruguayan" {{ $edit->nationality == 'Uruguayan' ? 'selected' : '' }}>Uruguayan</option>
                                                    <option value="Uzbek" {{ $edit->nationality == 'Uzbek' ? 'selected' : '' }}>Uzbek</option>
                                                    <option value="Vanuatuan" {{ $edit->nationality == 'Vanuatuan' ? 'selected' : '' }}>Vanuatuan</option>
                                                    <option value="Venezuelan" {{ $edit->nationality == 'Venezuelan' ? 'selected' : '' }}>Venezuelan</option>
                                                    <option value="Vietnamese" {{ $edit->nationality == 'Vietnamese' ? 'selected' : '' }}>Vietnamese</option>
                                                    <option value="Yemeni" {{ $edit->nationality == 'Yemeni' ? 'selected' : '' }}>Yemeni</option>
                                                    <option value="Zambian" {{ $edit->nationality == 'Zambian' ? 'selected' : '' }}>Zambian</option>
                                                    <option value="Zimbabwean" {{ $edit->nationality == 'Zimbabwean' ? 'selected' : '' }}>Zimbabwean</option>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                <div class="form-group">
                                                    <label for="identitytype">Identity Type</label>
                                                    <select class="form-select" name="identitytype" id="identitytype">
                                                        <option value="">Select One</option>
                                                        <?php
                                                        echo $edit->identitytype;
                                                          if($edit->identitytype != NULL){
                                                            $identitytype = Crypt::decrypt($edit->identitytype);
                                                          }else{
                                                            $identitytype = NULL;
                                                          }
                                                        ?>
                                                        <option value="Birth Certificate" {{ $edit->identitytype == 'Birth Certificate' ? 'selected' : '' }}>Birth Certificate</option>
                                                        <option value="License" {{ $identitytype == 'License' ? 'selected' : '' }}>License</option>
                                                        <option value="National ID"
                                                            {{ $identitytype == 'National ID' ? 'selected' : '' }}>
                                                            National ID</option>
                                                        <option value="Citizenship"
                                                            {{ $identitytype == 'Citizenship' ? 'selected' : '' }}>
                                                            Citizenship</option>
                                                        <option value="Passport"
                                                            {{ $identitytype == 'Passport' ? 'selected' : '' }}>
                                                            Passport</option>
                                                        <option value="Vote Card"
                                                            {{ $identitytype == 'Vote Card' ? 'selected' : '' }}>Vote
                                                            Card</option>
                                                        <option value="Student Card"
                                                            {{ $identitytype == 'Student Card' ? 'selected' : '' }}>
                                                            Student Card</option>
                                                        <option value="Profession Card"
                                                            {{ $identitytype == 'Profession Card' ? 'selected' : '' }}>
                                                            Profession Card</option>
                                                        <option value="Iskcon Card"
                                                            {{ $identitytype == 'Iskcon Card' ? 'selected' : '' }}>
                                                            Iskcon Card</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                <div class="form-group">
                                                    <label for="identityno">Identity No</label>
                                                    <input type="text" class="form-control" name="identityno"
                                                        id="identityno" autocomplete="off" value="@if($edit->identityid_enc != NULL){{Crypt::decrypt($edit->identityid_enc)}} @endif" />
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                <div class="form-group">
                                                    <label for="identityimage">Identity Image</label>
                                                    <input type="file" class="form-control" name="identityimage"
                                                        id="identityimage" />
                                                    <input type="hidden" class="custom-file-input"
                                                        value="{{ $edit->identityimage }}" name="identity_old" />
                                                    @if ($edit->identityimage != '')
                                                        <a class="mt-3 d-inline-block ml-2" href="{{ route('devoteeid.show', ['imageName' => $edit->identityimage]) }}" target="_blank"><i class="ki-outline ki-eye fs-3"></i></a>
                                                        <div class="mt-2 d-inline-block ms-3">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="removeid" name="removeid" value="1" />
                                                            <label class="custom-control-label" for="removeid">Remove
                                                                Identity</label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <h4>Permanent Address</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="province">Province</label>
                                                    <select class="form-select" name="province" id="province">
                                                        <option value="">Select Province</option>
                                                        @foreach ($provincesData as $province)
                                                            <option value="{{ $province->id }}"
                                                                @if($edit->pprovince != NULL)
                                                                  @if(Crypt::decrypt($edit->pprovince) == $province->id) selected @endif
                                                                @endif
                                                                >
                                                                {{ $province->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="pdistrict">District</label>
                                                    <select class="form-select" name="pdistrict" id="district">
                                                        <option value="">Select District</option>
                                                        <option value="{{ optional($districtbyId)->id }}"
                                                          @if($edit->pdistrict != NULL)
                                                            @if(Crypt::decrypt($edit->pdistrict) == optional($districtbyId)->id) selected @endif
                                                          @endif>
                                                            {{ $districtname }}
                                                        </option>

                                                        {{-- @endforeach --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="pmuni">Rural / Urban Municipality</label>
                                                    <select class="form-select" name="pmuni" id="category">
                                                        <option value="">Select Category</option>
                                                        @foreach ($categoriesdata as $category)
                                                            <option value="{{ $category->id }}"
                                                              @if($edit->pmuni != NULL)
                                                                @if(Crypt::decrypt($edit->pmuni) == $category->id) selected @endif
                                                              @endif>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8 col-lg-8 mb-8">
                                                <div class="form-group">
                                                    <label for="ptole">Municipality</label>
                                                    <select class="form-select" name="ptole" id="municipalities">
                                                        <option value="">Select Municipality</option>
                                                        <option value="{{ optional($tolebyId)->id }}"
                                                          @if($edit->ptole != NULL)
                                                            @if(Crypt::decrypt($edit->ptole) == optional($tolebyId)->id) selected @endif
                                                          @endif>
                                                            {{ $tolename }}
                                                        </option>

                                                        {{-- @endforeach --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="pwardno">Ward No</label>
                                                    <input type="text" class="form-control" name="pwardno"
                                                        id="ward" autocomplete="off" value="@if($edit->pwardno != NULL){{Crypt::decrypt($edit->pwardno)}}@endif" min="0" max="99" maxlength="2" oninput="if(this.value.length > 2) this.value = this.value.slice(0,2);">
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
                                                    <label for="province">Province</label>
                                                    <select class="form-select" name="tprovince" id="tprovince">
                                                        <option value="">Select Province</option>
                                                        @foreach ($provincesData as $province)
                                                            <option value="{{ $province->id }}"
                                                              @if($edit->tprovince != NULL)
                                                                @if(Crypt::decrypt($edit->tprovince) == $province->id) selected @endif
                                                              @endif >
                                                                {{ $province->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="tdistrict">District</label>
                                                    <select class="form-select" name="tdistrict" id="tdistrict">
                                                        <option value="">Select District</option>
                                                        <option value="{{ optional($tdistrictbyId)->id ?? 'Please select some Value' }}"
                                                          @if($edit->tdistrict != NULL)
                                                            @if(Crypt::decrypt($edit->tdistrict) == optional($tdistrictbyId)->id) selected @endif
                                                          @endif>
                                                            {{ $tdistrictname }}
                                                        </option>

                                                        {{-- @endforeach --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="pmuni">Rural / Urban Municipality</label>
                                                    <select class="form-select" name="tmuni" id="tcategory">
                                                        <option value="">Select Category</option>
                                                        @foreach ($categoriesdata as $category)
                                                            <option value="{{ $category->id ?? '' }}"
                                                              @if($edit->tmuni != NULL)
                                                                @if(Crypt::decrypt($edit->tmuni) == $category->id) selected @endif
                                                              @endif>
                                                                {{ $category->name ?? 'No Category Selected' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8 col-lg-8 mb-8">
                                                <div class="form-group">
                                                    <label for="ptole">Municipality</label>
                                                    <select class="form-select" name="ttole" id="tmunicipalities">
                                                        <option value="">Select Municipality</option>
                                                        <option value="{{ optional($ttolebyId)->id }}"
                                                          @if($edit->ptole != NULL)
                                                            @if(Crypt::decrypt($edit->ptole) == optional($ttolebyId)->id) selected @endif
                                                          @endif >
                                                            {{ $ttolename }}
                                                        </option>

                                                        {{-- @endforeach --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                <div class="form-group">
                                                    <label for="pwardno">Ward No</label>
                                                    <input type="text" class="form-control" name="twardno"
                                                        id="twardno" autocomplete="off" value="@if($edit->twardno != NULL){{Crypt::decrypt($edit->twardno)}}@endif" min="0" max="99" maxlength="2" oninput="if(this.value.length > 2) this.value = this.value.slice(0,2);">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                                <button type="submit"
                                                    class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Update
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
@php
$today = date('Y-m-d');
$nextdate = date('Y-m-d', strtotime('+5 year'));
@endphp
<script>
    const validateEmail = (email) => {
        return email.match(
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
    };

    const validate = () => {
        const $result = $('#result');
        const email = $('#email').val();
        $result.text('');

        if (validateEmail(email)) {
            $result.text(email + ' is valid.');
            $result.css('color', 'green');
        } else {
            $result.text(email + ' is invalid.');
            $result.css('color', 'red');
        }
        return false;
    }

    $('#email').on('input', validate);
</script>
<script>
    const mobileInput = document.getElementById('mobile');
    const errorMessage = document.getElementById('error-message');
    const form = document.getElementById('phone-form');

    function validateMobileInput() {
        let mobileNumber = mobileInput.value;

        // Remove non-digit characters
        mobileNumber = mobileNumber.replace(/\D/g, '');

        // Truncate to 10 characters if necessary
        if (mobileNumber.length > 10) {
            mobileNumber = mobileNumber.slice(0, 10);
        }

        mobileInput.value = mobileNumber;

        if (mobileNumber.length < 10) {
            errorMessage.textContent = 'Mobile number must be 10 digits.';
            mobileInput.classList.remove('valid');
            mobileInput.classList.add('invalid');
            return false;
        } else if (mobileNumber.length === 10) {
            errorMessage.textContent = '';
            mobileInput.classList.remove('invalid');
            mobileInput.classList.add('valid');

            setTimeout(() => {
                mobileInput.classList.remove('valid');
            }, 3000);
            return true;
        } else {
            errorMessage.textContent = 'Please enter a valid 10-digit mobile number.';
            mobileInput.classList.remove('valid');
            mobileInput.classList.add('invalid');
            return false;
        }
    }

    mobileInput.addEventListener('input', validateMobileInput);

    form.addEventListener('submit', function(e) {
        if (!validateMobileInput()) {
            e.preventDefault();
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#dobad").flatpickr({ dateFormat: "Y-m-d", disable: [{from:'{{$today}}', to:'{{$nextdate}}'}] });
    });

    // $(document).ready(function() {
    //     $("#filladdress").on("click", function() {
    //         if (this.checked) {
    //             $("#tprovince").val($("#province").val());
    //             $("#tdistrict").val($("#pdistrict").val());
    //             $("#tmuni").val($("#pmuni").val());
    //             $("#ttole").val($("#ptole").val());
    //             $("#twardno").val($("#pwardno").val());
    //         } else {
    //             $("#tprovince").val('');
    //             $("#tdistrict").val('');
    //             $("#tmuni").val('');
    //             $("#ttole").val('');
    //             $("#twardno").val('');
    //         }
    //     });
    // });

    document.addEventListener('DOMContentLoaded', (event) => {
        const fillAddressCheckbox = document.getElementById('filladdress');
        const tprovince = document.getElementById('tprovince');
        const tdistrict = document.getElementById('tdistrict');
        const tcategory = document.getElementById('tcategory');
        const tmunicipalities = document.getElementById('tmunicipalities');
        const twardno = document.getElementById('twardno');

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
            } else {
                // Clear temporary address fields
                tprovince.value = '';
                tdistrict.value = '';
                tcategory.value = '';
                tmunicipalities.value = '';
                twardno.value = '';
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
<script type="text/javascript" src="{{asset('nepalidate/nepali.datepicker.v4.0.5.min.js')}}"></script>
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
  if (( this.value == 'AD')){
    $("#dobad").show();
    $("#dobbs").hide();
    $("#dobdefault").hide();
  }
  if (( this.value == 'BS')){
    $("#dobbs").show();
    $("#dobad").hide();
    $("#dobdefault").hide();
  }
});
$("#dobad").hide();
$("#dobbs").hide();
$("#dobdefault").show();
</script>
@endsection
