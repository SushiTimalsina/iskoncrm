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
                                    Create Devotee Relation</h1>
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

                                        <div class="row mb-5">
                                          <div class="col-md-3 col-sm-3 col-lg-3">
                                            <div class="form-group">
                                              <label for="relationtype" class="mb-2">Relation Type</label>
                                              <select class="form-control" name="relationtype" id="relationtype" required>
                                                <option value="">Select One</option>
                                                <option value="existing">Existing Devotee</option>
                                                <option value="new">New Devotee</option>
                                              </select>
                                            </div>
                                          </div>
                                        </div>

                                        <div id="existing">
                                          <form action="{{ route('devoteerelationstore') }}" method="POST" enctype="multipart/form-data" class="devoteeform">
                                              @csrf
                                          <div class="row mb-5">
                                                <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                <label class="required fw-semibold">Devotee</label>
                                                <select class="form-select" name="devotee_id" id="devotee_id" required>
                                                  <option value="">Select One</option>
                                                  @if($devotees->count() != NULL)
                                                    @foreach($devotees as $devotee)
                                                      <option value="{{$devotee->id}}"
                                                        data-kt-rich-content-email="<?php echo $devotee->email; ?>"
                                                        data-kt-rich-content-mobile="<?php echo $devotee->mobile; ?>"
                                                        data-kt-rich-content-initiation="@if(Helper::getinitiationrow($devotee->id)) {{Helper::getinitiationrow($devotee->id)->initiation_name}} @endif">{{$devotee->firstname}} {{$devotee->middlename}} {{$devotee->surname}}</option>
                                                    @endforeach
                                                  @endif
                                                </select>
                                              </div>
                                              <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                <div class="form-group">
                                                    <label for="relation" class="required">Relation</label>
                                                    <select class="form-control" data-control="select2" name="relation" id="relation" required>
                                                      <option value="">Select One</option>
                                                      <option value="Wife">Wife</option>
                                                      <option value="Husband">Husband</option>
                                                      <option value="Father">Father</option>
                                                      <option value="Mother">Mother</option>
                                                      <option value="Son">Son</option>
                                                      <option value="Daughter">Daughter</option>
                                                      <option value="Brother">Brother</option>
                                                      <option value="Sister">Sister</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="devoteefamily" id="devoteefamily" autocomplete="off" value="{{$show->id}}"  />
                                            <div class="col-md-4 col-sm-4 col-lg-4 mb-3 mt-3"><button type="submit" class="btn btn-primary mt-3">Add Relation</button></div>
                                          </div>
                                          </form>
                                        </div>
                                        <div id="new">
                                          <form action="{{ route('devoteerelationstore') }}" method="POST"
                                              enctype="multipart/form-data" class="devoteeform">
                                              @csrf
                                              <h4 class="mb-2">Relation Info of <strong style="text-decoration:underline;">{{$show->firstname}} {{$show->middlename}} {{$show->surname}}</strong></h4>
                                              <div class="row">
                                                  <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                      <div class="form-group">
                                                          <label for="relation">Relation <span class="required"></span></label>
                                                          <select class="form-control" data-control="select2" name="relation" id="relation" required>
                                                            <option value="">Select One</option>
                                                            <option value="Wife">Wife</option>
                                                            <option value="Husband">Husband</option>
                                                            <option value="Father">Father</option>
                                                            <option value="Mother">Mother</option>
                                                            <option value="Son">Son</option>
                                                            <option value="Daughter">Daughter</option>
                                                            <option value="Brother">Brother</option>
                                                            <option value="Sister">Sister</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                              </div>
                                              <h4 class="mb-2">General Info</h4>
                                              <div class="row">
                                                  <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                      <div class="form-group">
                                                          <label for="firstname">First Name <span
                                                                  class="required"></span></label>
                                                          <input type="text" class="form-control"
                                                              name="firstname" id="firstname" autocomplete="off"  />
                                                      </div>
                                                  </div>
                                                  <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                      <div class="form-group">
                                                          <label for="middlename">Middle Name</label>
                                                          <input type="text" class="form-control"
                                                              name="middlename" id="middlename" autocomplete="off"  />
                                                      </div>
                                                  </div>
                                                  <div class="col-md-4 col-sm-4 col-lg-4 mb-3">
                                                      <div class="form-group">
                                                          <label for="surname">Surname <span class="required"></span></label>
                                                          <input type="text" class="form-control"
                                                              name="surname" id="surname" autocomplete="off"  />
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
                                                          <input type="text" class="form-control" name="dobad" id="dobad" autocomplete="off" />
                                                          <input type="text" class="form-control" name="dobbs" id="dobbs" autocomplete="off" />
                                                      </div>
                                                  </div>
                                                  <div class="col-md-3 col-sm-3 col-lg-3 mb-3">
                                                      <div class="form-group">
                                                          <label for="occupation">Occupation</label>
                                                          <select class="form-control" data-control="select2"
                                                              name="occupation" id="occupation">
                                                              <option value="">Select One</option>
                                                              @if ($occupations->count() != null)
                                                                  @foreach ($occupations as $occupation)
                                                                      <option value="{{ $occupation->id }}">{{$occupation->title}}</option>

                                                                      @if ($occupation->subcategory)
                                                                          @foreach ($occupation->subcategory as $child)
                                                                              <option value="{{ $child->id }}">&nbsp;&nbsp;-- {{ $child->title }}</option>
                                                                          @endforeach
                                                                      @endif
                                                                  @endforeach
                                                              @endif
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-3 col-sm-3 col-lg-3 mb-3">
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
                                                          <input type="email" class="form-control"
                                                              name="email" id="email" autocomplete="off" />
                                                      </div>

                                                      <small id="result" class="form-text "></small>
                                                      <p id="result"></p>
                                                  </div>
                                                  <div class="col-md-2 col-sm-2 col-lg-2 mb-4">
                                                      <div class="form-group">
                                                          <label for="countrycode">Country Code</label>
                                                          <select name="countrycode" class="form-select" data-control="select2">
                                                            <option value="" disabled selected>Select country code</option>
                                                            <option value="+93">Afghanistan (+93)</option>
                                                            <option value="+355">Albania (+355)</option>
                                                            <option value="+213">Algeria (+213)</option>
                                                            <option value="+1">American Samoa (+1)</option>
                                                            <option value="+376">Andorra (+376)</option>
                                                            <option value="+244">Angola (+244)</option>
                                                            <option value="+1">Anguilla (+1)</option>
                                                            <option value="+1">Antigua and Barbuda (+1)</option>
                                                            <option value="+54">Argentina (+54)</option>
                                                            <option value="+374">Armenia (+374)</option>
                                                            <option value="+297">Aruba (+297)</option>
                                                            <option value="+61">Australia (+61)</option>
                                                            <option value="+43">Austria (+43)</option>
                                                            <option value="+994">Azerbaijan (+994)</option>
                                                            <option value="+1">Bahamas (+1)</option>
                                                            <option value="+973">Bahrain (+973)</option>
                                                            <option value="+880">Bangladesh (+880)</option>
                                                            <option value="+1">Barbados (+1)</option>
                                                            <option value="+375">Belarus (+375)</option>
                                                            <option value="+32">Belgium (+32)</option>
                                                            <option value="+501">Belize (+501)</option>
                                                            <option value="+229">Benin (+229)</option>
                                                            <option value="+1">Bermuda (+1)</option>
                                                            <option value="+975">Bhutan (+975)</option>
                                                            <option value="+591">Bolivia (+591)</option>
                                                            <option value="+387">Bosnia and Herzegovina (+387)</option>
                                                            <option value="+267">Botswana (+267)</option>
                                                            <option value="+55">Brazil (+55)</option>
                                                            <option value="+246">British Indian Ocean Territory (+246)</option>
                                                            <option value="+1">British Virgin Islands (+1)</option>
                                                            <option value="+673">Brunei (+673)</option>
                                                            <option value="+359">Bulgaria (+359)</option>
                                                            <option value="+226">Burkina Faso (+226)</option>
                                                            <option value="+257">Burundi (+257)</option>
                                                            <option value="+855">Cambodia (+855)</option>
                                                            <option value="+237">Cameroon (+237)</option>
                                                            <option value="+1">Canada (+1)</option>
                                                            <option value="+238">Cape Verde (+238)</option>
                                                            <option value="+345">Cayman Islands (+345)</option>
                                                            <option value="+236">Central African Republic (+236)</option>
                                                            <option value="+61">Chad (+61)</option>
                                                            <option value="+56">Chile (+56)</option>
                                                            <option value="+86">China (+86)</option>
                                                            <option value="+61">Christmas Island (+61)</option>
                                                            <option value="+672">Cocos (Keeling) Islands (+672)</option>
                                                            <option value="+57">Colombia (+57)</option>
                                                            <option value="+269">Comoros (+269)</option>
                                                            <option value="+242">Congo (+242)</option>
                                                            <option value="+243">Congo, Democratic Republic of the (+243)</option>
                                                            <option value="+682">Cook Islands (+682)</option>
                                                            <option value="+506">Costa Rica (+506)</option>
                                                            <option value="+225">Côte d'Ivoire (+225)</option>
                                                            <option value="+385">Croatia (+385)</option>
                                                            <option value="+53">Cuba (+53)</option>
                                                            <option value="+599">Curaçao (+599)</option>
                                                            <option value="+357">Cyprus (+357)</option>
                                                            <option value="+420">Czech Republic (+420)</option>
                                                            <option value="+45">Denmark (+45)</option>
                                                            <option value="+253">Djibouti (+253)</option>
                                                            <option value="+1">Dominica (+1)</option>
                                                            <option value="+1809">Dominican Republic (+1809)</option>
                                                            <option value="+593">Ecuador (+593)</option>
                                                            <option value="+20">Egypt (+20)</option>
                                                            <option value="+503">El Salvador (+503)</option>
                                                            <option value="+240">Equatorial Guinea (+240)</option>
                                                            <option value="+291">Eritrea (+291)</option>
                                                            <option value="+372">Estonia (+372)</option>
                                                            <option value="+251">Ethiopia (+251)</option>
                                                            <option value="+500">Falkland Islands (+500)</option>
                                                            <option value="+298">Faroe Islands (+298)</option>
                                                            <option value="+679">Fiji (+679)</option>
                                                            <option value="+358">Finland (+358)</option>
                                                            <option value="+33">France (+33)</option>
                                                            <option value="+594">French Guiana (+594)</option>
                                                            <option value="+689">French Polynesia (+689)</option>
                                                            <option value="+241">Gabon (+241)</option>
                                                            <option value="+220">Gambia (+220)</option>
                                                            <option value="+995">Georgia (+995)</option>
                                                            <option value="+49">Germany (+49)</option>
                                                            <option value="+233">Ghana (+233)</option>
                                                            <option value="+350">Gibraltar (+350)</option>
                                                            <option value="+30">Greece (+30)</option>
                                                            <option value="+299">Greenland (+299)</option>
                                                            <option value="+1">Grenada (+1)</option>
                                                            <option value="+590">Guadeloupe (+590)</option>
                                                            <option value="+1">Guam (+1)</option>
                                                            <option value="+502">Guatemala (+502)</option>
                                                            <option value="+224">Guinea (+224)</option>
                                                            <option value="+245">Guinea-Bissau (+245)</option>
                                                            <option value="+592">Guyana (+592)</option>
                                                            <option value="+509">Haiti (+509)</option>
                                                            <option value="+504">Honduras (+504)</option>
                                                            <option value="+852">Hong Kong (+852)</option>
                                                            <option value="+36">Hungary (+36)</option>
                                                            <option value="+354">Iceland (+354)</option>
                                                            <option value="+91">India (+91)</option>
                                                            <option value="+62">Indonesia (+62)</option>
                                                            <option value="+98">Iran (+98)</option>
                                                            <option value="+964">Iraq (+964)</option>
                                                            <option value="+353">Ireland (+353)</option>
                                                            <option value="+972">Israel (+972)</option>
                                                            <option value="+39">Italy (+39)</option>
                                                            <option value="+1">Jamaica (+1)</option>
                                                            <option value="+81">Japan (+81)</option>
                                                            <option value="+44">Jersey (+44)</option>
                                                            <option value="+962">Jordan (+962)</option>
                                                            <option value="+7">Kazakhstan (+7)</option>
                                                            <option value="+254">Kenya (+254)</option>
                                                            <option value="+686">Kiribati (+686)</option>
                                                            <option value="+965">Kuwait (+965)</option>
                                                            <option value="+996">Kyrgyzstan (+996)</option>
                                                            <option value="+856">Laos (+856)</option>
                                                            <option value="+371">Latvia (+371)</option>
                                                            <option value="+961">Lebanon (+961)</option>
                                                            <option value="+266">Lesotho (+266)</option>
                                                            <option value="+231">Liberia (+231)</option>
                                                            <option value="+218">Libya (+218)</option>
                                                            <option value="+423">Liechtenstein (+423)</option>
                                                            <option value="+370">Lithuania (+370)</option>
                                                            <option value="+352">Luxembourg (+352)</option>
                                                            <option value="+261">Madagascar (+261)</option>
                                                            <option value="+265">Malawi (+265)</option>
                                                            <option value="+60">Malaysia (+60)</option>
                                                            <option value="+960">Maldives (+960)</option>
                                                            <option value="+223">Mali (+223)</option>
                                                            <option value="+356">Malta (+356)</option>
                                                            <option value="+692">Marshall Islands (+692)</option>
                                                            <option value="+596">Martinique (+596)</option>
                                                            <option value="+222">Mauritania (+222)</option>
                                                            <option value="+230">Mauritius (+230)</option>
                                                            <option value="+262">Mayotte (+262)</option>
                                                            <option value="+52">Mexico (+52)</option>
                                                            <option value="+691">Micronesia (+691)</option>
                                                            <option value="+373">Moldova (+373)</option>
                                                            <option value="+377">Monaco (+377)</option>
                                                            <option value="+976">Mongolia (+976)</option>
                                                            <option value="+382">Montenegro (+382)</option>
                                                            <option value="+1">Montserrat (+1)</option>
                                                            <option value="+212">Morocco (+212)</option>
                                                            <option value="+258">Mozambique (+258)</option>
                                                            <option value="+95">Myanmar (+95)</option>
                                                            <option value="+264">Namibia (+264)</option>
                                                            <option value="+674">Nauru (+674)</option>
                                                            <option value="+977">Nepal (+977)</option>
                                                            <option value="+31">Netherlands (+31)</option>
                                                            <option value="+687">New Caledonia (+687)</option>
                                                            <option value="+64">New Zealand (+64)</option>
                                                            <option value="+505">Nicaragua (+505)</option>
                                                            <option value="+227">Niger (+227)</option>
                                                            <option value="+234">Nigeria (+234)</option>
                                                            <option value="+683">Niue (+683)</option>
                                                            <option value="+672">Norfolk Island (+672)</option>
                                                            <option value="+1">Northern Mariana Islands (+1)</option>
                                                            <option value="+47">Norway (+47)</option>
                                                            <option value="+968">Oman (+968)</option>
                                                            <option value="+92">Pakistan (+92)</option>
                                                            <option value="+680">Palau (+680)</option>
                                                            <option value="+970">Palestinian Territory (+970)</option>
                                                            <option value="+507">Panama (+507)</option>
                                                            <option value="+675">Papua New Guinea (+675)</option>
                                                            <option value="+595">Paraguay (+595)</option>
                                                            <option value="+51">Peru (+51)</option>
                                                            <option value="+63">Philippines (+63)</option>
                                                            <option value="+48">Poland (+48)</option>
                                                            <option value="+351">Portugal (+351)</option>
                                                            <option value="+1">Puerto Rico (+1)</option>
                                                            <option value="+974">Qatar (+974)</option>
                                                            <option value="+262">Réunion (+262)</option>
                                                            <option value="+40">Romania (+40)</option>
                                                            <option value="+7">Russia (+7)</option>
                                                            <option value="+250">Rwanda (+250)</option>
                                                            <option value="+1">Saint Barthélemy (+1)</option>
                                                            <option value="+508">Saint Helena (+508)</option>
                                                            <option value="+1">Saint Kitts and Nevis (+1)</option>
                                                            <option value="+1">Saint Lucia (+1)</option>
                                                            <option value="+1">Saint Martin (+1)</option>
                                                            <option value="+1">Saint Pierre and Miquelon (+1)</option>
                                                            <option value="+1">Saint Vincent and the Grenadines (+1)</option>
                                                            <option value="+685">Samoa (+685)</option>
                                                            <option value="+378">San Marino (+378)</option>
                                                            <option value="+239">Sao Tome and Principe (+239)</option>
                                                            <option value="+966">Saudi Arabia (+966)</option>
                                                            <option value="+221">Senegal (+221)</option>
                                                            <option value="+381">Serbia (+381)</option>
                                                            <option value="+248">Seychelles (+248)</option>
                                                            <option value="+232">Sierra Leone (+232)</option>
                                                            <option value="+65">Singapore (+65)</option>
                                                            <option value="+421">Slovakia (+421)</option>
                                                            <option value="+386">Slovenia (+386)</option>
                                                            <option value="+677">Solomon Islands (+677)</option>
                                                            <option value="+252">Somalia (+252)</option>
                                                            <option value="+27">South Africa (+27)</option>
                                                            <option value="+82">South Korea (+82)</option>
                                                            <option value="+211">South Sudan (+211)</option>
                                                            <option value="+34">Spain (+34)</option>
                                                            <option value="+94">Sri Lanka (+94)</option>
                                                            <option value="+249">Sudan (+249)</option>
                                                            <option value="+597">Suriname (+597)</option>
                                                            <option value="+47">Svalbard and Jan Mayen (+47)</option>
                                                            <option value="+268">Swaziland (+268)</option>
                                                            <option value="+46">Sweden (+46)</option>
                                                            <option value="+41">Switzerland (+41)</option>
                                                            <option value="+963">Syria (+963)</option>
                                                            <option value="+886">Taiwan (+886)</option>
                                                            <option value="+992">Tajikistan (+992)</option>
                                                            <option value="+255">Tanzania (+255)</option>
                                                            <option value="+66">Thailand (+66)</option>
                                                            <option value="+670">Timor-Leste (+670)</option>
                                                            <option value="+228">Togo (+228)</option>
                                                            <option value="+690">Tokelau (+690)</option>
                                                            <option value="+676">Tonga (+676)</option>
                                                            <option value="+1">Trinidad and Tobago (+1)</option>
                                                            <option value="+216">Tunisia (+216)</option>
                                                            <option value="+90">Turkey (+90)</option>
                                                            <option value="+993">Turkmenistan (+993)</option>
                                                            <option value="+1">Turks and Caicos Islands (+1)</option>
                                                            <option value="+688">Tuvalu (+688)</option>
                                                            <option value="+256">Uganda (+256)</option>
                                                            <option value="+380">Ukraine (+380)</option>
                                                            <option value="+971">United Arab Emirates (+971)</option>
                                                            <option value="+44">United Kingdom (+44)</option>
                                                            <option value="+1">United States (+1)</option>
                                                            <option value="+598">Uruguay (+598)</option>
                                                            <option value="+998">Uzbekistan (+998)</option>
                                                            <option value="+678">Vanuatu (+678)</option>
                                                            <option value="+39">Vatican City (+39)</option>
                                                            <option value="+58">Venezuela (+58)</option>
                                                            <option value="+84">Vietnam (+84)</option>
                                                            <option value="+1">Wallis and Futuna (+1)</option>
                                                            <option value="+681">Western Sahara (+681)</option>
                                                            <option value="+967">Yemen (+967)</option>
                                                            <option value="+260">Zambia (+260)</option>
                                                            <option value="+263">Zimbabwe (+263)</option>
                                                        </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                      <div class="form-group">
                                                          <label for="mobile">Primary Phone (Mobile)</label>
                                                          <input type="number" class="form-control" name="mobile" id="mobile" autocomplete="off" />
                                                      </div>
                                                      <small id="error-message" class="text-danger"></small>
                                                  </div>
                                                  <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                      <div class="form-group">
                                                          <label for="phone">Secondary Phone</label>
                                                          <input type="number" class="form-control" name="phone"
                                                              id="phone" autocomplete="off" />
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
                                                          <input type="text" class="form-control"
                                                              name="gender" id="gender" autocomplete="off" />
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
                                                                          {{ $mentor->getdevotee->firstname }}
                                                                          {{ $mentor->getdevotee->middlename }}
                                                                          {{ $mentor->getdevotee->surname }}</option>
                                                                  @endforeach
                                                              @endif
                                                          </select>
                                                      </div>
                                                  </div>

                                                  <div class="col-md-4 col-sm-4 col-lg-4 mb-4">
                                                      <div class="form-group">
                                                          <label for="branch">Branch <span class="required"></span></label>
                                                          <select class="form-control" id="branch" name="branch" required>
                                                              <option value="">Select One</option>
                                                              @if($branches->count() != NULL)
                                                                @foreach($branches as $branch)
                                                                  <option value="{{$branch->id}}">{{$branch->title}}</option>
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
                                                    <div class="mt-10 mb-5"><input type="checkbox" class="form-check-input" value="1" id="lifemember" name="lifemember" /> Life Member<br />
                                                    </div>
                                                  </div>
                                              </div>

                                              <h4 class="mt-5">Identity Details</h4>
                                              <div class="row">
                                                <div class="col-md-3 col-sm-3 col-lg-3 mb-4">
                                                  <div class="form-group">
                                                      <label for="nationality">Nationality</label>
                                                      <select class="form-control" name="nationality" id="nationality" data-control="select2">
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
                                                          <select class="form-control" name="tcategory" id="tcategory">
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
                                                          <label for="ttole">Municipality</label>
                                                          <select class="form-control" name="tmunicipalities"
                                                              id="tmunicipalities">
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
                                                    <input type="hidden" class="form-control" name="devoteefamily" id="devoteefamily" autocomplete="off" value="{{$show->id}}"  />
                                                      <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create Devotee</button>
                                                  </div>
                                              </div>
                                          </form>
                                        </div>
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
@php
$today = date('Y-m-d');
$nextdate = date('Y-m-d', strtotime('+5 year'));
@endphp
<script type="text/javascript">
    $(document).ready(function() {
        $("#dobad").flatpickr({ dateFormat: "Y-m-d", disable: [{from:'{{$today}}', to:'{{$nextdate}}'}] });
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
$('#relationtype').on('change', function() {
  if (( this.value == 'new')){
    $("#new").show();
    $("#existing").hide();
  }
  if (( this.value == 'existing')){
    $("#existing").show();
    $("#new").hide();
  }
});
$("#existing").hide();
$("#new").hide();
</script>
<script type="text/javascript">
// Format options
const optionFormat = (item) => {
  if (!item.id) {
      return item.text;
  }

  var span = document.createElement('span');
  var template = '';

  template += '<div class="d-flex align-items-center">';
  template += '<div class="d-flex flex-column">'
  template += '<span class="fs-4 fw-bold lh-1">' + item.text + '</span>';
  template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-kt-rich-content-initiation') + '</span>';
  template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-kt-rich-content-email') + '</span>';
  template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-kt-rich-content-mobile') + '</span>';
  template += '</div>';
  template += '</div>';

  span.innerHTML = template;

  return $(span);
}

// Init Select2 --- more info: https://select2.org/
$('#devotee_id').select2({
  placeholder: "Select an option",
  templateSelection: optionFormat,
  templateResult: optionFormat
});
</script>
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
$('#dobtype').on('change', function() {
  if (( this.value == 'AD')){
    $("#dobad").show();
    $("#dobbs").hide();
  }
  if (( this.value == 'BS')){
    $("#dobbs").show();
    $("#dobad").hide();
  }
});
$("#dobad").hide();
$("#dobbs").hide();
</script>
@endsection
