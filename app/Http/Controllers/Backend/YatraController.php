<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Devotees;
use App\Models\Occupation;
use App\Models\Admin;
use App\Models\Yatra;
use App\Models\Branch;
use App\Models\YatraCategory;
use App\Models\YatraSeason;
use App\Models\YatraDocuments;
use Illuminate\Support\Str;
use DB;
use Auth;

class YatraController extends Controller
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
        activity('Yatra Category')->log('Viewed lists');
        $lists = Yatra::orderBy('created_at', 'desc')->get();
        return view('backend.yatra.index',compact('lists'));
      } catch (\Exception $e) {
        return redirect('/yatra')->with('error', 'An error occurred, please try again.');
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
        activity('Yatra')->log('Create.');
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $yatracategories = YatraCategory::where('status', 'Active')->get();
        $seasons = YatraSeason::where('status', 'Active')->get();
        return view('backend.yatra.create',compact('branches', 'devotees', 'yatracategories', 'seasons'));
      } catch (\Exception $e) {
        return redirect('/admin/yatra')->with('error', 'An error occurred, please try again.');
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
        $createrow = Yatra::create([
          'devotee_id' => $request['devotee'],
          'branch_id' => $request['branch'],
          'yatra_id' => $request['yatra'],
          'yatra_seasons_id' => $request['seasons'],
          'contact' => $request['contact'],
          'othertravel' => $request['othertravel'],
          'tnc' => $request['tnc'],
          'status' => $request['status'],
          'createdby' => $user->id
        ]);

        activity('Yatra')->log('Created id'.$createrow->id);
        return redirect()->back()->with('success', 'Data created successfully');
      } catch (\Exception $e) {
        return redirect('/admin/yatra')->with('error', 'An error occurred, please try again.');
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
        activity('Yatra')->log('Create.');
        $show = Yatra::find($id);
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $yatracategories = YatraCategory::where('status', 'Active')->get();
        $seasons = YatraSeason::where('status', 'Active')->get();
        $getseason = YatraSeason::find($show->yatra_seasons_id);
        $yatrapayments = YatraPayment::where('yatra_seasons_id', $show->yatra_seasons_id)->where('devotee_id', $show->devotee_id)->get();
        $yatradocuments = YatraDocuments::where('yatra_seasons_id', $show->yatra_seasons_id)->where('devotee_id', $show->devotee_id)->get();
        return view('backend.yatra.show',compact('show', 'branches', 'devotees', 'yatracategories', 'seasons', 'getseason', 'yatrapayments', 'yatradocuments'));
      } catch (\Exception $e) {
        return redirect('/admin/yatra')->with('error', 'An error occurred, please try again.');
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
        activity('Yatra')->log('Create.');
        $edit = Yatra::find($id);
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $yatracategories = YatraCategory::where('status', 'Active')->get();
        $seasons = YatraSeason::where('status', 'Active')->get();
        return view('backend.yatra.edit',compact('edit', 'branches', 'devotees', 'yatracategories', 'seasons'));
      } catch (\Exception $e) {
        return redirect('/admin/yatra')->with('error', 'An error occurred, please try again.');
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
        $slug = Str::slug($request['name'], '-');
        $primary = Yatra::whereId($id)->update([
          'devotee_id' => $request['devotee'],
          'branch_id' => $request['branch'],
          'yatra_id' => $request['yatra'],
          'yatra_seasons_id' => $request['seasons'],
          'contact' => $request['contact'],
          'othertravel' => $request['othertravel'],
          'tnc' => $request['tnc'],
          'status' => $request['status'],
          'updatedby' => $username
        ]);

        activity('Yatra')->log('Data updated id '.$id);
        return redirect('/admin/yatra')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/yatra')->with('error', 'An error occurred, please try again.');
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
          $data = Yatra::findOrFail($id);
          activity('Yatra')->log('Data deleted id '.$id);
          $data->delete();
          return redirect()->back()->with('success', 'Data deleted successfully.');
        } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred, please try again.');
      }
    }
}
