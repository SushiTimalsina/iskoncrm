<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Occupation;
use App\Models\Devotees;
use Auth;

class OccupationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:occupations-list|occupations-create|occupations-edit|occupations-delete', ['only' => ['index','show']]);
         $this->middleware('permission:occupations-create', ['only' => ['create','store']]);
         $this->middleware('permission:occupations-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:occupations-delete', ['only' => ['destroy', 'download', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        $lists = Occupation::orderBy('created_at', 'desc')->where('parent_id',NULL)->paginate(50);
        $parentlists = Occupation::where('status', 'Active')->where('parent_id',NULL)->get();
        activity('Occupation')->log('Viewed lists');
        return view('backend.occupations.index',compact('lists', 'parentlists'));
      } catch (\Exception $e) {
        return redirect('/admin/occupations')->with('error', 'An error occurred, please try again.');
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
        activity('Occupation')->log('Search');
        $lists = Occupation::orderBy('created_at', 'desc')->where('title', 'LIKE', '%' . $request['search'] . '%')->paginate(50);
        $parentlists = Occupation::where('status', 'Active')->where('parent_id',NULL)->get();
        return view('backend.occupations.index',compact('lists', 'parentlists'));
      } catch (\Exception $e) {
        return redirect('/admin/occupations')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Occupation')->log('Viewed lists');
        $lists = Occupation::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $parentlists = Occupation::where('status', 'Active')->where('parent_id',NULL)->get();
        return view('backend.occupations.index',compact('lists', 'parentlists'));
      } catch (\Exception $e) {
        return redirect('/admin/occupations')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
          $rowexists = Occupation::where('title', $request['name'])->first();
          if($rowexists === null){
          $createrow = Occupation::create([
            'title' => $request['name'],
            'parent_id' => $request['parent'],
            'status' => $request['status'],
            'createdby' => $user->id
          ]);
          activity('Occupation')->log('Data created: '.$request['name']);
          return redirect('/admin/occupations')->with('success', 'Data created successfully');
        }else{ return redirect('/admin/occupations')->with('error', 'Data already created.');}
      } catch (\Exception $e) {
        return redirect('/admin/occupations')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
      $show = Occupation::withoutTrashed()->find($id);
      $devotees = Devotees::withoutTrashed()->where('occupations', $id)->get();
      return view('backend.occupations.show',compact('show', 'devotees'));
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
        $edit = Occupation::find($id);
        $childlists = Occupation::where('parent_id', '=', $id)->pluck('id');
        if($childlists != NULL){
          $child = ($childlists.','.$id);
        }else{
          $child = $id;
        }
        $lists = Occupation::where('status', 'Active')->whereNotIn('id', [$child])->get();
        activity('Occupation')->log('Edit page viewed id '.$id);
        return view('backend.occupations.edit',compact('edit', 'lists'));
      } catch (\Exception $e) {
        return redirect('/admin/occupations')->with('error', 'An error occurred, please try again.');
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
        $primary = Occupation::whereId($id)->update([
          'title' => $request['name'],
          'parent_id' => $request['parent'],
          'status' => $request['status'],
          'updatedby' => $user->id
        ]);
        $sub = Occupation::where('parent_id', $id)->update([
          'status' => $request['status'],
        ]);
        activity('Occupation')->log('Data updated id '.$id);
        return redirect('/admin/occupations')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/occupations')->with('error', 'An error occurred, please try again.');
      }
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = Occupation::findOrFail($id);
        $category->delete();
        activity('Occupation')->log('Moved to Trash '.$category->title);
        return redirect('/admin/occupation-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/occupation-trash')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = Occupation::withTrashed()->find($id);
        if ($item) {
            $item->restore();
        } else {
          return redirect('/admin/occupations')->with('error', 'Data is not in the trash folder.');
        }
        activity('Occupation')->log('Restore '.$item->title);
        return redirect('/admin/occupations')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/occupations')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      try{
        $item = Occupation::withTrashed()->find($id);
        $getdata = Occupation::where('parent_id', $id)->get();
        if($getdata->count() != NULL){
          activity('Occupation')->log('Trying deleting data '.$item->title);
          return redirect('/admin/occupations')->with('error', 'Please remove sub data before delete parent data.');
        }else{
          activity('Occupation')->log('Data deleted: '.$item->title);
          $item->forceDelete();
          return redirect('/admin/occupations')->with('success', 'Data deleted successfully.');
        }
      } catch (\Exception $e) {
        return redirect('/admin/occupations')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }
}
