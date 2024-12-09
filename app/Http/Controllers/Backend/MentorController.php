<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Devotees;
use App\Models\Mentor;
use Auth;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:mentor-list|mentor-create|mentor-edit|mentor-delete', ['only' => ['index','show']]);
         $this->middleware('permission:mentor-create', ['only' => ['create','store']]);
         $this->middleware('permission:mentor-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:mentor-delete', ['only' => ['destroy', 'download', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        activity('Mentor')->log('Viewed lists');
        $lists = Mentor::orderBy('created_at', 'desc')->paginate(50);
        $mentors = Mentor::orderBy('created_at', 'desc')->get();
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        return view('backend.mentor.index',compact('lists', 'branches', 'devotees', 'mentors'));
        } catch (\Exception $e) {
        return redirect('/admin/mentor')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Mentor')->log('Viewed lists');
        $lists = Mentor::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $mentors = Mentor::orderBy('created_at', 'desc')->get();
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        return view('backend.mentor.index',compact('lists', 'mentors', 'branches', 'devotees'));
      } catch (\Exception $e) {
        return redirect('/admin/mentor')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        activity('Mentor')->log('Search');
        $branches = Branch::where('status', 'Active')->get();
        $mentors = Mentor::orderBy('created_at', 'desc')->get();
        $devotees = Devotees::all();

        $query = Mentor::orderBy('created_at', 'desc');

        if($request['mentor']){
          $lists = $query->where('devotee_id', $request['mentor']);
        }

        if($request['branch']){
          $query->where('branch_id', $request['branch']);
        }

        $lists = $query->paginate(50);


        return view('backend.mentor.index',compact('lists', 'devotees', 'branches', 'mentors'));
      } catch (\Exception $e) {
        return redirect('/admin/mentor')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
          $devotees = Devotees::all();
          $branches = Branch::where('status', 'Active')->get();
          activity('Mentor')->log('Create');
          return view('backend.mentor.addedit',compact('devotees', 'branches'));
        } catch (\Exception $e) {
        return redirect('/admin/mentor')->with('error', 'An error occurred, please try again.');
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
          $rowexists = Mentor::where('devotee_id', $request['devotee'])->first();
          if($rowexists === null){
            $createrow = Mentor::create([
                'devotee_id' => $request['devotee'],
                'branch_id' => $request['branch'],
                'status' => $request['status'],
                'createdby' => $user->id
            ]);
            activity('Mentor')->log('Created id '.$createrow->id);
            return redirect('/admin/mentor')->with('success', 'Data created successfully.');
          }else{ return redirect('/admin/mentor')->with('error', 'Data already created.');}


        } catch (\Exception $e) {
        return redirect('/admin/mentor')->with('error', 'An error occurred, please try again.');
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
        $show = Mentor::find($id);
        $devotees = Devotees::all();
        $lists = Devotees::where('mentor', $id)->orderBy('created_at', 'desc')->get();
        $branches = Branch::where('status', 'Active')->get();
        activity('Mentor')->log('Show');
        return view('backend.mentor.show',compact('devotees', 'branches', 'show', 'lists'));

        } catch (\Exception $e) {
        return redirect('/admin/mentor')->with('error', 'An error occurred, please try again.');
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
        $edit = Mentor::find($id);
        $devotees = Devotees::all();
        $branches = Branch::all();
        activity('Mentor')->log('Edit viewed id '.$id);
        return view('backend.mentor.addedit',compact('edit', 'branches', 'devotees'));
        } catch (\Exception $e) {
          return redirect('/admin/mentor')->with('error', 'An error occurred, please try again.');
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
        $primary = Mentor::whereId($id)->update([
            'branch_id' => $request['branch'],
            'status' => $request['status'],
            'createdby' => $user->id
        ]);

        activity('Mentor')->log('Data updated id '.$id);
        return redirect('/admin/mentor')->with('success', 'Data updated successfully');

        } catch (\Exception $e) {
        return redirect('/admin/mentor')->with('error', 'An error occurred, please try again.');
      }
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = Mentor::findOrFail($id);
        $getdevotee = Devotees::find($category->devotee_id);
        $category->delete();
        activity('Mentor')->log('Moved to Trash '.$getdevotee->firstname.' '.$getdevotee->middlename.' '.$getdevotee->surname);
        return redirect('/admin/mentor-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/mentor-trash')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = Mentor::withTrashed()->find($id);
        $getdevotee = Devotees::find($item->devotee_id);
        if ($item) {
            $item->restore();
        } else {
          return redirect('/admin/mentor')->with('error', 'Data is not in the trash folder.');
        }
        activity('Mentor')->log('Restore '.$getdevotee->firstname.' '.$getdevotee->middlename.' '.$getdevotee->surname);
        return redirect('/admin/mentor')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/mentor')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      try{
        $item = Mentor::withTrashed()->find($id);
        $getdevotee = Devotees::where('mentor', $id)->exists();
        if($getdevotee){
          activity('Mentor')->log('Trying deleting data');
          return redirect('/admin/mentor')->with('error', 'Please change mentor from devotee and try again!');
        }else{
          activity('Mentor')->log('Data deleted');
          $item->forceDelete();
          return redirect('/admin/mentor')->with('success', 'Data deleted successfully.');
        }
      } catch (\Exception $e) {
        return redirect('/admin/mentor')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    public function adddevotee(Request $request, string $id)
    {
      try{
        $category = Mentor::findOrFail($id);
        $getdevotee = Devotees::find($category->devotee_id);
        $category->delete();
        activity('Mentor')->log('Moved to Trash '.$getdevotee->firstname.' '.$getdevotee->middlename.' '.$getdevotee->surname);
        return redirect('/admin/mentor-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/mentor-trash')->with('error', 'An error occurred, please try again.');
      }
    }
}
