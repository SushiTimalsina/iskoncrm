<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\AttendSewa;
use App\Models\Devotees;
use App\Models\Sewa;
use App\Models\Department;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class AttendSewaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  function __construct()
  {
    $this->middleware('permission:sewa-list|sewa-create|sewa-edit|sewa-delete', ['only' => ['index', 'show']]);
    $this->middleware('permission:sewa-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:sewa-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:sewa-delete', ['only' => ['destroy', 'download', 'delete']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      activity('Sewa Attend')->log('Viewed lists.');
      $branches = Branch::where('status', 'Active')->get();
      $devotees = Devotees::orderBy('firstname', 'asc')->get();
      $departments = Department::where('parent_id', NULL)->orderBy('title', 'asc')->get();
      $sewas = Sewa::all();
      $lists = AttendSewa::orderBy('created_at', 'desc')->paginate(50);
      return view('backend.attendsewa.index', compact('branches', 'devotees', 'sewas', 'departments', 'lists'));
    } catch (\Exception $e) {
      return redirect('/admin/sewa-attend')->with('error', 'An error occurred, please try again.');
    }
  }

  public function trash()
  {
    try {
      activity('Sewa Attend')->log('Viewed lists.');
      $branches = Branch::where('status', 'Active')->get();
      $devotees = Devotees::all();
      $departments = Department::where('parent_id', NULL)->orderBy('title', 'asc')->get();
      $sewas = Sewa::all();
      $lists = AttendSewa::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
      return view('backend.attendsewa.index', compact('branches', 'devotees', 'sewas', 'departments', 'lists'));
    } catch (\Exception $e) {
      return redirect('/admin/sewa-attend')->with('error', 'An error occurred, please try again.' . $e->getMessage());
    }
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function searchfilter(Request $request)
  {
    try {
      $branches = Branch::where('status', 'Active')->get();
      $devotees = Devotees::orderBy('firstname', 'asc')->get();
      $departments = Department::all();
      $sewas = Sewa::all();
      $query = AttendSewa::orderBy('created_at', 'desc');

      if ($request['search'] == 'true') {

        if ((isset($_GET['devotee']) && ($_GET['devotee'] != ''))) {
          $query->where('devotee_id', '=', $_GET['devotee']);
        }

        if ((isset($_GET['department']) && ($_GET['department'] != ''))) {
          $query->where('department_id', '=', $_GET['department']);
        }

        if ((isset($_GET['branch']) && ($_GET['branch'] != ''))) {
          $query->where('branch_id', '=', $_GET['branch']);
        }

        if ((isset($_GET['designation']) && ($_GET['designation'] != ''))) {
          $query->where('designation', '=', $_GET['designation']);
        }

        if ($request['daterange']) {
          $dates = explode(' - ', $request['daterange']);
          $query->whereBetween('created_at', [$dates[0] . " 00:00:00", $dates[1] . " 23:59:59"]);
        }
      }
      $lists = $query->paginate(50);
      return view('backend.attendsewa.index', compact('branches', 'devotees', 'sewas', 'departments', 'lists'));
    } catch (\Exception $e) {
      return redirect('/admin/sewa-attend')->with('error', 'An error occurred, please try again.');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    try {
      activity('Sewa Attend')->log('Create.');
      $devotees = Devotees::orderBy('firstname', 'asc')->get();
      $departments = Department::where('status', 'Active')->get();
      $sewas = Sewa::where('status', 'Active')->get();
      return view('backend.attendsewa.create', compact('devotees', 'sewas', 'departments'));
    } catch (\Exception $e) {
      return redirect('/admin/sewa-attend')->with('error', 'An error occurred, please try again.' . $e->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      $checkrow = Devotees::find($request['devotee']);
      if ($checkrow) {
        $user = Auth::guard('admin')->user();
        $devoteerow = Devotees::find($user->devotee_id);
        $duplicates = AttendSewa::where('devotee_id', $request['devotee'])->where('date', $request['date'])->first();
        if ($duplicates === null) {
          $createrow = AttendSewa::create([
            'devotee_id' => $request['devotee'],
            'branch_id' => $devoteerow->branch_id,
            'department_id' => $request['department'],
            'sewa_id' => $request['sewa'],
            'designation' => $request['designation'],
            'date' => $request['date'],
            'createdby' => $user->id
          ]);

          activity('Sewa Attend')->log('Created attend sewa lists');
          return redirect()->back()->with('success', 'Data created successfully');
        } else {
          return redirect('/admin/sewa-attend/')->with('error', 'Data duplication found!');
        }
      } else {
        activity('Sewa Attend')->log('Created attend sewa lists');
        return redirect()->back()->with('error', 'Devotee not found!');
      }
    } catch (\Exception $e) {
      return redirect('/admin/sewa-attend')->with('error', 'An error occurred, please try again.' . $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      $view = AttendSewa::find($id);
      activity('Devotee')->log('Data viewed id ' . $id);
      return view('backend.attendsewa.view', compact('view'));
    } catch (\Exception $e) {
      return redirect('/admin/sewa-attend')->with('error', 'An error occurred, please try again.');
    }
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
      $user = Auth::guard('admin')->user();
      activity('Sewa Attend')->log('Edit.');
      $branches = Branch::where('status', 'Active')->get();
      $edit = AttendSewa::find($id);
      $devotees = Devotees::orderBy('firstname', 'asc')->get();
      $departments = Department::where('status', 'Active')->get();
      $sewas = Sewa::where('status', 'Active')->get();
      return view('backend.attendsewa.edit', compact('edit', 'branches', 'devotees', 'sewas', 'departments'));
    } catch (\Exception $e) {
      return redirect('/admin/sewa-attend')->with('error', 'An error occurred, please try again.');
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
      $user = Auth::guard('admin')->user();
      AttendSewa::whereId($id)->update([
        'devotee_id' => $request['devotee'],
        'branch_id' => $request['branch'],
        'department_id' => $request['department'],
        'sewa_id' => $request['sewa'],
        'designation' => $request['designation'],
        'date' => $request['date'],
        'updatedby' => $user->id
      ]);

      activity('Sewa Attend')->log('Updated attend sewa lists id ' . $id);
      return redirect()->back()->with('success', 'Data updated successfully');
    } catch (\Exception $e) {
      return redirect('/admin/sewa-attend')->with('error', 'An error occurred, please try again.');
    }
  }

  public function movetotrash(Request $request, string $id)
  {
    try {
      $category = AttendSewa::findOrFail($id);
      $category->delete();
      activity('Sewa Attend')->log('Moved to Trash');
      return redirect('/admin/sewa-attend-trash')->with('success', 'Data updated successfully');
    } catch (\Exception $e) {
      return redirect('/admin/sewa-attend-trash')->with('error', 'An error occurred, please try again.');
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function restore(Request $request, string $id)
  {
    try {
      $item = AttendSewa::withTrashed()->find($id);
      if ($item) {
        $item->restore();
      } else {
        return redirect('/admin/sewa-attend')->with('error', 'Data is not in the trash folder.');
      }
      activity('Sewa Attend')->log('Restore');
      return redirect('/admin/sewa-attend')->with('success', 'Data updated successfully');
    } catch (\Exception $e) {
      return redirect('/admin/sewa-attend')->with('error', 'An error occurred, please try again.' . $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(string $id)
  {
    try {
      activity('Sewa Attend')->log('Deleted the attend sewa');
      $data = AttendSewa::withTrashed()->find($id);
      $data->forceDelete();
      return redirect('/admin/sewa-attend')->with('success', 'Data deleted successfully.');
    } catch (\Exception $e) {
      return redirect('/admin/sewa-attend')->with('error', 'An error occurred, please try again.');
    }
  }
}
