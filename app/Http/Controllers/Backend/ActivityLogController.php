<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\Branch;
use App\Models\Devotees;
use App\Models\Admin;
use Auth;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        $activities = Activity::orderBy('id', 'desc')->paginate(50);
        $devotees = Devotees::all();
        $users = Admin::all();
        return view('backend.activitylogs.index',compact('activities', 'users', 'devotees'));
      } catch (\Exception $e) {
        return redirect('/admin/activity-logs')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchfilter(Request $request)
    {
      try{
        $devotees = Devotees::all();
        $users = Admin::all();
        $branches = Branch::where('status', 'Active')->get();
        $query = Activity::orderBy('created_at', 'desc');

        if($request['search'] == 'true'){
          if($request['devotee']){
            $query->where('causer_id', '=', $request['devotee']);
          }

          if($request['page']){
            $query->where('log_name', '=', $request['page']);
          }


          if($request['daterange']){
            $dates = explode(' - ', $request['daterange']);
            $query->whereBetween('created_at', [$dates[0]." 00:00:00", $dates[1]." 23:59:59"]);
          }
        }
        $activities = $query->paginate(50);
        return view('backend.activitylogs.index',compact('branches', 'devotees', 'activities', 'users'));
      } catch (\Exception $e) {
        return redirect('/admin/activity-logs')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try{
        $category = Activity::findOrFail($id);
        $category->delete();
        return redirect('/admin/activity-logs')->with('success', 'Data deleted.');
      } catch (\Exception $e) {
        return redirect('/admin/activity-logs')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyall()
    {
      try{
        Activity::truncate();
        return redirect('/admin/activity-logs')->with('success', 'All Data Deleted.');
      } catch (\Exception $e) {
        return redirect('/admin/activity-logs')->with('error', 'An error occurred, please try again.');
      }
    }

    public function destroyselected(Request $request)
    {
        $ids = $request->ids;

        if ($ids) {
            // Delete multiple items using a single query
            Activity::whereIn('id', $ids)->delete();

            return response()->json(['success' => 'Items deleted successfully.']);
        }

        return response()->json(['error' => 'No items selected.'], 400);
    }

}
