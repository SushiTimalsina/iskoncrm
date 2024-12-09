<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Devotees;
use App\Models\AttendSewa;
use App\Models\Donation;
use App\Models\Sewa;
use App\Models\Courses;
use App\Models\Mentor;
use App\Models\Occupation;
use App\Models\Skills;
use App\Models\DevoteeSkills;
use App\Models\InitiativeGuru;
use Illuminate\Support\Str;
use App\Mail\WelcomeEmail;
use App\Models\DevoteeFamilyMember;
use App\Models\Initiation;
use App\Imports\DevoteeImport;
use Sagautam5\LocalStateNepal\Entities\Category;
use Sagautam5\LocalStateNepal\Entities\Province;
use Sagautam5\LocalStateNepal\Entities\District;
use Sagautam5\LocalStateNepal\Entities\Municipality;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DevoteeExport;
use App\Http\Requests\StoreDevoteeRequest;
use App\Models\AttendCourse;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Session;
use Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DevoteesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  function __construct()
  {
    $this->middleware('permission:devotee-list|devotee-create|devotee-edit|devotee-delete', ['only' => ['index', 'show', 'filter']]);
    $this->middleware('permission:devotee-create', ['only' => ['create', 'store', 'profileimage', 'devoteeimportget', 'devoteeimport']]);
    $this->middleware('permission:devotee-edit', ['only' => ['edit', 'update', 'profileimageupdate']]);
    $this->middleware('permission:devotee-delete', ['only' => ['destroy', 'download', 'delete', 'mentorupdate']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    try {
      $user = Auth::guard('admin')->user();
      $province = new Province('en');
      $provincesData = $province->getProvincesWithDistrictsWithMunicipalities();

      $categories = new Category('en');
      $categoriesdata = $categories->allcategories();

      $devotees = Devotees::all();
      $branches = Branch::where('status', 'Active')->get();
      $mentors = Mentor::where('status', 'Active')->get();
      $gurus = InitiativeGuru::where('status', 'Active')->get();
      $occupations = Occupation::where('parent_id', NULL)->with('subcategory')->orderBy('title', 'asc')->where('status', 'Active')->get();
      activity('Devotee')->log('Viewed lists');

      if ($user->is_admin == 1) {
        $lists = Devotees::orderBy('created_at', 'desc')->paginate(50);
      } elseif ($user->is_admin == 2) {
        $lists = Devotees::orderBy('created_at', 'desc')->where('branch_id', $user->branch_id)->paginate(50);
      } else {
        $lists = Devotees::orderBy('created_at', 'desc')->where('branch_id', $user->branch_id)->paginate(50);
      }

      return view('backend.devotees.index', compact('branches', 'devotees', 'mentors', 'gurus', 'lists', 'provincesData', 'categoriesdata', 'occupations'));
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.');
    }
  }

  public function trash()
  {
    try {
      $province = new Province('en');
      $provincesData = $province->getProvincesWithDistrictsWithMunicipalities();

      $categories = new Category('en');
      $categoriesdata = $categories->allcategories();

      $devotees = Devotees::all();
      $branches = Branch::where('status', 'Active')->get();
      $mentors = Mentor::where('status', 'Active')->get();
      $gurus = InitiativeGuru::where('status', 'Active')->get();
      $occupations = Occupation::where('parent_id', NULL)->with('subcategory')->orderBy('title', 'asc')->where('status', 'Active')->get();
      activity('Devotee')->log('Viewed lists');
      $lists = Devotees::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
      return view('backend.devotees.index', compact('branches', 'devotees', 'mentors', 'gurus', 'lists', 'provincesData', 'categoriesdata', 'occupations'));
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.' . $e->getMessage());
    }
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function searchfilter(Request $request)
  {
    /* try{ */
    $province = new Province('en');
    $provincesData = $province->getProvincesWithDistrictsWithMunicipalities();

    $categories = new Category('en');
    $categoriesdata = $categories->allcategories();

    $devotees = Devotees::all();
    $branches = Branch::where('status', 'Active')->get();
    $mentors = Mentor::where('status', 'Active')->get();
    $gurus = InitiativeGuru::where('status', 'Active')->get();
    $occupations = Occupation::where('parent_id', NULL)->with('subcategory')->orderBy('title', 'asc')->where('status', 'Active')->get();
    activity('Devotee')->log('Viewed lists');

    $json = $request['search'];
    //$json = json_decode($json);
    //$getvalues = collect($json)->pluck('value')->toArray();

    if ($json != NULL) {
      //$lists = Devotees::whereIn('id', $getvalues)->orderBy('created_at', 'desc')->paginate(50);
      $lists = Devotees::whereIn('id', $request['search'])->orderBy('created_at', 'desc')->paginate(50);
    } else {
      $query = Devotees::orderBy('created_at', 'desc')->where('status', '!=', 'Trash');
      if ($request['bloodgroup']) {
        $query->where('bloodgroup', '=', $request['bloodgroup']);
      }

      if ($request['education']) {
        $query->where('education', '=', $request['education']);
      }

      if ($request['occupation']) {
        $query->where('occupations', '=', $request['occupation']);
      }

      if ($request['gotra']) {
        $query->where('gotra', '=', $request['gotra']);
      }

      if ($request['branch']) {
        $query->where('branch_id', '=', $request['branch']);
      }

      if ($request['mentor']) {
        $query->where('mentor', '=', $request['mentor']);
      }

      if ($request['daterange']) {
        $dates = explode(' - ', $request['daterange']);
        $query->whereBetween('created_at', [$dates[0] . " 00:00:00", $dates[1] . " 23:59:59"]);
      }
      $lists = $query->paginate(50);
    }

    return view('backend.devotees.index', compact('branches', 'devotees', 'mentors', 'gurus', 'lists', 'provincesData', 'categoriesdata', 'occupations'));
    /*} catch (\Exception $e) {
        return redirect('/devotees')->with('error', 'An error occurred, please try again.');
      }*/
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function searchbyid(Request $request)
  {
    try {
      $id = $request['id'];
      $view = Devotees::findorfail($id);
      return redirect('/admin/devotees/' . $id);
      activity('Devotee')->log('Devotee Search by ID: ' . $id);
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'Not Found, Please confirm the Id and try again.');
    }
  }

  public function searchbyqrid(Request $request)
  {
    try {
      $id = $request['id'];
      $parts = explode('-', $id);
      $lastPart = end($parts);
      $view = Devotees::findorfail($lastPart);
      activity('Devotee')->log('Devotee Scan by ID: ' . $lastPart);
      return redirect('/admin/devotees/' . $lastPart);
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'Not Found, Please confirm the Id and try again.');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    try {
      $request->session()->forget('devotee');
      $devotees = Devotees::all();
      $mentors = Mentor::where('status', 'Active')->get();
      $initiativegurus = InitiativeGuru::where('status', 'Active')->get();
      activity('Devotee')->log('Create Page Open');
      $devotee = $request->session()->get('devotee');
      $occupations = Occupation::where('parent_id', NULL)->with('subcategory')->orderBy('title', 'asc')->where('status', 'Active')->get();
      return view('backend.devotees.create', compact('devotees', 'mentors', 'initiativegurus', 'devotee', 'occupations'));
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.');
    }
  }

  public function posdevoteesearch(Request $request)
  {
    $validatedData = $request->validate([
      'email' => 'nullable|email:rfc,dns',
      'mobile' => 'nullable',
      'firstname' => 'required',
      'middlename' => 'nullable',
      'gender' => 'required',
      'surname' => 'required',
      'countrycode' => 'nullable'
    ]);

    $checkemail = Devotees::where('email', hash('sha256', $request->email))->exists();
    $checkmobile = Devotees::Where('mobile', hash('sha256', $request->mobile))->exists();

    if (($checkemail || $checkmobile)) {
      $request->session()->forget('devotee');
      return redirect()->back()->with('error', 'Duplicate data found!');
    } else {
      activity('Devotee')->log('Create step 2');
      if (($request['email'] != NULL) || ($request['mobile'] != NULL)) {
        $firstname = $request['firstname'];
        $middlename = $request['middlename'];
        $surname = $request['surname'];
        $email = $request['email'];
        $countrycode = $request['countrycode'];
        $mobile = $request['mobile'];
        $gender = $request['gender'];

        $checkrow = Devotees::where('email', '=', $email)->first();
        $checkrow1 = Devotees::where('mobile', '=', $mobile)->first();

        $devotees = Devotees::all();
        $mentors = Mentor::where('status', 'Active')->get();
        $initiativegurus = InitiativeGuru::where('status', 'Active')->get();

        if (empty($request->session()->get('devotee'))) {
          $devotee = new Devotees();
          $devotee->fill($validatedData);
          $request->session()->put('devotee', $devotee);
        } else {
          $devotee = $request->session()->get('devotee');
          $devotee->fill($validatedData);
          $request->session()->put('devotee', $devotee);
        }
        return redirect('/admin/devotee-create-step-two');
        //$request->session()->forget('devotee');
        //return redirect('/devotees')->with('error', 'Data duplication found.');
      } else {
        $request->session()->forget('devotee');
        return redirect()->back()->with('error', 'Please enter email or mobile as primary data.');
      }
    }
  }

  public function createStepTwo(Request $request)
  {
    $province = new Province('en');
    $provincesData = $province->getProvincesWithDistrictsWithMunicipalities();

    $categories = new Category('en');
    $categoriesdata = $categories->allcategories();

    $municipalitie = new Municipality('en');
    $municipalities = $municipalitie->allMunicipalities();

    $devotee = $request->session()->get('devotee');
    $devotees = Devotees::all();
    $mentors = Mentor::where('status', 'Active')->get();
    $initiativegurus = InitiativeGuru::where('status', 'Active')->get();
    $occupations = Occupation::where('parent_id', NULL)->with('subcategory')->orderBy('title', 'asc')->where('status', 'Active')->get();
    $skilllists = Skills::where('status', 'Active')->get();
    return view('backend.devotees.createfinal', compact('devotee', 'devotees', 'mentors', 'provincesData', 'categoriesdata', 'initiativegurus', 'occupations', 'skilllists'));
  }
  /*
    public function encryptdata()
    {
      $getdevotees = Devotees::all();
      foreach($getdevotees as $devotee){

        if($devotee->email != NULL){
          $hashemail = hash('sha256', $devotee->email);
        }else{
          $hashemail = NULL;
        }

        if($devotee->email != NULL){
          $email = Crypt::encrypt($devotee->email);
        }else{
          $email = NULL;
        }

        if($devotee->mobile != NULL){
          $hashmobile = hash('sha256', $devotee->mobile);
        }else{
          $hashmobile = NULL;
        }

        if($devotee->mobile != NULL){
          $mobile = Crypt::encrypt($devotee->mobile);
        }else{
          $mobile = NULL;
        }

        if($devotee->identityid != NULL){
          $hashidentityid = hash('sha256', $devotee->identityid);
        }else{
          $hashidentityid = NULL;
        }

        if($devotee->identityid != NULL){
          $identityid_enc = Crypt::encrypt($devotee->identityid);
        }else{
          $identityid_enc = NULL;
        }

        Devotees::whereId($devotee->id)->update([
          'firstname' => Crypt::encrypt($devotee->firstname),
          'middlename' => Crypt::encrypt($devotee->middlename),
          'surname' => Crypt::encrypt($devotee->surname),
          'email' => $hashemail,
          'email_enc' => $email,
          'mobile' => $hashmobile,
          'mobile_enc' => $mobile,
          'phone' => Crypt::encrypt($devotee->phone),
          'identitytype' => Crypt::encrypt($devotee->identitytype),
          'identityid' => $hashidentityid,
          'identityid_enc' => $identityid_enc,
          'dob' => Crypt::encrypt($devotee->dob),
          'ptole' => Crypt::encrypt($devotee->ptole),
          'pwardno' => Crypt::encrypt($devotee->pwardno),
          'pmuni' => Crypt::encrypt($devotee->pmuni),
          'pdistrict' => Crypt::encrypt($devotee->pdistrict),
          'pprovince' => Crypt::encrypt($devotee->pprovince),
          'ttole' => Crypt::encrypt($devotee->ttole),
          'twardno' => Crypt::encrypt($devotee->twardno),
          'tmuni' => Crypt::encrypt($devotee->tmuni),
          'tdistrict' => Crypt::encrypt($devotee->tdistrict),
          'tprovince' => Crypt::encrypt($devotee->tprovince)
        ]);
      }
      return redirect('/admin/devotees/')->with('success', 'Data enc successfully');
    }*/


  public function store(Request $request)
  {
    $devotee = $request->session()->get('devotee');
    $user = Auth::guard('admin')->user();
    $identity = $request->file('identityimage');
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

    if ($identity != '') {
      $idname = $this->getIdentityName($request['identitytype']);
      $identityname = $idname . '-' . substr(str_shuffle($permitted_chars), 0, 4) . '.' . $request->file('identityimage')->getClientOriginalExtension();
      $identitypath = "devoteeids/";
      Storage::disk('local')->put($identitypath . $identityname, file_get_contents($request->file('identityimage')));
    } else {
      $identityname = '';
    }

    $isSameAsPermanent = $request->has('filladdress') && $request['filladdress'] == 'on';

    if ($request['dobtype'] == 'BS') {
      $dob = Crypt::encrypt($request['dobbs']);
    } else if ($request['dobtype'] == 'AD') {
      $dob = Crypt::encrypt($request['dobad']);
    } else {
      $dob = NULL;
    }

    if ($devotee->email != NULL) {
      $hashemail = hash('sha256', $devotee->email);
      $email = Crypt::encrypt($devotee->email);
    } else {
      $hashemail = NULL;
      $email = NULL;
    }

    if ($devotee->mobile != NULL) {
      $hashmobile = hash('sha256', $devotee->mobile);
      $mobile = Crypt::encrypt($devotee->mobile);
    } else {
      $hashmobile = NULL;
      $mobile = NULL;
    }

    if ($request['identityno'] != NULL) {
      $hashidentityid = hash('sha256', $request['identityno']);
      $identityid_enc = Crypt::encrypt($request['identityno']);
    } else {
      $hashidentityid = NULL;
      $identityid_enc = NULL;
    }

    if ($devotee->firstname != NULL) {
      $firstname = Crypt::encrypt($devotee->firstname);
    } else {
      $firstname = NULL;
    }
    if ($devotee->middlename != NULL) {
      $middlename = Crypt::encrypt($devotee->middlename);
    } else {
      $middlename = NULL;
    }
    if ($devotee->surname != NULL) {
      $surname = Crypt::encrypt($devotee->surname);
    } else {
      $surname = NULL;
    }
    if ($devotee->phone != NULL) {
      $phone = Crypt::encrypt($devotee->phone);
    } else {
      $phone = NULL;
    }

    if ($request['identitytype'] != NULL) {
      $identitytype = Crypt::encrypt($request['identitytype']);
    } else {
      $identitytype = NULL;
    }
    if ($request['ptole'] != NULL) {
      $ptole = Crypt::encrypt($request['ptole']);
    } else {
      $ptole = NULL;
    }
    if ($request['pwardno'] != NULL) {
      $pwardno = Crypt::encrypt($request['pwardno']);
    } else {
      $pwardno = NULL;
    }
    if ($request['pmuni'] != NULL) {
      $pmuni = Crypt::encrypt($request['pmuni']);
    } else {
      $pmuni = NULL;
    }
    if ($request['pdistrict'] != NULL) {
      $pdistrict = Crypt::encrypt($request['pdistrict']);
    } else {
      $pdistrict = NULL;
    }
    if ($request['province'] != NULL) {
      $province = Crypt::encrypt($request['province']);
    } else {
      $province = NULL;
    }
    if ($request['tprovince'] != NULL) {
      $tprovince = Crypt::encrypt($request['tprovince']);
    } else {
      $tprovince = NULL;
    }
    if ($request['tdistrict'] != NULL) {
      $tdistrict = Crypt::encrypt($request['tdistrict']);
    } else {
      $tdistrict = NULL;
    }
    if ($request['tcategory'] != NULL) {
      $tcategory = Crypt::encrypt($request['tcategory']);
    } else {
      $tcategory = NULL;
    }
    if ($request['tmunicipalities'] != NULL) {
      $tmunicipalities = Crypt::encrypt($request['tmunicipalities']);
    } else {
      $tmunicipalities = NULL;
    }
    if ($request['twardno'] != NULL) {
      $twardno = Crypt::encrypt($request['twardno']);
    } else {
      $twardno = NULL;
    }

    $createrow = Devotees::create([
      'firstname' => $firstname,
      'middlename' => $middlename,
      'surname' => $surname,
      'mentor' => $request['mentor'],
      'gotra' => $request['gotra'],
      'email' => $hashemail,
      'email_enc' => $email,
      'countrycode' => $devotee->countrycode,
      'mobile' => $hashmobile,
      'mobile_enc' => $mobile,
      'phone' => $phone,
      'identitytype' => $identitytype,
      'identityid' => $hashidentityid,
      'identityid_enc' => $identityid_enc,
      'identityimage' => $identityname,
      'dob' => $dob,
      'dobtype' => $request['dobtype'],
      'member' => $request['lifemember'],
      'bloodgroup' => $request['bloodgroup'],
      'gender' => $request->gender,
      'education' => $request['education'],
      'occupations' => $request['occupation'],
      'branch_id' => $user->branch_id,
      'ptole' => $ptole,
      'pwardno' => $pwardno,
      'pmuni' => $pmuni,
      'pdistrict' => $pdistrict,
      'pprovince' => $province,
      'tprovince' => $isSameAsPermanent ? $province : $tprovince,
      'tdistrict' => $isSameAsPermanent ? $pdistrict : $tdistrict,
      'tmuni' => $isSameAsPermanent ? $pmuni : $tcategory,
      'ttole' => $isSameAsPermanent ? $ptole : $tmunicipalities,
      'twardno' => $isSameAsPermanent ? $pwardno : $twardno,
      'createdby' => $user->id,
      'status' => 'Active',
      'marital_status' => $request['maritalstatus'],
      'nationality' => $request['nationality'],
    ]);


    $getdevotee = Devotees::find($createrow->id);

    $subject = 'Welcome to Iskcon!';
    $data = [
      'name' => $getdevotee->firstname . ' ' . $getdevotee->middlename . ' ' . $getdevotee->surname
    ];

    /*Mail::mailer('smtp')
      ->to($getdevotee->email)
      ->send(new WelcomeEmail($subject, $data));*/

    activity('Devotee')->log('Created.');
    $request->session()->forget('devotee');
    return redirect('/admin/devotees/' . $createrow->id)->with('success', 'Data created successfully');
  }

  public function createrelation(Request $request, $id)
  {
    try {
      $devotees = Devotees::all();
      $mentors = Mentor::where('status', 'Active')->get();
      $initiativegurus = InitiativeGuru::where('status', 'Active')->get();
      activity('Devotee')->log('Create Page Open');
      $occupations = Occupation::where('parent_id', NULL)->with('subcategory')->orderBy('title', 'asc')->where('status', 'Active')->get();
      $province = new Province('en');
      $provincesData = $province->getProvincesWithDistrictsWithMunicipalities();
      $categories = new Category('en');
      $categoriesdata = $categories->allcategories();
      $branches = Branch::where('status', 'Active')->get();
      $show = Devotees::find($id);
      $municipalitie = new Municipality('en');
      $municipalities = $municipalitie->allMunicipalities();
      return view('backend.devotees.createrelation', compact('devotees', 'mentors', 'initiativegurus', 'occupations', 'provincesData', 'categoriesdata', 'show', 'branches'));
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.' . $e->getMessage());
    }
  }
  public function devoteerelationstore(Request $request)
  {
    try {
      $user = Auth::guard('admin')->user();
      if ($request['devotee_id'] != 0) {
        $createrow = DevoteeFamilyMember::create([
          'createdby' => $user->id,
          'devotees_id' => $request['devoteefamily'],
          'devotee_id' => $request['devotee_id'],
          'role' => $request['relation']
        ]);
        $getdevotee = Devotees::find($request['devotee_id']);
        activity('Devotee')->log('Relation Created: ' . $getdevotee->firstname . ' ' . $getdevotee->middlename . ' ' . $getdevotee->surname);
        return redirect('/admin/devotees/' . $request['devotee_id'])->with('success', 'Data created successfully');
      } else {
        $devoteerow = Devotees::find($user->devotee_id);
        $identity = $request->file('identityimage');
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

        if ($identity != '') {
          $idname = $this->getIdentityName($request['identitytype']);
          $identityname = $idname . '-' . substr(str_shuffle($permitted_chars), 0, 4) . '.' . $request->file('identityimage')->getClientOriginalExtension();
          $identitypath = "devoteeids/";
          Storage::disk('local')->put($identitypath . $identityname, file_get_contents($request->file('identityimage')));
        } else {
          $identityname = '';
        }

        $isSameAsPermanent = $request->has('filladdress') && $request['filladdress'] == 'on';

        if ($request['dobtype'] == 'BS') {
          $dob = Crypt::encrypt($request['dobbs']);
        } else if ($request['dobtype'] == 'AD') {
          $dob = Crypt::encrypt($request['dobad']);
        } else {
          $dob = NULL;
        }

        if ($request['email'] != NULL) {
          $hashemail = hash('sha256', $request['email']);
          $email = Crypt::encrypt($request['email']);
        } else {
          $hashemail = NULL;
          $email = NULL;
        }

        if ($request['mobile'] != NULL) {
          $hashmobile = hash('sha256', $request['mobile']);
          $mobile = Crypt::encrypt($request['mobile']);
        } else {
          $hashmobile = NULL;
          $mobile = NULL;
        }

        if ($request['identityno'] != NULL) {
          $hashidentityid = hash('sha256', $request['identityno']);
          $identityid_enc = Crypt::encrypt($request['identityno']);
        } else {
          $hashidentityid = NULL;
          $identityid_enc = NULL;
        }

        if ($request['firstname'] != NULL) {
          $firstname = Crypt::encrypt($request['firstname']);
        } else {
          $firstname = NULL;
        }
        if ($request['middlename'] != NULL) {
          $middlename = Crypt::encrypt($request['middlename']);
        } else {
          $middlename = NULL;
        }
        if ($request['surname'] != NULL) {
          $surname = Crypt::encrypt($request['surname']);
        } else {
          $surname = NULL;
        }
        if ($request['phone'] != NULL) {
          $phone = Crypt::encrypt($request['phone']);
        } else {
          $phone = NULL;
        }

        if ($request['identitytype'] != NULL) {
          $identitytype = Crypt::encrypt($request['identitytype']);
        } else {
          $identitytype = NULL;
        }
        if ($request['ptole'] != NULL) {
          $ptole = Crypt::encrypt($request['ptole']);
        } else {
          $ptole = NULL;
        }
        if ($request['pwardno'] != NULL) {
          $pwardno = Crypt::encrypt($request['pwardno']);
        } else {
          $pwardno = NULL;
        }
        if ($request['pmuni'] != NULL) {
          $pmuni = Crypt::encrypt($request['pmuni']);
        } else {
          $pmuni = NULL;
        }
        if ($request['pdistrict'] != NULL) {
          $pdistrict = Crypt::encrypt($request['pdistrict']);
        } else {
          $pdistrict = NULL;
        }
        if ($request['province'] != NULL) {
          $province = Crypt::encrypt($request['province']);
        } else {
          $province = NULL;
        }
        if ($request['tprovince'] != NULL) {
          $tprovince = Crypt::encrypt($request['tprovince']);
        } else {
          $tprovince = NULL;
        }
        if ($request['tdistrict'] != NULL) {
          $tdistrict = Crypt::encrypt($request['tdistrict']);
        } else {
          $tdistrict = NULL;
        }
        if ($request['tcategory'] != NULL) {
          $tcategory = Crypt::encrypt($request['tcategory']);
        } else {
          $tcategory = NULL;
        }
        if ($request['tmunicipalities'] != NULL) {
          $tmunicipalities = Crypt::encrypt($request['tmunicipalities']);
        } else {
          $tmunicipalities = NULL;
        }
        if ($request['twardno'] != NULL) {
          $twardno = Crypt::encrypt($request['twardno']);
        } else {
          $twardno = NULL;
        }


        $createrow = Devotees::create([
          'firstname' => $firstname,
          'middlename' => $middlename,
          'surname' => $surname,
          'mentor' => $request['mentor'],
          'gotra' => $request['gotra'],
          'email' => $hashemail,
          'email_enc' => $email,
          'countrycode' => $request['countrycode'],
          'mobile' => $hashmobile,
          'mobile_enc' => $mobile,
          'phone' => $phone,
          'identitytype' => $identitytype,
          'identityid' => $hashidentityid,
          'identityid_enc' => $identityid_enc,
          'identityimage' => $identityname,
          'dob' => $dob,
          'dobtype' => $request['dobtype'],
          'member' => $request['lifemember'],
          'bloodgroup' => $request['bloodgroup'],
          'gender' => $request->gender,
          'education' => $request['education'],
          'occupations' => $request['occupation'],
          'branch_id' => $request['branch'],
          'ptole' => $ptole,
          'pwardno' => $pwardno,
          'pmuni' => $pmuni,
          'pdistrict' => $pdistrict,
          'pprovince' => $province,
          'tprovince' => $isSameAsPermanent ? $province : $tprovince,
          'tdistrict' => $isSameAsPermanent ? $pdistrict : $tdistrict,
          'tmuni' => $isSameAsPermanent ? $pmuni : $tcategory,
          'ttole' => $isSameAsPermanent ? $ptole : $tmunicipalities,
          'twardno' => $isSameAsPermanent ? $pwardno : $twardno,
          'createdby' => $user->id,
          'status' => 'Active',
          'marital_status' => $request['maritalstatus'],
          'nationality' => $request['nationality'],
        ]);

        $createrow = DevoteeFamilyMember::create([
          'createdby' => $user->id,
          'devotees_id' => $request['devoteefamily'],
          'devotee_id' => $createrow->id,
          'role' => $request['relation']
        ]);

        $getdevotee = Devotees::find($createrow->id);
        activity('Devotee')->log('Created');
        return redirect('/admin/devotees/' . $createrow->id)->with('success', 'Data created successfully');
      }
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.' . $e->getMessage());
    }
  }

  private function getIdentityName($identityType)
  {
    $identityNames = [
      'National ID' => 'NI',
      'Citizenship' => 'CC',
      'Passport' => 'PP',
      'Vote Card' => 'VC',
      'Student Card' => 'SC',
      'Profession Card' => 'PC',
      'Iskcon Card' => 'IC'
    ];

    return $identityNames[$identityType] ?? substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 4);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    // dd("kjans");
    $province = new Province('en');
    $categories = new Category('en');
    $district = new District('en');
    $municipalities = new Municipality('en');

    $provincesData = $province->getProvincesWithDistrictsWithMunicipalities();
    $categoriesdata = $categories->allcategories();

    $view = Devotees::findOrFail($id);

    if ($view->pprovince != NULL) {
      $provinceId = $view->pprovince;
      $provincebyId = $province->find(Crypt::decrypt($provinceId));
    } else {
      $provincebyId = NULL;
    }

    if ($view->pdistrict != NULL) {
      $districtId = $view->pdistrict;
      $districtbyId = $district->find(Crypt::decrypt($districtId));
    } else {
      $districtbyId = NULL;
    }

    if ($view->ptole != NULL) {
      $toleId = $view->ptole;
      $tolebyId = $municipalities->find(Crypt::decrypt($toleId));
    } else {
      $tolebyId = NULL;
    }

    if ($view->pmuni != NULL) {
      $catogeryId = $view->pmuni;
      $catogerybyId = $categories->find(Crypt::decrypt($catogeryId));
    } else {
      $catogerybyId = NULL;
    }


    if ($view->tprovince != NULL) {
      $tprovinceId = $view->tprovince;
      $tprovincebyId = $province->find(Crypt::decrypt($tprovinceId));
    } else {
      $tprovincebyId = NULL;
    }

    if ($view->tdistrict != NULL) {
      $tprovinceId = $view->tdistrict;
      $tdistrictbyId = $district->find(Crypt::decrypt($tprovinceId));
    } else {
      $tdistrictbyId = NULL;
    }
    if ($view->ptole != NULL) {
      $toleId = $view->ptole;
      $tolebyId = $municipalities->find(Crypt::decrypt($toleId));
    } else {
      $tolebyId = NULL;
    }

    if ($view->ttole != NULL) {
      $ttoleId = $view->ttole;
      $ttolebyId = $municipalities->find(Crypt::decrypt($ttoleId));
    } else {
      $ttolebyId = NULL;
    }

    if ($view->tmuni != NULL) {
      $tcatogeryId = $view->tmuni;
      $tcatogerybyId = $categories->find(Crypt::decrypt($tcatogeryId));
    } else {
      $tcatogerybyId = NULL;
    }

    $view = Devotees::find($id);
    $devotees = Devotees::all();
    $attendsewas = AttendSewa::where('devotee_id', $id)->orderBy('created_at', 'desc')->paginate(50);
    $attendcourses = AttendCourse::where('devotee_id', $id)->orderBy('created_at', 'desc')->paginate(50);

    $donations = Donation::where('devotee_id', $id)->orderBy('created_at', 'desc')->paginate(50);
    $donationget = Donation::where('devotee_id', $id)->sum('donation');
    $branches = Branch::where('status', 'Active')->get();
    $courses = Courses::where('status', 'Active')->get();
    $departments = Department::where('status', 'Active')->get();
    $initiativegurus = InitiativeGuru::where('status', 'Active')->get();
    $occupations = Occupation::where('parent_id', NULL)->with('subcategory')->orderBy('title', 'asc')->where('status', 'Active')->get();
    $sewas = Sewa::where('status', 'Active')->get();
    $mentors = Mentor::where('status', 'Active')->get();
    $skills = DevoteeSkills::where('devotee_id', $id)->get();
    $skilllists = Skills::where('status', 'Active')->get();
    activity('Devotee')->log('Viewed');
    $initiationcheck = Initiation::where('devotee_id', $id)->get();

    return view('backend.devotees.view', compact(
      'view',
      'attendsewas',
      'attendcourses',
      'devotees',
      'branches',
      'departments',
      'donations',
      'sewas',
      'donationget',
      'courses',
      'initiativegurus',
      'initiationcheck',
      'mentors',
      'provincesData',
      'categoriesdata',
      'provincebyId',
      'districtbyId',
      'tolebyId',
      'catogerybyId',
      'tcatogerybyId',
      'ttolebyId',
      'tdistrictbyId',
      'tprovincebyId',
      'occupations',
      'skills',
      'skilllists'
    ));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    try {
      $province = new Province('en');
      $categories = new Category('en');
      $provincesData = $province->getProvincesWithDistrictsWithMunicipalities();
      $categoriesdata = $categories->allcategories();
      $district = new District('en');
      $municipalities = new Municipality('en');

      $edit = Devotees::find($id);
      $provinceId = $edit->pprovince;
      $provincebyId = $province->find(Crypt::decrypt($provinceId));
      // dd($provincebyId);
      $provincename = optional($provincebyId)->name ?? '';

      $districtId = $edit->pdistrict;
      $districtbyId = $district->find(Crypt::decrypt($districtId));
      $districtname = optional($districtbyId)->name ?? '';

      $tdistrictId = $edit->tdistrict;
      $tdistrictbyId = $district->find(Crypt::decrypt($tdistrictId));
      $tdistrictname = optional($tdistrictbyId)->name ?? '';

      $toleId = $edit->ptole;
      $tolebyId = $municipalities->find(Crypt::decrypt($toleId));
      $tolename = optional($tolebyId)->name ?? '';

      $ttoleId = $edit->ttole;
      $ttolebyId = $municipalities->find(Crypt::decrypt($ttoleId));
      // dd($ttolebyId);
      $ttolename = optional($ttolebyId)->name ?? '';

      $pmuniId = $edit->pmuni;
      $catogerybyId = $categories->find(Crypt::decrypt($pmuniId));

      $devotees = Devotees::all();
      $branches = Branch::where('status', 'Active')->get();
      $initiativegurus = InitiativeGuru::where('status', 'Active')->get();
      $mentors = Mentor::where('status', 'Active')->get();
      $occupations = Occupation::where('parent_id', NULL)->with('subcategory')->orderBy('title', 'asc')->where('status', 'Active')->get();
      activity('Devotee')->log('Edit viewed id ' . $id);

      return view('backend.devotees.edit', compact(
        'edit',
        'branches',
        'devotees',
        'initiativegurus',
        'mentors',
        'provincesData',
        'categoriesdata',
        'districtbyId',
        'districtname',
        'provincebyId',
        'tolebyId',
        'tolename',
        'tdistrictbyId',
        'tdistrictname',
        'ttolebyId',
        'ttolename',
        'occupations'
      ));
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    try {
      // Define custom error messages
      /*$messages = [
            'email.unique.nullable' => 'The email address is already in use by another devotee.',
            'mobile.unique' => 'The mobile number is already in use by another devotee.',
          ];*/

      // Validate the incoming data with uniqueness checks, excluding the current record
      /*$validatedData = $request->validate([
            'email' => 'nullable|unique:devotees,email,' . $id,
            'mobile' => 'nullable|unique:devotees,mobile,' . $id,
          ], $messages);*/

      $user = Auth::guard('admin')->user();
      $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
      $identity = $request->file('identityimage');

      if ($request['removeid'] == 1) {
        $row = Devotees::findOrFail($id);
        if ($row->identityimage != '') {
          Storage::disk('local')->delete('devoteeids/' . $row->identityimage);
        }
        $identityname = '';
      } else {
        if ($request->hasFile('identityimage')) {
          $datas = Devotees::findOrFail($id);
          if ($datas->identityimage != '') {
            Storage::disk('local')->delete('devoteeids/' . $datas->identityimage);
          }


          if ($request['identitytype'] == 'National ID') {
            $idname = 'NI';
          } else if ($request['identitytype'] == 'Citizenship') {
            $idname = 'CC';
          } else if ($request['identitytype'] == 'Passport') {
            $idname = 'PP';
          } else if ($request['identitytype'] == 'Vote Card') {
            $idname = 'VC';
          } else if ($request['identitytype'] == 'Student Card') {
            $idname = 'SC';
          } else if ($request['identitytype'] == 'Profession Card') {
            $idname = 'PC';
          } else if ($request['identitytype'] == 'Iskcon Card') {
            $idname = 'IC';
          } else {
            $idname = substr(str_shuffle($permitted_chars), 0, 4);
          }



          $identityname = $idname . '-' . substr(str_shuffle($permitted_chars), 0, 4) . '.' . $request->file('identityimage')->getClientOriginalExtension();
          $photopath = "devoteeids/";
          Storage::disk('local')->put($photopath . $identityname, file_get_contents($request->file('identityimage')));
        } else {
          $identityname = $request['identity_old'];
        }
      }

      if ($request['dobtype'] == 'BS') {
        $dob = Crypt::encrypt($request['dobbs']);
      } else if ($request['dobtype'] == 'AD') {
        $dob = Crypt::encrypt($request['dobad']);
      } else {
        $dob = NULL;
      }

      if ($request['email'] != NULL) {
        $hashemail = hash('sha256', $request['email']);
        $email = Crypt::encrypt($request['email']);
      } else {
        $hashemail = NULL;
        $email = NULL;
      }

      if ($request['mobile'] != NULL) {
        $hashmobile = hash('sha256', $request['mobile']);
        $mobile = Crypt::encrypt($request['mobile']);
      } else {
        $hashmobile = NULL;
        $mobile = NULL;
      }

      if ($request['identityno'] != NULL) {
        $hashidentityid = hash('sha256', $request['identityno']);
        $identityid_enc = Crypt::encrypt($request['identityno']);
      } else {
        $hashidentityid = NULL;
        $identityid_enc = NULL;
      }

      if ($request['firstname'] != NULL) {
        $firstname = Crypt::encrypt($request['firstname']);
      } else {
        $firstname = NULL;
      }
      if ($request['middlename'] != NULL) {
        $middlename = Crypt::encrypt($request['middlename']);
      } else {
        $middlename = NULL;
      }
      if ($request['surname'] != NULL) {
        $surname = Crypt::encrypt($request['surname']);
      } else {
        $surname = NULL;
      }
      if ($request['phone'] != NULL) {
        $phone = Crypt::encrypt($request['phone']);
      } else {
        $phone = NULL;
      }
      if ($request['identitytype'] != NULL) {
        $identitytype = Crypt::encrypt($request['identitytype']);
      } else {
        $identitytype = NULL;
      }
      if ($request['ptole'] != NULL) {
        $ptole = Crypt::encrypt($request['ptole']);
      } else {
        $ptole = NULL;
      }
      if ($request['pwardno'] != NULL) {
        $pwardno = Crypt::encrypt($request['pwardno']);
      } else {
        $pwardno = NULL;
      }
      if ($request['pmuni'] != NULL) {
        $pmuni = Crypt::encrypt($request['pmuni']);
      } else {
        $pmuni = NULL;
      }
      if ($request['pdistrict'] != NULL) {
        $pdistrict = Crypt::encrypt($request['pdistrict']);
      } else {
        $pdistrict = NULL;
      }
      if ($request['province'] != NULL) {
        $province = Crypt::encrypt($request['province']);
      } else {
        $province = NULL;
      }
      if ($request['tprovince'] != NULL) {
        $tprovince = Crypt::encrypt($request['tprovince']);
      } else {
        $tprovince = NULL;
      }
      if ($request['tdistrict'] != NULL) {
        $tdistrict = Crypt::encrypt($request['tdistrict']);
      } else {
        $tdistrict = NULL;
      }
      if ($request['tmuni'] != NULL) {
        $tmuni = Crypt::encrypt($request['tmuni']);
      } else {
        $tmuni = NULL;
      }
      if ($request['ttole'] != NULL) {
        $ttole = Crypt::encrypt($request['ttole']);
      } else {
        $ttole = NULL;
      }
      if ($request['twardno'] != NULL) {
        $twardno = Crypt::encrypt($request['twardno']);
      } else {
        $twardno = NULL;
      };

      Devotees::whereId($id)->update([
        'firstname' => $firstname,
        'middlename' => $middlename,
        'surname' => $surname,
        'mentor' => $request['mentor'],
        'gotra' => $request['gotra'],
        'email' => $hashemail,
        'email_enc' => $email,
        'countrycode' => $request['countrycode'],
        'mobile' => $hashmobile,
        'mobile_enc' => $mobile,
        'phone' => $phone,
        'identitytype' => $identitytype,
        'identityid' => $hashidentityid,
        'identityid_enc' => $identityid_enc,
        'identityimage' => $identityname,
        'dob' => $dob,
        'dobtype' => $request['dobtype'],
        'member' => $request['lifemember'],
        'bloodgroup' => $request['bloodgroup'],
        'gender' => $request['gender'],
        'education' => $request['education'],
        'occupations' => $request['occupation'],
        'branch_id' => $request['branch'],
        'ptole' => $ptole,
        'pwardno' => $pwardno,
        'pmuni' => $pmuni,
        'pdistrict' => $pdistrict,
        'pprovince' => $province,
        'tmuni' => $tmuni,
        'twardno' => $twardno,
        'ttole' => $ttole,
        'tdistrict' => $tdistrict,
        'tprovince' => $tprovince,
        'updatedby' => $user->id,
        'status' => $request['status'],
        'marital_status' => $request['maritalstatus'],
        'nationality' => $request['nationality']
      ]);
      $getdevotee = Devotees::find($id);
      activity('Devotee')->log('Updated: ' . $getdevotee->firstname . ' ' . $getdevotee->middlename . ' ' . $getdevotee->surname);

      $getuser = Admin::where('devotee_id', $id)->first();
      if ($getuser) {
        $getname = $request['firstname'] . ' ' . $request['middlename'] . ' ' . $request['surname'];
        Admin::where('devotee_id', $id)->update([
          'name' => Crypt::encrypt($getname),
          'email' => $request['email']
        ]);
      }

      return redirect('/admin/devotees')->with('success', 'Data updated successfully');
    } catch (\Illuminate\Validation\ValidationException $e) {
      // Collect the validation errors
      $errors = $e->validator->errors();

      $emailError = $errors->first('email');
      $mobileError = $errors->first('mobile');

      // Set error messages in the session
      if ($emailError) {
        session()->flash('error', $emailError);
      }
      if ($mobileError) {
        session()->flash('error', $mobileError);
      }

      return redirect()->back()->withInput();
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred while updating the data: ' . $e->getMessage());
    }
  }

  public function movetotrash(Request $request, string $id)
  {
    try {
      $category = Devotees::findOrFail($id);
      $category->delete();
      activity('Devotees')->log('Moved to Trash');
      return redirect('/admin/devotees')->with('success', 'Data updated successfully');
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.');
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function restore(Request $request, string $id)
  {
    try {
      $item = Devotees::withTrashed()->find($id);
      if ($item) {
        $item->restore();
      } else {
        return redirect('/admin/devotees')->with('error', 'Data is not in the trash folder.');
      }
      activity('Devotees')->log('Restore');
      return redirect('/admin/devotees')->with('success', 'Data updated successfully');
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.' . $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      $data = Devotees::withTrashed()->find($id);
      $data->forceDelete();
      activity('Devotee')->log('Devoted Deleted.');
      return redirect('/admin/devotees')->with('success', 'Data deleted sucessfully.');
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.' . $e->getMessage());
    }
  }

  public function devoteeimportget()
  {
    try {
      activity('Devotee')->log('Import page visit.');
      return view('backend.devotees.devoteeimport');
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.');
    }
  }

  public function devoteeimport(Request $request)
  {
    try {
      $request->validate([
        'csvfile' => 'required|file|mimes:csv,txt',
      ]);
      $file = $request->file('csvfile');
      $import = new DevoteeImport;
      $import->import($file);

      if ($import->failures()->isNotEmpty()) {
        return back()->withFailures($import->failures());
      }

      return redirect('/admin/devotees')->with('success', 'Data imported successfully.');
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.');
    }
  }

  public function profileimage(Request $request, $id)
  {
    try {
      $view = Devotees::find($id);
      $devoteeid = $view->id;
      activity('Devotee')->log('Profile Image Update');
      return view('backend.devotees.profilepicture', compact('view', 'devoteeid'));
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.');
    }
  }

  public function profileimageupdate(Request $request, $id)
  {
    try {
      $img = $request->image;
      if ($img != '') {

        $data = Devotees::findOrFail($id);
        if ($data->photo != '') {
          Storage::disk('local')->delete('devoteephotos/' . $data->photo);
        }

        $folderPath = "devoteephotos/";
        $image_parts = explode(";base64,", $img);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        Storage::disk('local')->put($file, file_get_contents($request->image));

        $getimage = storage_path("app/devoteephotos/" . $fileName);
        $img = Image::read(file_get_contents($request->image));
        //$img->resize(150, 150);
        $img->resize(500, 400, function ($constraint) {
          $constraint->aspectRatio();
        });
        $img->save(storage_path("app/devoteephotos/" . $fileName));

        $primary = Devotees::whereId($id)->update([
          'photo' => $fileName,
        ]);

        activity('Devotee')->log('Image updated: ' . $data->firstname . ' ' . $data->middlename . ' ' . $data->surname);

        return redirect('/admin/devotees/' . $id)->with('success', 'Data updated successfully');
      } else {
        return redirect('/admin/devotees/' . $id)->with('error', 'Please take a picture');
      }
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.');
    }
  }

  public function devoteeqrscan(Request $request)
  {
    try {
      activity('Devotee')->log('QR Scan Page');
      return view('backend.devotees.qrscan');
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.');
    }
  }

  public function devotee_excel_export()
  {
    try {
      return Excel::download(new DevoteeExport, 'devotee-export.xlsx');
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.' . $e->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function mentorupdate(Request $request, $id)
  {
    try {
      $user = Auth::guard('admin')->user();

      Devotees::whereId($id)->update([
        'mentor' => NULL,
        'updatedby' => $user->id
      ]);

      $getdevotee = Devotees::find($id);
      activity('Mentor')->log('Updated: ' . $getdevotee->firstname . ' ' . $getdevotee->middlename . ' ' . $getdevotee->surname);

      return redirect()->back()->with('success', 'Data updated successfully');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'An error occurred while updating the data: ' . $e->getMessage());
    }
  }

  public function usersync(Request $request)
  {
    try {

      $user = Auth::guard('admin')->user();

      $getdevotees = Devotees::whereNotNull('email')->get();
      if ($getdevotees->count() != NULL) {
        foreach ($getdevotees as $getdevotee) {
          $checkuser = User::where('devotee_id', '=', $getdevotee->id)->where('branch_id', '=', $getdevotee->branch_id)->first();
          if ($checkuser === null) {
            $str = date('Y', strtotime($getdevotee->created_at));
            $str1 = substr($str, 1);
            $passwordset = 'IN-' . $str1 . '-' . $getdevotee->id;
            $password = Hash::make($passwordset);

            if ($getdevotee->firstname != NULL) {
              $firstname = Crypt::decrypt($getdevotee->firstname);
            } else {
              $firstname = NULL;
            }
            if ($getdevotee->middlename != NULL) {
              $middlename = Crypt::decrypt($getdevotee->middlename);
            } else {
              $middlename = NULL;
            }
            if ($getdevotee->surname != NULL) {
              $surname = Crypt::decrypt($getdevotee->surname);
            } else {
              $surname = NULL;
            }

            $name = $firstname . ' ' . $middlename . ' ' . $surname;
            $user = new User;
            $user->name = Crypt::encrypt($name);
            $user->email = Crypt::decrypt($getdevotee->email_enc);
            $user->password = $password;
            $user->devotee_id = $getdevotee->id;
            $user->status = 'Active';
            $user->createdby = $user->id;
            $user->branch_id = $getdevotee->branch_id;
            $user->save();
          }
        }
      }
      return redirect('/admin/users')->with('success', 'User created successfully');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'An error occurred while updating the data: ' . $e->getMessage());
    }
  }

  public function devoteefamilydelete(string $id)
  {
    try {
      activity('Devotee Relation')->log('Deleted Devotee Relation.');
      $data = DevoteeFamilyMember::findOrFail($id);
      $data->Delete();
      return redirect('/admin/devotees')->with('success', 'Data deleted successfully.');
    } catch (\Exception $e) {
      return redirect('/admin/devotees')->with('error', 'An error occurred, please try again.' . $e->getMessage());
    }
  }
}
