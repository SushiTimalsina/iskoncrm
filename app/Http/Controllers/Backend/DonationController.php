<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Branch;
use App\Models\AttendSewa;
use App\Models\Devotees;
use App\Models\Sewa;
use App\Models\Department;
use App\Models\CourseBatchDevotee;
use App\Models\CourseBatch;
use Carbon\Carbon;
use Auth;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:donation-list|donation-create|donation-edit|donation-delete', ['only' => ['index','show']]);
         $this->middleware('permission:donation-create', ['only' => ['create','store']]);
         $this->middleware('permission:donation-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:donation-delete', ['only' => ['destroy', 'download', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $departments = Department::where('status', 'Active')->get();
        $lists = Donation::orderBy('created_at', 'desc')->paginate(50);
        $sewas = Sewa::all();
        activity('Donation')->log('Viewed lists');
        return view('backend.donation.index',compact('lists', 'branches', 'devotees', 'departments', 'sewas'));
      } catch (\Exception $e) {
        return redirect('/admin/donation')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchfilter(Request $request)
    {
      $query = Donation::orderBy('created_at', 'desc');
      if($request['branch']){
        $query->where('branch_id', '=', $request['branch']);
      }

      if($request['devotee']){
        $query->where('devotee_id', '=', $request['devotee']);
      }

      if($request['sewa']){
        $query->where('sewa_id', '=', $request['sewa']);
      }

      if($request['type']){
        $query->where('status', '=', $request['type']);
      }

      if(($request['datefrom']) && (request['dateto'] != '')){
        $query->whereBetween('created_at', [$_GET['datefrom']." 00:00:00", $_GET['dateto']." 23:59:59"]);
      }

      $lists = $query->paginate(50);
      $donationget = $query->sum('donation');
      $branches = Branch::where('status', 'Active')->get();
      $devotees = Devotees::all();
      $departments = Department::where('status', 'Active')->get();
      $sewas = Sewa::all();

      return view('backend.donation.index',compact('lists', 'branches', 'devotees', 'departments', 'sewas'));
    }

    public function trash()
    {
      try{
        activity('Donation')->log('Viewed lists');
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $departments = Department::where('status', 'Active')->get();
        $lists = Donation::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $sewas = Sewa::all();
        return view('backend.donation.index',compact('lists', 'branches', 'devotees', 'departments', 'sewas'));
      } catch (\Exception $e) {
        return redirect('/admin/donation')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      try{
        activity('Sewa Attend')->log('Create.');
        $devotees = Devotees::all();
        $departments = Department::where('status', 'Active')->get();
        $sewas = Sewa::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();
        return view('backend.donation.create',compact('devotees', 'sewas', 'departments', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/donation')->with('error', 'An error occurred, please try again.');
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
      try{
        $user = Auth::guard('admin')->user();
        $devoteerow = Devotees::find($user->devotee_id);
        $currentYear = Carbon::now()->year;
        $checkpayment = Donation::where('voucher', $request['voucher'])->whereYear('created_at', $currentYear)->doesntExist();

        if($checkpayment){
          $createrow = Donation::create([
            'devotee_id'=>$request['devotee'],
            'branch_id' => $devoteerow->branch_id,
            'sewa_id'=>$request['sewa'],
            'voucher'=>$request['voucher'],
            'donation'=>$request['donation'],
            'donationtype'=>$request['type'],
            'createdby'=>$user->id,
            'status'=>$request['status']
          ]);

          activity('Donation')->log('Course Donation Paid');
          return redirect()->back()->with('success', 'Data created successfully');
        }else{
          return redirect()->back()->with('error', 'Please check voucher and try again!');
        }

      } catch (\Exception $e) {
        return redirect('/admin/donation')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    public function coursedonationstore(Request $request)
    {
      try{
        $user = Auth::guard('admin')->user();
        $getcoursebatchrow = CourseBatchDevotee::find($request['batch']);
        $currentYear = Carbon::now()->year;
        $checkpayment = Donation::where('voucher', $request['voucher'])->whereYear('created_at', $currentYear)->doesntExist();

        if($checkpayment){
          $createrow = Donation::create([
            'devotee_id'=>$request['devotee'],
            'branch_id' => $request['branch'],
            'course_batch_id'=>$request['batch'],
            'title'=>$request['name'],
            'donation'=>$request['amount'],
            'donationtype'=>$request['paidby'],
            'voucher'=>$request['voucher'],
            'createdby'=>$user->id,
            'status'=>'Paid'
          ]);

          activity('Donation')->log('Course Donation Paid');
          return redirect()->back()->with('success', 'Data created successfully');
        }else{
          return redirect()->back()->with('error', 'Please check voucher and try again!');
        }

      } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
      try{
        $show = Donation::find($id);
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $departments = Department::where('status', 'Active')->get();
        $sewas = Sewa::where('status', 'Active')->get();
        activity('Donation')->log('Donation View');
        return view('backend.donation.show',compact('show', 'branches', 'devotees', 'departments', 'sewas'));
      } catch (\Exception $e) {
        return redirect('/admin/donation')->with('error', 'An error occurred, please try again.');
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
      try{
        $edit = Donation::find($id);
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $departments = Department::where('status', 'Active')->get();
        $sewas = Sewa::where('status', 'Active')->get();

        activity('Donation')->log('Edit page visited id '.$id);
        return view('backend.donation.edit',compact('edit', 'branches', 'devotees', 'departments', 'sewas'));
      } catch (\Exception $e) {
        return redirect('/admin/donation')->with('error', 'An error occurred, please try again.');
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
      try{
        $user = Auth::guard('admin')->user();
        $primary = Donation::whereId($id)->update([
          'devotee_id'=>$request['devotee'],
          'branch_id'=>$request['branch'],
          'sewa_id'=>$request['sewa'],
          'voucher'=>$request['voucher'],
          'donation'=>$request['donation'],
          'donationtype'=>$request['type'],
          'updatedby'=>$user->id,
          'status'=>$request['status']
        ]);

        activity('Donation')->log('Data updated id '.$id);
        return redirect('/admin/donation')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/donation')->with('error', 'An error occurred, please try again.');
      }
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = Donation::findOrFail($id);
        $category->delete();
        activity('Donation')->log('Moved to Trash');
        return redirect('/admin/donation-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/donation-trash')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = Donation::withTrashed()->find($id);
        if ($item) {
            $item->restore();
        } else {
          return redirect('/admin/donation')->with('error', 'Data is not in the trash folder.');
        }
        activity('Donation')->log('Restore');
        return redirect('/admin/donation')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/donation')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try{
          activity('Donation')->log('Data deleted');
          $getdata = Donation::withTrashed()->find($id);
          $getdata->forceDelete();
          return redirect()->back()->with('success', 'Data deleted successfully.');
        } catch (\Exception $e) {
          return redirect('/admin/donation')->with('error', 'An error occurred, please try again.');
        }
    }
}
