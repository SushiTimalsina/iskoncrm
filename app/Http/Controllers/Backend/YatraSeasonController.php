<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Yatra;
use App\Models\Branch;
use App\Models\Devotees;
use App\Models\Occupation;
use App\Models\YatraSeason;
use App\Models\YatraCategory;
use Illuminate\Support\Str;
use DB;

class YatraSeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:yatra-list|yatra-create|yatra-edit|yatra-delete', ['only' => ['index','show']]);
         $this->middleware('permission:yatra-create', ['only' => ['create','store']]);
         $this->middleware('permission:yatra-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:yatra-delete', ['only' => ['destroy', 'download', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        activity('Yatra Season')->log('Viewed lists');
        $lists = YatraSeason::orderBy('created_at', 'desc')->get();
        $yatracategories = YatraCategory::where('status', 'Active')->get();
        return view('backend.yatra-season.index',compact('lists', 'yatracategories'));
      } catch (\Exception $e) {
        return redirect('/admin/yatra-season')->with('error', 'An error occurred, please try again.');
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
        activity('Yatra Season')->log('Create.');
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $yatracategories = YatraCategory::where('status', 'Active')->get();
        $occupations = Occupation::where('status', 'Active')->get();
        return view('backend.yatra-season.create',compact('branches', 'devotees', 'yatracategories'));
      } catch (\Exception $e) {
        return redirect('/admin/yatra-season')->with('error', 'An error occurred, please try again.');
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
        $createrow = YatraSeason::create([
          'yatra_id' => $request['yatra'],
          'name' => $request['name'],
          'price' => $request['price'],
          'pricedetails' => $request['pricedetails'],
          'route' => $request['route'],
          'status' => $request['status'],
          'createdby' => $user->id
        ]);

        activity('Yatra Season')->log('Created id'.$createrow->id);
        return redirect('/admin/yatra-season/'.$createrow->id)->with('success', 'Data created successfully');
      } catch (\Exception $e) {
        return redirect('/admin/yatra-season')->with('error', 'An error occurred, please try again.');
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
        activity('Yatra Season')->log('Create.');
        $show = YatraSeason::find($id);
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $yatracategories = YatraCategory::where('status', 'Active')->get();
        $related_devotees = Yatra::where('yatra_seasons_id', $id)->orderBy('created_at', 'desc')->get();
        return view('backend.yatra-season.show',compact('show', 'branches', 'devotees', 'yatracategories', 'related_devotees', 'rooms'));
      } catch (\Exception $e) {
        return redirect('/admin/yatra-season')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        activity('Yatra Season')->log('Create.');
        $edit = YatraSeason::find($id);
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $yatracategories = YatraCategory::where('status', 'Active')->get();
        return view('backend.yatra-season.edit',compact('edit', 'branches', 'devotees', 'yatracategories'));
      } catch (\Exception $e) {
        return redirect('/admin/yatra-season')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $primary = YatraSeason::whereId($id)->update([
          'yatra_id' => $request['yatra'],
          'name' => $request['name'],
          'price' => $request['price'],
          'pricedetails' => $request['pricedetails'],
          'route' => $request['route'],
          'status' => $request['status'],
          'createdby' => $user->id
        ]);

        activity('Yatra Season')->log('Data updated id '.$id);
        return redirect('/admin/yatra-season')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/yatra-season')->with('error', 'An error occurred, please try again.');
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
          $data = YatraSeason::findOrFail($id);
          activity('Yatra Season')->log('Data deleted id '.$id);
          $data->delete();
          return redirect('/admin/yatra-season')->with('success', 'Data deleted successfully.');
        } catch (\Exception $e) {
        return redirect('/admin/yatra-season')->with('error', 'An error occurred, please try again.');
      }
    }
}
