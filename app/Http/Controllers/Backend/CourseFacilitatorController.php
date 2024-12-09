<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use App\Models\Courses;
use App\Models\CourseFacilitator;
use App\Models\Devotees;
use Storage;
use Image;
use Auth;

class CourseFacilitatorController extends Controller
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
        activity('Facilitator')->log('Viewed lists');
        $devotees = Devotees::orderBy('firstname', 'asc')->get();
        $lists = CourseFacilitator::paginate(50);
        $courses = Courses::whereIn('id', $lists->pluck('course_id')->flatten()->unique())->get();
        $branches = Branch::where('status', 'Active')->get();
        return view('backend.facilitator.index',compact('lists', 'courses', 'branches', 'devotees'));
      } catch (\Exception $e) {
        return redirect('/admin/course-facilitator')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Facilitator')->log('Viewed lists');
        $lists = CourseFacilitator::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $parentlists = CourseFacilitator::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $branches = Branch::where('status', 'Active')->get();
        $courses = Courses::where('status', 'Active')->get();
        return view('backend.facilitator.index',compact('lists', 'parentlists', 'devotees', 'branches', 'courses'));
      } catch (\Exception $e) {
        return redirect('/admin/course-facilitator')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    public function searchfilter(Request $request)
    {
      try {
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $courses = Courses::all();
        $query = CourseFacilitator::orderBy('created_at', 'desc');


        if ($request['search'] == 'true') {

          if ((isset($_GET['devotee']) && ($_GET['devotee'] != ''))) {
            $query->where('devotee_id', '=', $_GET['devotee']);
          }

          if ((isset($_GET['course']) && ($_GET['course'] != ''))) {
            $query->where('course_id', '=', $_GET['course']);
          }
        }
        $lists = $query->paginate(50);
        return view('backend.facilitator.index', compact('branches', 'devotees', 'courses', 'lists'));
      } catch (\Exception $e) {
        dd($e->getMessage());
        return redirect('/admin/course-facilitator')->with('error', 'An error occurred, please try again.');
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
         activity('Facilitator')->log('Viewed lists');
         $devotees = Devotees::orderBy('firstname', 'asc')->get();
         $lists = CourseFacilitator::all();
         $branches = Branch::where('status', 'Active')->orderBy('title', 'asc')->get();
         $courses = Courses::where('status', 'Active')->orderBy('title', 'asc')->get();
         return view('backend.facilitator.create', compact('lists', 'courses', 'devotees', 'branches'));
       } catch (\Exception $e) {
         return redirect('/admin/course-facilitator')->with('error', 'An error occurred, please try again.');
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
          $validatedData = $request->validate([
              'name' => 'required',
              'courses' => 'required|array',
              'courses.*' => 'required|integer|exists:courses,id|distinct',
          ], [
              'courses.*.distinct' => 'Duplicate user IDs are not allowed.',
          ]);
         $user = Auth::guard('admin')->user();

         $uniqueUserids = array_unique($validatedData['courses']);

        // Store the data
        CourseFacilitator::create([
            'devotee_id' => $validatedData['name'],
            'course_id' => $uniqueUserids,
            'branch_id' => $request['branch'],
            'status' => $request['status'],
            'createdby' => $user->id
        ]);

        activity('Facilitator')->log('Created Facilitator');
        return redirect('/admin/course-facilitator')->with('success', 'Data created successfully');

       } catch (\Exception $e) {
         return redirect('/admin/course-facilitator')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
       try {
         $edit = CourseFacilitator::find($id);
         $courses = Courses::where('status', 'Active')->orderBy('title', 'asc')->get();
         $devotees = Devotees::orderBy('firstname', 'asc')->get();
         $branches = Branch::where('status', 'Active')->orderBy('title', 'asc')->get();
         activity('Facilitator')->log('Edit page visited id ' . $id);
         return view('backend.facilitator.edit', compact('edit', 'courses', 'devotees', 'branches'));
       } catch (\Exception $e) {
         return redirect('/admin/course-facilitator')->with('error', 'An error occurred, please try again.');
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
         $request->validate([
           'name' => 'required',
           'course' => 'required'
         ]);
         $user = Auth::guard('admin')->user();
         $primary = CourseFacilitator::whereId($id)->update([
           'devotee_id' => $request['name'],
           'course_id' => $request['course'],
           'branch_id' => $request['branch'],
           'status' => $request['status'],
           'updatedby' => $user->id
         ]);

         activity('Facilitator')->log('Data updated id ' . $id);
         return redirect('/admin/course-facilitator')->with('success', 'Data updated successfully');
       } catch (\Exception $e) {
         return redirect('/admin/course-facilitator')->with('error', 'An error occurred, please try again.');
       }
     }

     public function movetotrash(Request $request, string $id)
     {
       try{
         $category = CourseFacilitator::findOrFail($id);
         $getdevotee = Devotees::find($category->devotee_id);
         $category->delete();
         activity('Facilitator')->log('Moved to Trash '.$getdevotee->firstname.' '.$getdevotee->middlename.' '.$getdevotee->surname);
         return redirect('/admin/course-facilitator-trash')->with('success', 'Data updated successfully');
       } catch (\Exception $e) {
         return redirect('/admin/course-facilitator-trash')->with('error', 'An error occurred, please try again.');
       }
     }

     /**
      * Update the specified resource in storage.
      */
     public function restore(Request $request, string $id)
     {
       try{
         $item = CourseFacilitator::withTrashed()->find($id);
         $getdevotee = Devotees::find($item->devotee_id);
         if ($item) {
             $item->restore();
         } else {
           return redirect('/admin/branch')->with('error', 'Data is not in the trash folder.');
         }
         activity('Facilitator')->log('Restore '.$getdevotee->firstname.' '.$getdevotee->middlename.' '.$getdevotee->surname);
         return redirect('/admin/course-facilitator')->with('success', 'Data updated successfully');
       } catch (\Exception $e) {
         return redirect('/admin/course-facilitator')->with('error', 'An error occurred, please try again.'.$e->getMessage());
       }
     }

     /**
      * Remove the specified resource from storage.
      */
     public function destroy(string $id)
     {
       try{
         $item = CourseFacilitator::withTrashed()->find($id);
         $getdevotee = Devotees::find($item->devotee_id);
         activity('Facilitator')->log('Data deleted ' . $getdevotee->firstname.' '.$getdevotee->middlename.' '.$getdevotee->surname);
         $item->forceDelete();
         return redirect('/admin/course-facilitator')->with('success', 'Data deleted successfully.');
       } catch (\Exception $e) {
         return redirect('/admin/course-facilitator')->with('error', 'An error occurred, please try again.'.$e->getMessage());
       }
     }
}
