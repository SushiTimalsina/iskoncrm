<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Branch;
use Auth;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:branch-list|branch-create|branch-edit|branch-delete', ['only' => ['index','show']]);
         $this->middleware('permission:branch-create', ['only' => ['create','store']]);
         $this->middleware('permission:branch-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:branch-delete', ['only' => ['destroy', 'trash']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        activity('Branch')->log('Viewed lists');
        $lists = Branch::orderBy('created_at', 'desc')->where('parent_id',NULL)->paginate(50);
        $parentlists = Branch::where('status', 'Active')->get();
        return view('backend.branch.index',compact('lists', 'parentlists'));
      } catch (\Exception $e) {
        return redirect('/admin/branch')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Branch')->log('Viewed lists');
        $lists = Branch::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $parentlists = Branch::where('status', 'Active')->get();
        return view('backend.branch.index',compact('lists', 'parentlists'));
      } catch (\Exception $e) {
        return redirect('/admin/branch')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $rowexists = Branch::where('title', $request['name'])->first();
        if($rowexists === null){
          $createrow = Branch::create([
            'title' => $request['name'],
            'parent_id' => $request['parent'],
            'status' => $request['status'],
            'createdby' => $user->id
          ]);
          activity('Branch')->log('Created: '.$createrow->title);
          return redirect('/admin/branch')->with('success', 'Data created successfully.');
        }else{ return redirect('/admin/branch')->with('error', 'Data already created.');}
      } catch (\Exception $e) {
        return redirect('/admin/branch')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $edit = Branch::find($id);
        $childlists = Branch::where('parent_id', '=', $id)->pluck('id');
        if($childlists->count() != NULL){
          $child = [$childlists, $id];
        }else{ $child = $id;}
        $lists = Branch::where('status', 'Active')->whereNotIn('id', [$child])->get();
        activity('Branch')->log('Edit page viewed: '.$edit->title);
        return view('backend.branch.edit',compact('edit', 'lists'));
      } catch (\Exception $e) {
        return redirect('/admin/branch')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $primary = Branch::whereId($id)->update([
          'title' => $request['name'],
          'parent_id' => $request['parent'],
          'status' => $request['status'],
          'updatedby' => $user->id
        ]);

        $sub = Branch::where('parent_id', $id)->update([
          'status' => $request['status'],
        ]);

        activity('Branch')->log('Data updated: '.$request['name']);

        return redirect('/admin/branch')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/branch')->with('error', 'An error occurred, please try again.');
      }
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = Branch::findOrFail($id);
        $category->delete();
        activity('branch')->log('Moved to Trash '.$category->title);
        return redirect('/admin/branch-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/branch-trash')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = Branch::withTrashed()->find($id);
        if ($item) {
            $item->restore();
        } else {
          return redirect('/admin/branch')->with('error', 'Data is not in the trash folder.');
        }
        activity('Branch')->log('Restore '.$item->title);
        return redirect('/admin/branch')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/branch')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      try{
        $item = Branch::withTrashed()->find($id);
        $getdata = Branch::where('parent_id', $id)->get();
        if($getdata->count() != NULL){
          activity('Branch')->log('Trying deleting data '.$item->title);
          return redirect('/admin/branch')->with('error', 'Please remove sub data before delete parent data.');
        }else{
          activity('Branch')->log('Data deleted: '.$item->title);
          $item->forceDelete();
          return redirect('/admin/branch')->with('success', 'Data deleted successfully.');
        }
      } catch (\Exception $e) {
        return redirect('/admin/branch')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }
}
