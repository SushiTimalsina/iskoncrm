<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Courses;
use App\Models\CourseFacilitator;
use App\Models\CourseBatchDevotee;
use App\Models\AttendCourse;
use App\Models\CourseBatch;
use App\Models\Devotees;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Storage;
use Image;
use Carbon\Carbon;
use Auth;

class CourseBatchController extends Controller
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
        activity('Course Batch')->log('Viewed lists');
        $lists = CourseBatch::orderBy('created_at', 'desc')->paginate(50);
        $courses = Courses::where('status', 'Active')->get();
        $facilitators = CourseFacilitator::where('status', 'Active')->get();
        return view('backend.batch.index',compact('lists', 'courses', 'facilitators'));
      } catch (\Exception $e) {
        return redirect('/admin/course-batch')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Course Batch')->log('Viewed lists');
        $lists = CourseBatch::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $courses = Courses::where('status', 'Active')->get();
        $facilitators = CourseFacilitator::where('status', 'Active')->get();
        return view('backend.batch.index',compact('lists', 'courses', 'facilitators'));
      } catch (\Exception $e) {
        return redirect('/admin/course-batch')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        activity('Course Batch')->log('Viewed lists');
        $courses = Courses::where('status', 'Active')->get();
        $facilitators = CourseFacilitator::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();
        return view('backend.batch.create',compact('courses', 'facilitators', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/course-batch')->with('error', 'An error occurred, please try again.');
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

        $validatedData = $request->validate([
           'name' => 'required',
           'course' => 'required',
           'facilitator' => 'required',
           'certificate' => 'mimes:jpg,png,jpeg'
       ]);


        $user = Auth::guard('admin')->user();
        $identity = $request->file('certificate');
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

        if ($identity != '') {
          $identityname = substr(str_shuffle($permitted_chars), 0, 4) . '.' . $identity->getClientOriginalExtension();
          $identitypath = "coursecertificates/";
          Storage::disk('local')->put($identitypath . $identityname, file_get_contents($identity));
        } else {
          $identityname = '';
        }

        $rowexists = CourseBatch::where('name', $request['name'])->first();
        if($rowexists === null){
          $createrow = CourseBatch::create([
            'name' => $request['name'],
            'facilitators_id' => $request['facilitator'],
            'course_id' => $request['course'],
            'branch_id' => $request['branch'],
            'certificate' => $identityname,
            'fullmarks' => $request['marks'],
            'examtype' => $request['examtype'],
            'fee' => $request['fee'],
            'unit' => $request['unit'],
            'unitdays' => $request['unitdays'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'type' => $request['type'],
            'status' => $request['status'],
            'createdby' => $user->id
          ]);
          activity('Course Batch')->log($request['name'].' - Batch Created.');
          return redirect('/admin/course-batch')->with('success', 'Data created successfully');
        }else{ return redirect('/admin/course-batch')->with('error', 'Data already created.');}
      } catch (\Exception $e) {
        return redirect('/admin/course-batch')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $show = CourseBatch::find($id);
        $courses = Courses::where('status', 'Active')->get();
        $facilitators = CourseFacilitator::where('status', 'Active')->get();
        $devotees = Devotees::orderBy('firstname', 'asc')->get();
        
        // Fetch distinct dates where an entry exists in the attendance table
        $entryDates = AttendCourse::selectRaw('DATE(date) as entry_date')
            ->where('batch_id', $id)
            ->distinct()
            ->orderBy('entry_date', 'asc')
            ->get()
            ->pluck('entry_date');

        $related_devotees = CourseBatchDevotee::where('batch_id', $id)
        ->select(['course_batch_devotees.id', 'course_batch_devotees.devotee_id', 'course_batch_devotees.batch_id', 'course_batch_devotees.branch_id', 'course_batch_devotees.attendmark'])
        ->join('devotees', 'devotees.id', '=', 'course_batch_devotees.devotee_id')
        ->orderBy('devotees.firstname')->get();

        $attendances = AttendCourse::where('batch_id', $id)
        ->get()
        ->groupBy(function ($attendance) { return $attendance->devotee_id; })
        ->map(function ($userAttendances) {
            return $userAttendances->keyBy(function ($attendance) { return Carbon::parse($attendance->date)->toDateString(); });
        });

        activity('Course Batch')->log('Edit page visited id '.$id);
        return view('backend.batch.show',compact('show', 'courses', 'facilitators', 'devotees', 'related_devotees', 'entryDates', 'attendances'));
      } catch (\Exception $e) {
        return redirect('/admin/course-batch')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $edit = CourseBatch::find($id);
        $courses = Courses::where('status', 'Active')->get();
        $facilitators = CourseFacilitator::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();
        activity('Course Batch')->log('Edit page visited id '.$id);
        return view('backend.batch.edit',compact('edit', 'courses', 'facilitators', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/course-batch')->with('error', 'An error occurred, please try again.');
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
        $request->validate([
           'name' => 'required',
           'course' => 'required',
           'facilitator' => 'required',
           'certificate' => 'mimes:jpg,png,jpeg'
        ]);

        $user = Auth::guard('admin')->user();
        $certificate = $request->file('certificate');
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

        if ($request['removeid'] == 1) {
          $row = CourseBatch::findOrFail($id);
          if ($row->certificate != '') {
            Storage::disk('local')->delete('coursecertificates/' . $row->certificate);
          }
          $identityname = '';
        } else {
          if ($request->hasFile('certificate')) {
            $datas = CourseBatch::findOrFail($id);
            if ($datas->certificate != '') {
              Storage::disk('local')->delete('coursecertificates/' . $datas->certificate);
            }

            $identityname = substr(str_shuffle($permitted_chars), 0, 4).'.'.$certificate->getClientOriginalExtension();
            $photopath = "coursecertificates/";
            Storage::disk('local')->put($photopath . $identityname, file_get_contents($certificate));
          } else {
            $identityname = $request['identity_old'];
          }
        }

        $primary = CourseBatch::whereId($id)->update([
          'name' => $request['name'],
          'facilitators_id' => $request['facilitator'],
          'course_id' => $request['course'],
          'branch_id' => $request['branch'],
          'certificate' => $identityname,
          'fullmarks' => $request['marks'],
          'examtype' => $request['examtype'],
          'fee' => $request['fee'],
          'unit' => $request['unit'],
          'unitdays' => $request['unitdays'],
          'start_date' => $request['start_date'],
          'end_date' => $request['end_date'],
          'type' => $request['type'],
          'status' => $request['status'],
          'createdby' => $user->id
        ]);

        activity('Course Batch')->log('Data updated id '.$id);
        return redirect('/admin/course-batch')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/course-batch')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    public function generatePDF(Request $request, $id)
    {
      $getbatchdevoteerow = CourseBatchDevotee::find($id);
      $getdevoteerow = Devotees::find($getbatchdevoteerow->devotee_id);
      $getbatchrow = CourseBatch::find($getbatchdevoteerow->batch_id);

      if(!empty($getbatchrow->certificate)){
        $imgname = storage_path("app/coursecertificates/".$getbatchrow->certificate);
      }else{ $imgname = NULL;}

      $signature = public_path('images/signature.png');

      $data = [
          'name' => $getdevoteerow->firstname.' '.$getdevoteerow->middlename.' '.$getdevoteerow->lastname,
          'img' => $imgname,
          'signature' => $signature
      ];

      $pdf = PDF::loadView('backend/pdfs/course-certificate', $data);
      $pdf->setPaper('A4', 'landscape');
      return $pdf->download('certificate.pdf');
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = CourseBatch::find($id);
        $category->delete();
        activity('Course Batch')->log('Moved to Trash '.$category->name);
        return redirect('/admin/course-batch-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/course-batch-trash')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = CourseBatch::withTrashed()->find($id);
        if ($item) {
            $item->restore();
        } else {
          return redirect('/admin/course-batch')->with('error', 'Data is not in the trash folder.');
        }
        activity('Course Batch')->log('Restore '.$item->name);
        return redirect('/admin/course-batch')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/course-batch')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      try{
        $item = CourseBatch::withTrashed()->find($id);
        activity('Course Batch')->log('Restore '.$item->name);
        $item->forceDelete();
        return redirect('/admin/course-batch')->with('success', 'Data deleted successfully.');
      } catch (\Exception $e) {
        return redirect('/admin/course-batch')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }
}
