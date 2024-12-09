<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseBatchDevotee;
use Illuminate\Support\Facades\Auth;

class CourseBatchDevoteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:course-list|course-create|course-edit|course-delete', ['only' => ['index','show']]);
         $this->middleware('permission:course-create', ['only' => ['create','store']]);
         $this->middleware('permission:course-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:course-delete', ['only' => ['destroy', 'download', 'delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
      try{

        $validatedData = $request->validate([
           'devotees' => 'required',
           'batch' => 'required'
       ]);
        $user = Auth::guard('admin')->user();
        if ($request['devotees']){
          foreach($request['devotees'] as $devotee)
          {
            $rowexists = CourseBatchDevotee::where('devotee_id', $devotee)->where('batch_id', $request['batch'])->doesntExist();
            if($rowexists){
              $createrow = CourseBatchDevotee::create([
                'devotee_id' => $devotee,
                'batch_id' => $request['batch'],
                'branch_id' => $request['branch'],
                'createdby' => $user->id
              ]);
          }
        }
        activity('Course Batch')->log('Created Devotee on Batch');
        return redirect()->back()->with('success', 'Data created successfully');
      }
      } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred, please try again.');
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
        $data = CourseBatchDevotee::findOrFail($id);
        activity('Course Batch Devotee')->log('Data deleted id '.$id);
        $data->delete();
        return redirect()->back()->with('success', 'Data deleted successfully.');
      } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred, please try again.');
      }
    }
}
