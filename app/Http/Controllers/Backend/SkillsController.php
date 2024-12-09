<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth;
use App\Models\Skills;
use App\Models\DevoteeSkills;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:skills-list|skills-create|skills-edit|skills-delete', ['only' => ['index','show']]);
         $this->middleware('permission:skills-create', ['only' => ['create','store']]);
         $this->middleware('permission:skills-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:skills-delete', ['only' => ['destroy', 'download', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        $lists = Skills::orderBy('created_at', 'desc')->where('parent_id',NULL)->paginate(50);
        $parentlists = Skills::where('status', 'Active')->get();
        activity('Skills')->log('Viewed lists');
        return view('backend.skills.index',compact('lists', 'parentlists'));
      } catch (\Exception $e) {
        return redirect('/admin/skills')->with('error', 'An error occurred, please try again.');
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
        activity('Skills')->log('Search');
        $lists = Skills::orderBy('created_at', 'desc')->where('title', 'LIKE', '%' . $request['search'] . '%')->paginate(50);
        $parentlists = Skills::where('status', 'Active')->get();
        return view('backend.skills.index',compact('lists', 'parentlists'));
      } catch (\Exception $e) {
        return redirect('/admin/skills')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Branch')->log('Viewed lists');
        $lists = Skills::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $parentlists = Skills::where('status', 'Active')->get();
        return view('backend.skills.index',compact('lists', 'parentlists'));
      } catch (\Exception $e) {
        return redirect('/admin/skills')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
          $rowexists = Skills::where('title', $request['name'])->first();
          if($rowexists === null){
          $createrow = Skills::create([
            'title' => $request['name'],
            'parent_id' => $request['parent'],
            'status' => $request['status'],
            'createdby' => $user->id
          ]);
          activity('Skills')->log('Data created: '.$createrow->title);
          return redirect('/admin/skills')->with('success', 'Data created successfully');
        }else{ return redirect('/admin/skills')->with('error', 'Data already created.');}
      } catch (\Exception $e) {
        return redirect('/admin/skills')->with('error', 'An error occurred, please try again.');
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
      $show = Skills::withoutTrashed()->find($id);
      $devoteeskills = DevoteeSkills::where('skill_id', $id)->get();
      return view('backend.skills.show',compact('show', 'devoteeskills'));
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
        $edit = Skills::find($id);
        $childlists = Skills::where('parent_id', '=', $id)->pluck('id');
        if($childlists != NULL){
          $child = ($childlists.','.$id);
        }else{
          $child = $id;
        }
        $lists = Skills::where('status', 'Active')->whereNotIn('id', [$child])->get();
        activity('Skills')->log('Edit page viewed:  '.$edit->title);
        return view('backend.skills.edit',compact('edit', 'lists'));
      } catch (\Exception $e) {
        return redirect('/admin/skills')->with('error', 'An error occurred, please try again.');
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
        $primary = Skills::whereId($id)->update([
          'title' => $request['name'],
          'parent_id' => $request['parent'],
          'status' => $request['status'],
          'updatedby' => $user->id
        ]);

        $sub = Skills::where('parent_id', $id)->update([
          'status' => $request['status'],
        ]);

        activity('Skills')->log('Data updated: '.$request['name']);
        return redirect('/admin/skills')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/skills')->with('error', 'An error occurred, please try again.');
      }
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = Skills::findOrFail($id);
        $category->delete();
        activity('Skills')->log('Moved to Trash '.$category->title);
        return redirect('/admin/skill-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/skill-trash')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = Skills::withTrashed()->find($id);
        if ($item) {
            $item->restore();
        } else {
          return redirect('/admin/skills')->with('error', 'Data is not in the trash folder.');
        }
        activity('Skills')->log('Restore '.$item->title);
        return redirect('/admin/skills')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/skills')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      try{
        $item = Skills::withTrashed()->find($id);
        $getdata = Skills::where('parent_id', $id)->get();
        if($getdata->count() != NULL){
          activity('Skills')->log('Trying deleting data '.$item->title);
          return redirect('/admin/branch')->with('error', 'Please remove sub data before delete parent data.');
        }else{
          activity('Skills')->log('Data deleted: '.$item->title);
          $item->forceDelete();
          return redirect('/admin/skills')->with('success', 'Data deleted successfully.');
        }
      } catch (\Exception $e) {
        return redirect('/admin/skills')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }
}
