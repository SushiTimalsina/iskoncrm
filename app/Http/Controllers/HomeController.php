<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devotees;
use App\Models\Mentor;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      try{
        $activedevotees = Devotees::where('status', 'Active');
        $importeddevotees = Devotees::where('status', 'imported');
        $devotees = Devotees::all();
        $mentors = Mentor::all();
        $users = User::all();
        activity('Dashboard')->log('Visit Dashboard.');
        return view('backend.home', compact('activedevotees', 'importeddevotees', 'devotees', 'users', 'mentors'));
      } catch (\Exception $e) {
        return redirect('/home')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }
}
