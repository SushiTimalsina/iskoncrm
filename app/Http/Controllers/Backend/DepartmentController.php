<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Department;
use App\Models\AttendSewa;
use Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:department-list|department-create|department-edit|department-delete', ['only' => ['index','show']]);
         $this->middleware('permission:department-create', ['only' => ['create','store']]);
         $this->middleware('permission:department-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:department-delete', ['only' => ['destroy', 'download', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        $lists = Department::orderBy('created_at', 'desc')->where('parent_id',NULL)->paginate(50);
        $parentlists = Department::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();
        activity('Department')->log('Viewed lists');
        return view('backend.department.index',compact('lists', 'parentlists', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/department')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Department')->log('Viewed lists');
        $lists = Department::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $parentlists = Department::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();
        return view('backend.department.index',compact('lists', 'parentlists', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/department')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
      try{
          $user = Auth::guard('admin')->user();
          $createrow = Department::create([
            'title' => $request['name'],
            'parent_id' => $request['parent'],
            'branch_id' => $request['branch'],
            'status' => $request['status'],
            'createdby' => $user->id
          ]);
          activity('Department')->log('Data created id '.$createrow->id);
          return redirect('/admin/department')->with('success', 'Data created successfully');
      } catch (\Exception $e) {
        return redirect('/admin/department')->with('error', 'An error occurred, please try again.');
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
        $view = Department::find($id);
        $devotees = AttendSewa::orderBy('created_at', 'desc')->where('branch_id', $view->branch_id)->where('department_id', $id)->paginate(50);
        activity('Department')->log('View');
        $branches = Branch::where('status', 'Active')->get();
        return view('backend.department.show',compact('view', 'branches', 'devotees'));
      } catch (\Exception $e) {
        return redirect('/admin/department')->with('error', 'An error occurred, please try again.');
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
        $edit = Department::find($id);
        $childlists = Department::where('parent_id', '=', $id)->pluck('id');
        if($childlists != NULL){
          $child = ($childlists.','.$id);
        }else{
          $child = $id;
        }
        $lists = Department::where('status', 'Active')->whereNotIn('id', [$child])->get();
        activity('Department')->log('Edit page viewed id '.$id);
        $branches = Branch::where('status', 'Active')->get();
        return view('backend.department.edit',compact('edit', 'lists', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/department')->with('error', 'An error occurred, please try again.');
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
        $primary = Department::whereId($id)->update([
          'title' => $request['name'],
          'parent_id' => $request['parent'],
          'branch_id' => $request['branch'],
          'status' => $request['status'],
          'updatedby' => $user->id
        ]);

        $sub = Department::where('parent_id', $id)->update([
          'status' => $request['status'],
        ]);
        activity('Department')->log('Data updated id '.$id);
        return redirect('/admin/department')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/department')->with('error', 'An error occurred, please try again.');
      }
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = Department::findOrFail($id);
        $category->delete();
        activity('Department')->log('Moved to Trash '.$category->title);
        return redirect('/admin/department-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/department-trash')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = Department::withTrashed()->find($id);
        if ($item) {
            $item->restore();
        } else {
          return redirect('/admin/department')->with('error', 'Data is not in the trash folder.');
        }
        activity('Department')->log('Restore '.$item->title);
        return redirect('/admin/department')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/department')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      try{
        $item = Department::withTrashed()->find($id);
        $getdata = Department::where('parent_id', $id)->get();
        if($getdata->count() != NULL){
          activity('Department')->log('Trying deleting data '.$item->title);
          return redirect('/admin/department')->with('error', 'Please remove sub data before delete parent data.');
        }else{
          activity('Department')->log('Data deleted: '.$item->title);
          $item->forceDelete();
          return redirect('/admin/department')->with('success', 'Data deleted successfully.');
        }
      } catch (\Exception $e) {
        return redirect('/admin/department')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }
}
