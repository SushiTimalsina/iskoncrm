<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Devotees;
use App\Models\Courses;
use App\Models\AttendCourse;
use App\Models\CourseBatchDevotee;
use Storage;
use Image;
use Auth;

class AttendCourseController extends Controller
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
      try{
        activity('Course Attend')->log('Viewed lists.');
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        return view('backend.attendcourse.index',compact('branches', 'devotees'));
      } catch (\Exception $e) {
        return redirect('/admin/course-attend')->with('error', 'An error occurred, please try again.');
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
        activity('Course Attend')->log('Create.');
        $branches = Branch::where('status', 'Active')->get();
        $courses = Courses::where('status', 'Active')->get();
        $devotees = Devotees::all();
        return view('backend.attendcourse.create',compact('courses', 'branches', 'devotees'));
      } catch (\Exception $e) {
        return redirect('/admin/course-attend')->with('error', 'An error occurred, please try again.');
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

        $getcourse = Courses::find($request['course']);
        if($request['attendmarks'] != NULL && $getcourse->totalmarks != NULL){
            $percent = ($request['attendmarks']/$getcourse->totalmarks) * 100;
        }else{
          $percent = '';
        }

        $identity = $request->file('certificate');
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        if($identity != ''){
          $identityname = substr(str_shuffle($permitted_chars), 0, 4).'.'.$request->file('certificate')->getClientOriginalExtension();
          $identitypath = "coursecertificates/";
          Storage::disk('local')->put($identitypath.$identityname, file_get_contents($request->file('certificate')));
        }else{
          $identityname = '';
        }

        $createrow = AttendCourse::create([
            'devotee_id' => $request['devotee'],
            'branch_id' => $devoteerow->branch_id,
            'course_id' => $request['course'],
            'fromdate' => $request['fromdate'],
            'todate' => $request['todate'],
            'totalmarks' => $getcourse->totalmarks,
            'attendmarks' => $request['attendmarks'],
            'percentage' => $percent,
            'certificate' => $identityname,
            'status' => $request['status'],
            'createdby' => $user->id
        ]);

        activity('Course Attend')->log('Created attend course lists id '.$createrow->id);
        return redirect()->back()->with('success', 'Data created successfully');
      } catch (\Exception $e) {
        return redirect('/admin/course-attend')->with('error', 'An error occurred, please try again.');
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
      try{
        $user = Auth::guard('admin')->user();
        activity('AttendCourse Attend')->log('Edit.');
        $branches = Branch::where('status', 'Active')->get();
        $courses = Courses::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $edit = AttendCourse::find($id);
        return view('backend.attendcourse.edit',compact('edit', 'branches', 'devotees', 'courses'));
      } catch (\Exception $e) {
        return redirect('/admin/course-attend')->with('error', 'An error occurred, please try again.');
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
        $getcourse = Courses::find($request['course']);
        if($request['attendmarks'] != NULL && $getcourse->totalmarks != NULL){
            $percent = ($request['attendmarks']/$getcourse->totalmarks) * 100;
        }else{
          $percent = '';
        }

        AttendCourse::whereId($id)->update([
            'devotee_id' => $request['devotee'],
            'branch_id' => $request['branch'],
            'course_id' => $request['course'],
            'fromdate' => $request['fromdate'],
            'todate' => $request['todate'],
            'totalmarks' => $getcourse->totalmarks,
            'attendmarks' => $request['attendmarks'],
            'percentage' => $percent,
            'status' => $request['status'],
            'updatedby' => $user->id
        ]);

        activity('Course Attend')->log('Updated attend course lists id '.$id);
        return redirect()->back()->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/course-attend')->with('error', 'An error occurred, please try again.');
      }
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
        activity('Course Attend')->log('Data Deleted');
        $data = AttendCourse::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data deleted successfully.');
      } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred, please try again.');
      }
    }

    public function getattendance(Request $request)
     {
       $user = Auth::guard('admin')->user();
       $getids = $request->ids;
       $date = $request->datevalue;
       $time = $request->timevalue;
       $type = $request->typevalue;
       $batch = $request->batchvalue;
       $course = $request->coursevalue;
       $branch = $request->branchvalue;

       foreach($getids as $getid){
         $checkrow = AttendCourse::where('devotee_id', $getid)->where('batch_id', $batch)->where('date', $date)->where('branch_id', $branch)->get();
         if($checkrow->count() == NULL){
           $createrow = AttendCourse::create([
             'devotee_id' => $getid,
             'course_id' => $course,
             'batch_id' => $batch,
             'branch_id' => $branch,
             'date' => $date,
             'time' => $time,
             'type' => $type,
             'createdby' => $user->id
           ]);
         }
       }
       activity('Course Attendance')->log('Attendance Uploaded.');
       return response()->json( [ 'success'=>"Data Updated Successfully." ] );
     }

     public function attendmarks(Request $request)
      {
        $user = Auth::guard('admin')->user();
        $id = $request->devoteeid;
        $attendmark = $request->attendmarks;
        CourseBatchDevotee::whereId($id)->update(['attendmark' => $attendmark, 'updatedby' => $user->id ]);
        activity('Attend Marks')->log('Uploaded.');
        return response()->json( [ 'success'=>"Data Updated Successfully." ] );
      }
}
