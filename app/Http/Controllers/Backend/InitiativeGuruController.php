<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\InitiativeGuru;
use App\Models\Devotees;
use App\Models\Initiation;
use Auth;

class InitiativeGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:initiative-list|initiative-create|initiative-edit|initiative-delete', ['only' => ['index','show']]);
         $this->middleware('permission:initiative-create', ['only' => ['create','store']]);
         $this->middleware('permission:initiative-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:initiative-delete', ['only' => ['destroy', 'download', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        activity('Initiative Guru')->log('Viewed lists');
        $lists = InitiativeGuru::orderBy('created_at', 'desc')->paginate(50);
        return view('backend.initiativeguru.index',compact('lists'));
      } catch (\Exception $e) {
        return redirect('/admin/initiative-guru')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Initiative Guru')->log('Viewed lists');
        $lists = InitiativeGuru::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        return view('backend.initiativeguru.index',compact('lists'));
      } catch (\Exception $e) {
        return redirect('/admin/initiative-guru')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        activity('Initiative Guru')->log('Create');
        $devotees = Devotees::all();
        return view('backend.initiativeguru.addedit', compact('devotees'));
      } catch (\Exception $e) {
        return redirect('/admin/initiative-guru')->with('error', 'An error occurred, please try again.');
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
        $rowexists = InitiativeGuru::where('name', $request['name'])->first();
        if($rowexists === null){
          $createrow = InitiativeGuru::create([
              'name' => $request['name'],
              'status' => $request['status'],
              'createdby' => $user->id
          ]);
          activity('Initiative Guru')->log('Created id '.$createrow->id);
          return redirect('/admin/initiative-guru')->with('success', 'Data created successfully.');
        }else{ return redirect('/admin/initiative-guru')->with('error', 'Data already created.');}
      } catch (\Exception $e) {
        return redirect('/admin/initiative-guru')->with('error', 'An error occurred, please try again.');
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
        $show = InitiativeGuru::find($id);
        $devotees = Devotees::all();
        $lists = Initiation::where('initiation_guru_id', $id)->where('initiation_type', 'Sheltered')->orderBy('created_at', 'desc')->get();
        activity('Mentor')->log('Show');
        return view('backend.initiativeguru.show',compact('devotees', 'show', 'lists'));
      } catch (\Exception $e) {
        return redirect('/admin/initiative-guru')->with('error', 'An error occurred, please try again.');
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
        $edit = InitiativeGuru::find($id);
        activity('Initiative Guru')->log('Edit viewed id '.$id);
        $devotees = Devotees::all();
        return view('backend.initiativeguru.addedit',compact('edit', 'devotees'));
      } catch (\Exception $e) {
        return redirect('/admin/initiative-guru')->with('error', 'An error occurred, please try again.');
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
        $primary = InitiativeGuru::whereId($id)->update([
            'name' => $request['name'],
            'status' => $request['status'],
            'updatedby' => $user->id
        ]);
        activity('Initiative Guru')->log('Data updated id '.$id);
        return redirect('/admin/initiative-guru')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/initiative-guru')->with('error', 'An error occurred, please try again.');
      }
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = InitiativeGuru::findOrFail($id);
        $category->delete();
        activity('Initiative Guru')->log('Moved to Trash');
        return redirect('/admin/initiative-guru-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/initiative-guru-trash')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = InitiativeGuru::withTrashed()->find($id);
        if ($item) {
            $item->restore();
        } else {
          return redirect('/admin/initiative-guru')->with('error', 'Data is not in the trash folder.');
        }
        activity('Initiative Guru')->log('Restore');
        return redirect('/admin/initiative-guru')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/initiative-guru')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      try{
        $item = InitiativeGuru::withTrashed()->find($id);
        activity('Initiative Guru')->log('Data deleted');
        $getdata = Initiation::where('initiation_guru_id', $id)->get();
        if($getdata->count() != NULL){
          return redirect('/admin/initiative-guru')->with('error', 'Please remove sub data before delete parent data.');
        }else{
          $item->forceDelete();
          return redirect('/admin/initiative-guru')->with('success', 'Data deleted successfully.');
        }
      } catch (\Exception $e) {
        return redirect('/admin/initiative-guru')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }
}
