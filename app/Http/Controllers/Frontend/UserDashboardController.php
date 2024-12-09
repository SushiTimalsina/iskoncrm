<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AttendSewa;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Devotees;
use App\Models\DevoteeSkills;
use App\Models\Donation;
use App\Models\Initiation;
use App\Models\Skills;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Sagautam5\LocalStateNepal\Entities\Category;
use Sagautam5\LocalStateNepal\Entities\District;
use Sagautam5\LocalStateNepal\Entities\Municipality;
use Sagautam5\LocalStateNepal\Entities\Province;

class UserDashboardController extends Controller
{
  public function userdashboard()
  {
    $user = Auth::guard('user')->user();
    $view = Devotees::find($user->devotee_id);
    // dd($view);
    $initiation = Initiation::where('devotee_id', $user->devotee_id)->first();
    $skills = DevoteeSkills::where('devotee_id', $user->devotee_id)->get();
    // dd($skills);
    $skilllists = Skills::where('status', 'Active')->get();
    $branches = Branch::where('status', 'Active')->get();

    $province = new Province('en');
    $categories = new Category('en');
    $district = new District('en');
    $municipalities = new Municipality('en');

    $provincesData = $province->getProvincesWithDistrictsWithMunicipalities();
    $categoriesdata = $categories->allcategories();

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


    // dd($initiation);
    return view('frontend.dashboard', compact(
      'user',
      'view',
      'initiation',
      'skills',
      'skilllists',
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
    ));
  }

  public function sewadashboard()
  {
    $user = Auth::guard('user')->user();
    $view = Devotees::find($user->devotee_id);
    // dd($view);
    $initiation = Initiation::where('devotee_id', $user->devotee_id)->first();
    $skills = DevoteeSkills::where('devotee_id', $user->devotee_id)->get();
    // dd($skills);
    $skilllists = Skills::where('status', 'Active')->get();
    $branches = Branch::where('status', 'Active')->get();
    $attendsewas = AttendSewa::where('devotee_id', $user->devotee_id)->orderBy('created_at', 'desc')->paginate(50);

    return view('frontend.devotee_sewalist', compact(
      'user',
      'view',
      'initiation',
      'skills',
      'skilllists',
      'attendsewas'
    ));
  }


  public function coursedashboard()
  {
    $user = Auth::guard('user')->user();
    $view = Devotees::find($user->devotee_id);
    $initiation = Initiation::where('devotee_id', $user->devotee_id)->first();
    $skills = DevoteeSkills::where('devotee_id', $user->devotee_id)->get();
    return view('frontend.devotee_courselist', compact(
      'user',
      'view',
      'initiation',
      'skills',

    ));
  }
  public function donationdashboard()
  {
    $user = Auth::guard('user')->user();
    $view = Devotees::find($user->devotee_id);
    $initiation = Initiation::where('devotee_id', $user->devotee_id)->first();
    $skills = DevoteeSkills::where('devotee_id', $user->devotee_id)->get();
    $donations = Donation::where('devotee_id', $user->devotee_id)->orderBy('created_at', 'desc')->paginate(50);

    return view('frontend.devotee_donationlist', compact(
      'user',
      'view',
      'initiation',
      'skills',
      'donations',

    ));
  }



  public function logout(Request $request)
  {
    // Log out the user from the 'web' guard
    Auth::guard('user')->logout();

    // Invalidate the session to clear all session data
    $request->session()->invalidate();

    // Regenerate the CSRF token to prevent session fixation attacks
    $request->session()->regenerateToken();

    // Redirect the user to the login page (or home page) after logout
    return redirect('/login');
  }
}
