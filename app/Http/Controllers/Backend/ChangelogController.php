<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Changelog;
use Auth;

class ChangelogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:changelog-list|changelog-create|changelog-edit|changelog-delete', ['only' => ['index','show']]);
         $this->middleware('permission:changelog-create', ['only' => ['create','store']]);
         $this->middleware('permission:changelog-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:changelog-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        activity('Changelog')->log('Viewed lists');
        $lists = Changelog::orderBy('created_at', 'desc')->get();
        return view('backend.changelog.index',compact('lists'));
      } catch (\Exception $e) {
        return redirect('/admin/courses')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewpage()
    {
      try{
        activity('Changelog')->log('Viewed Page');
        $lists = Changelog::orderBy('created_at', 'desc')->get();
        return view('backend.changelog.view',compact('lists'));
      } catch (\Exception $e) {
        return redirect('/admin/courses')->with('error', 'An error occurred, please try again.');
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
        $createrow = Changelog::create([
          'title' => $request['name'],
          'description' => $request['description'],
          'createdby' => $user->id
        ]);
        activity('Changelog')->log('Created Changelog '. $createrow->title);
        return redirect('/admin/changelog')->with('success', 'Data created successfully');
      } catch (\Exception $e) {
        return redirect('/admin/changelog')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $edit = Changelog::find($id);
        activity('Changelog')->log('Changelog Edit '.$edit->title);
        return view('backend.changelog.edit',compact('edit'));
      } catch (\Exception $e) {
        return redirect('/admin/changelog')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $primary = Changelog::whereId($id)->update([
          'title' => $request['name'],
          'description' => $request['description'],
          'updatedby' => $user->id
        ]);
        activity('Changelog')->log('Data updated: '.$request['name']);
        return redirect('/admin/changelog')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/changelog')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      try{
        $data = Changelog::findOrFail($id);
        activity('Changelog')->log('Data deleted '.$data->title);
        $data->Delete();
        return redirect('/admin/changelog')->with('success', 'Data deleted successfully.');
      } catch (\Exception $e) {
        return redirect('/admin/changelog')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }
}
