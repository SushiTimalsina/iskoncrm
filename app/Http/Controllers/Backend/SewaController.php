<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Sewa;
use App\Models\Branch;
use Auth;

class SewaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:sewa-list|sewa-create|sewa-edit|sewa-delete', ['only' => ['index','show']]);
         $this->middleware('permission:sewa-create', ['only' => ['create','store']]);
         $this->middleware('permission:sewa-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sewa-delete', ['only' => ['destroy', 'download', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        $lists = Sewa::orderBy('created_at', 'desc')->where('parent_id',NULL)->paginate(50);
        $parentlists = Sewa::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();
        activity('Sewa')->log('Viewed lists');
        return view('backend.sewa.index',compact('lists', 'parentlists', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/sewa')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Sewa')->log('Trash lists');
        $lists = Sewa::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $parentlists = Sewa::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();
        return view('backend.sewa.index',compact('lists', 'parentlists', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/sewa')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $createrow = Sewa::create([
          'title' => $request['name'],
          'parent_id' => $request['parent'],
          'branch_id' => $request['branch'],
          'status' => $request['status'],
          'createdby' => $user->id
        ]);
        activity('Sewa')->log('Data stored id '.$createrow->id);
        return redirect('/admin/sewa')->with('success', 'Data created successfully');
      } catch (\Exception $e) {
        return redirect('/admin/sewa')->with('error', 'An error occurred, please try again.');
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
        $edit = Sewa::find($id);
        $childlists = Sewa::where('parent_id', '=', $id)->pluck('id');
        if($childlists->count() != NULL){
          $child = [$childlists, $id];
        }else{ $child = $id;}
        $lists = Sewa::where('status', 'Active')->whereNotIn('id', [$child])->get();
        $branches = Branch::where('status', 'Active')->get();
        activity('Sewa')->log('Edit viewed id '.$id);
        return view('backend.sewa.edit',compact('edit', 'lists', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/sewa')->with('error', 'An error occurred, please try again.');
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
        $primary = Sewa::whereId($id)->update([
          'title' => $request['name'],
          'parent_id' => $request['parent'],
          'branch_id' => $request['branch'],
          'status' => $request['status'],
          'updatedby' => $user->id
        ]);
        $sub = Sewa::where('parent_id', $id)->update([
          'status' => $request['status'],
        ]);
        activity('Sewa')->log('Data updated id '.$id);
        return redirect('/admin/sewa')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/sewa')->with('error', 'An error occurred, please try again.');
      }
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = Sewa::findOrFail($id);
        $category->delete();
        activity('Sewa')->log('Moved to Trash '.$category->title);
        return redirect('/admin/sewa-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/sewa-trash')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = Sewa::withTrashed()->find($id);
        if ($item) {
            $item->restore();
        } else {
          return redirect('/admin/sewa')->with('error', 'Data is not in the trash folder.');
        }
        activity('Sewa')->log('Restore '.$item->title);
        return redirect('/admin/sewa')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/sewa')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      try{
        $item = Sewa::withTrashed()->find($id);
        $getdata = Sewa::where('parent_id', $id)->get();
        if($getdata->count() != NULL){
          activity('Sewa')->log('Trying deleting data '.$item->title);
          return redirect('/admin/sewa')->with('error', 'Please remove sub data before delete parent data.');
        }else{
          activity('Sewa')->log('Data deleted: '.$item->title);
          $item->forceDelete();
          return redirect('/admin/sewa')->with('success', 'Data deleted successfully.');
        }
      } catch (\Exception $e) {
        return redirect('/admin/sewa')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }
}
