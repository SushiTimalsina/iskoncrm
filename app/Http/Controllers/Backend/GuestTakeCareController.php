<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuestTakeCare;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Devotees;
use Auth;

class GuestTakeCareController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:guest-take-care-list|guest-take-care-create|guest-take-care-edit|guest-take-care-delete', ['only' => ['index','show']]);
         $this->middleware('permission:guest-take-care-create', ['only' => ['create','store']]);
         $this->middleware('permission:guest-take-care-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:guest-take-care-delete', ['only' => ['destroy', 'download', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        activity('Guest Take Care')->log('Viewed lists');
        $lists = GuestTakeCare::orderBy('created_at', 'desc')->paginate(50);
        $mentors = GuestTakeCare::orderBy('created_at', 'desc')->get();
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        return view('backend.takecare.index',compact('lists', 'branches', 'devotees', 'mentors'));
        } catch (\Exception $e) {
        return redirect('/admin/take-care')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Guest Take Care')->log('Viewed lists');
        $lists = GuestTakeCare::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $mentors = GuestTakeCare::orderBy('created_at', 'desc')->get();
        $branches = Branch::where('status', 'Active')->get();
        $devotees = Devotees::all();
        return view('backend.takecare.index',compact('lists', 'mentors', 'branches', 'devotees'));
      } catch (\Exception $e) {
        return redirect('/admin/take-care')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        activity('Guest Take Care')->log('Search');
        $branches = Branch::where('status', 'Active')->get();
        $mentors = GuestTakeCare::orderBy('created_at', 'desc')->get();
        $devotees = Devotees::all();

        $query = GuestTakeCare::orderBy('created_at', 'desc');

        if($request['takecare']){
          $lists = $query->where('devotee_id', $request['takecare']);
        }

        if($request['branch']){
          $query->where('branch_id', $request['branch']);
        }

        $lists = $query->paginate(50);


        return view('backend.takecare.index',compact('lists', 'devotees', 'branches', 'mentors'));
      } catch (\Exception $e) {
        return redirect('/admin/guest-take-care')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
          activity('Guest Take Care')->log('Create');
          return view('backend.takecare.addedit',compact('devotees', 'branches'));
        } catch (\Exception $e) {
        return redirect('/admin/take-care')->with('error', 'An error occurred, please try again.');
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
          $rowexists = GuestTakeCare::where('devotee_id', $request['devotee'])->where('branch_id', $request['branch'])->first();
          if($rowexists === null){
            $createrow = GuestTakeCare::create([
                'devotee_id' => $request['devotee'],
                'branch_id' => $request['branch'],
                'status' => $request['status'],
                'createdby' => $user->id
            ]);
            activity('Guest Take Care')->log('Created id '.$createrow->id);
            return redirect('/admin/guest-take-care')->with('success', 'Data created successfully.');
          }else{ return redirect('/admin/guest-take-care')->with('error', 'Data already created.');}


        } catch (\Exception $e) {
        return redirect('/admin/guest-take-care')->with('error', 'An error occurred, please try again.');
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
        $show = GuestTakeCare::find($id);
        $devotees = Devotees::all();
        $lists = Devotees::where('mentor', $id)->orderBy('created_at', 'desc')->get();
        $branches = Branch::where('status', 'Active')->get();
        activity('Guest Take Care')->log('Show');
        return view('backend.takecare.show',compact('devotees', 'branches', 'show', 'lists'));

        } catch (\Exception $e) {
        return redirect('/admin/guest-take-care')->with('error', 'An error occurred, please try again.');
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
        $edit = GuestTakeCare::find($id);
        $devotees = Devotees::all();
        $branches = Branch::all();
        activity('Guest Take Care')->log('Edit viewed id '.$id);
        return view('backend.takecare.addedit',compact('edit', 'branches', 'devotees'));
        } catch (\Exception $e) {
          return redirect('/admin/guest-take-care')->with('error', 'An error occurred, please try again.');
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
        $primary = GuestTakeCare::whereId($id)->update([
            'branch_id' => $request['branch'],
            'status' => $request['status'],
            'createdby' => $user->id
        ]);

        activity('Guest Take Care')->log('Data updated id '.$id);
        return redirect('/admin/guest-take-care')->with('success', 'Data updated successfully');

        } catch (\Exception $e) {
        return redirect('/admin/guest-take-care')->with('error', 'An error occurred, please try again.');
      }
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = GuestTakeCare::findOrFail($id);
        $category->delete();
        activity('Guest Take Care')->log('Moved to Trash');
        return redirect('/admin/guest-take-care-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/guest-take-care-trash')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = GuestTakeCare::withTrashed()->find($id);
        $item->restore();
        activity('Guest Take Care')->log('Restore');
        return redirect('/admin/guest-take-care')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/guest-take-care')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      try{
        $item = GuestTakeCare::withTrashed()->find($id);
        activity('Guest Take Care')->log('Data deleted');
        $item->forceDelete();
        return redirect('/admin/guest-take-care')->with('success', 'Data deleted successfully.');
      } catch (\Exception $e) {
        return redirect('/admin/guest-take-care')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }
}
