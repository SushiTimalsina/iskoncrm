<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Initiation;
use App\Models\Devotees;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Department;
use App\Models\InitiativeGuru;
use App\Models\InitiationFiles;
use App\Models\Mentor;
use Storage;
use Session;
use Auth;

class InitiativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:initiative-list|initiative-create|initiative-edit|initiative-delete', ['only' => ['index','show']]);
         $this->middleware('permission:initiative-create', ['only' => ['create','store', 'firstform']]);
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
        activity('Initiation')->log('Viewed lists');
        $lists = Initiation::orderBy('created_at', 'desc')->paginate(50);
        $initiativegurus = InitiativeGuru::orderBy('created_at', 'desc')->get();
        $devotees = Devotees::all();
        $branches = Branch::where('status', 'Active')->get();
        $departments = Department::where('status', 'Active')->get();
        return view('backend.initiation.index',compact('lists', 'devotees', 'branches', 'departments', 'initiativegurus'));
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Initiation')->log('Viewed lists');
        $lists = Initiation::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $initiativegurus = InitiativeGuru::orderBy('created_at', 'desc')->get();
        $devotees = Devotees::all();
        $branches = Branch::where('status', 'Active')->get();
        $departments = Department::where('status', 'Active')->get();
        return view('backend.initiation.index',compact('lists', 'devotees', 'branches', 'departments', 'initiativegurus'));
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        activity('Initiation')->log('Search');
        $lists = Initiation::orderBy('created_at', 'desc')->paginate(50);
        $devotees = Devotees::all();
        $branches = Branch::where('status', 'Active')->get();
        $departments = Department::where('status', 'Active')->get();
        $initiativegurus = InitiativeGuru::orderBy('created_at', 'desc')->get();

        $json = $request['search'];
        $json = json_decode($json);
        $getvalues = collect($json)->pluck('value')->toArray();

        $query = Initiation::orderBy('created_at', 'desc');

        if($json != NULL){
          $lists = $query->where('devotee_id', $getvalues);
        }

        if($request['initiationguru']){
          $query->where('initiation_guru_id', $request['initiationguru']);
        }

        $lists = $query->paginate(50);


        return view('backend.initiation.index',compact('lists', 'devotees', 'branches', 'departments', 'initiativegurus'));
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      try{
        $request->session()->forget('initiation');
        $initiativegurus = InitiativeGuru::where('status', 'Active')->get();
        $devotees = Devotees::where('status', 'Active')->orderBy('firstname', 'asc')->get();
        $mentors = Mentor::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->orderBy('title', 'asc')->get();
        activity('Initiation')->log('Create');
        $initiation = $request->session()->get('initiation');
        return view('backend.initiation.firstform',compact('devotees', 'initiativegurus', 'initiation', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.', $e->getMessage());
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postfirstform(Request $request)
    {
      try{

        $validatedData = $request->validate([
           'devotee_id' => 'required',
           'initiation_type' => 'required',
           'branch_id' => 'required'
       ]);

       $devotee_id = $request['devotee_id'];
       $initiation_type = $request['initiation_type'];

       if(empty($request->session()->get('initiation'))){
           $initiation = new Initiation();
           $initiation->fill($validatedData);
           $request->session()->put('initiation', $initiation);
       }else{
           $initiation = $request->session()->get('initiation');
           $initiation->fill($validatedData);
           $request->session()->put('initiation', $initiation);
       }

       $initiation = $request->session()->get('initiation');

       if (Initiation::where('devotee_id', $initiation->devotee_id)->where('initiation_type', $initiation->initiation_type)->exists()) {
         $request->session()->forget('initiation');
         return redirect('/admin/initiation')->with('error', 'This devotee has already been initiated.');
       }

       if($initiation->initiation_type === "Harinam Initiation"){
         if (Initiation::where('devotee_id', $initiation->devotee_id)->where('initiation_type', 'Shelter')->doesntExist()) {
           $request->session()->forget('initiation');
           return redirect('/admin/initiation')->with('error', 'Please enter Shelter info then try for Harinaam Initiation.');
         }
       }

       if($initiation->initiation_type === "Brahman Initiation"){
         if (Initiation::where('devotee_id', $initiation->devotee_id)->where('initiation_type', 'Harinam Initiation')->doesntExist()) {
           $request->session()->forget('initiation');
           return redirect('/admin/initiation')->with('error', 'Please enter Harinam info then try for Brahman Initiation.');
         }
       }
       return redirect('/admin/initiation-create-step-two');
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.'. $e->getMessage());
      }
    }

    public function createStepTwo(Request $request)
    {
      try{

        $initiation = $request->session()->get('initiation');
        $initiativegurus = InitiativeGuru::where('status', 'Active')->get();
        $devoteerow = Devotees::find($initiation->devotee_id);
        $branchrow = Branch::find($initiation->branch);
        $initiationtype = $request['initiation_type'];
        $mentors = Mentor::where('status', 'Active')->get();
        $sheltered = Initiation::where('devotee_id', $initiation->devotee_id)->where('initiation_type', 'Shelter')->first();
        $harinaam = Initiation::where('devotee_id', $initiation->devotee_id)->where('initiation_type', 'Harinam Initiation')->first();
        $brahman = Initiation::where('devotee_id', $initiation->devotee_id)->where('initiation_type', 'Brahman Initiation')->first();
        activity('Initiation')->log('Create Step Two');
        return view('backend.initiation.finalform',compact('initiativegurus', 'mentors', 'initiation', 'devoteerow', 'sheltered', 'harinaam', 'brahman', 'branchrow'));
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again. '.$e->getMessage());
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
        $request->validate([
          'date' => 'required|date',
          'initiation_guru_id' => 'required',
          'files.*'=> 'mimes:pdf,jpg,jpeg,png',
        ]);

        $initiation = $request->session()->get('initiation');

        if (Initiation::where('devotee_id', $initiation->devotee_id)->where('initiation_type', $initiation->initiation_type)->exists()) {
          return redirect('/admin/initiation')->with('error', 'This devotee has already been initiated.');
        }

        if($initiation->initiation_type == 'Shelter'){
          $createrow = Initiation::create([
            'initiation_type' => $initiation->initiation_type,
            'initiation_date' => $request['date'],
            'devotee_id' => $initiation->devotee_id,
            'branch_id' => $initiation->branch_id,
            'initiation_guru_id' => $request['initiation_guru_id'],
            'witness' => $request['witness'],
            'remarks' => $request['remarks'],
            'discipleconfirm' => $request['discipleconfirm'],
            'createdby' => $user->id,
          ]);

          if ($request->file('files')){
            foreach($request->file('files') as $file)
            {
              $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
              $imagename = substr(str_shuffle($permitted_chars), 0, 10).'.'.$file->getClientOriginalExtension();
              $imagesize = $file->getSize();
              $identitypath = "initiationfiles/";
              Storage::disk('local')->put($identitypath.$imagename, file_get_contents($file));

              InitiationFiles::create([
                'initiation_id' => $createrow->id,
                'photo' => $imagename,
              ]);
            }
          }
          activity('Initiation')->log('Shelter created id ' . $createrow->id);
          return redirect('/initiation')->with('success', 'Initiated details added successfully');
        }elseif($initiation->initiation_type == 'Harinam Initiation'){
            $createrow = Initiation::create([
              'initiation_name' => $request['initiation_name'],
              'initiation_type' => $initiation->initiation_type,
              'initiation_date' => $request['date'],
              'devotee_id' => $initiation->devotee_id,
              'branch_id' => $initiation->branch_id,
              'initiation_guru_id' => $request['initiation_guru_id'],
              'witness' => $request['witness'],
              'remarks' => $request['remarks'],
              'createdby' => $user->id,
            ]);

            if ($request->file('files')){
              foreach($request->file('files') as $file)
              {
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                $imagename = substr(str_shuffle($permitted_chars), 0, 10).'.'.$file->getClientOriginalExtension();
                $imagesize = $file->getSize();
                $identitypath = "initiationfiles/";
                Storage::disk('local')->put($identitypath.$imagename, file_get_contents($file));

                InitiationFiles::create([
                  'initiation_id' => $createrow->id,
                  'photo' => $imagename,
                ]);
              }
            }
            activity('Initiation')->log('Harinam Initiation created id ' . $createrow->id);
            return redirect('/admin/initiation')->with('success', 'Initiation details added successfully');
        }elseif($initiation->initiation_type == 'Brahman Initiation'){

            $createrow = Initiation::create([
              'initiation_name' => $request['initiation_name'],
              'initiation_type' => $initiation->initiation_type,
              'initiation_date' => $request['date'],
              'devotee_id' => $initiation->devotee_id,
              'branch_id' => $initiation->branch_id,
              'initiation_guru_id' => $request['initiation_guru_id'],
              'witness' => $request['witness'],
              'remarks' => $request['remarks'],
              'createdby' => $user->id,
            ]);

            if ($request->file('files')){
              foreach($request->file('files') as $file)
              {
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                $imagename = substr(str_shuffle($permitted_chars), 0, 10).'.'.$file->getClientOriginalExtension();
                $imagesize = $file->getSize();
                $identitypath = "initiationfiles/";
                Storage::disk('local')->put($identitypath.$imagename, file_get_contents($file));

                InitiationFiles::create([
                  'initiation_id' => $createrow->id,
                  'photo' => $imagename,
                ]);
              }
            }
            activity('Initiation')->log('Brahman Initiation created id ' . $createrow->id);
            return redirect('/admin/initiation')->with('success', 'Initiated details added successfully');
        }else{}
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.', $e->getMessage());
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
        $initiativegurus = InitiativeGuru::all();
        $devotees = Devotees::all();
        $show = Initiation::find($id);
        $files = InitiationFiles::where('initiation_id', $id)->get();
        activity('Initiation')->log('View');
        return view('backend.initiation.view', compact('show', 'initiativegurus', 'devotees', 'files'));
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.');
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
        $edit = Initiation::find($id);
        $initiativegurus = InitiativeGuru::where('status', 'Active')->get();
        $devotees = Devotees::all();
        $branches = Branch::where('status', 'Active')->orderBy('title', 'asc')->get();
        $mentors = Mentor::all();
        activity('Initiation')->log('Edit');
        return view('backend.initiation.addedit',compact('edit', 'devotees', 'initiativegurus', 'mentors', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.');
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
        $request->validate([
          'initiation_type' => 'required|string',
          'date' => 'required|date',
          'initiation_guru_id' => 'required',
        ]);


        $user = Auth::guard('admin')->user();
        if(Initiation::where('devotee_id', $request['devotee'])->where('initiation_type', $request['initiation_type'])->where('id', '!=', $id)->exists()){
          return redirect()->back()->with('error', 'This devotee has already been initiated.');
        }else{
          Initiation::whereId($id)->update([
            'initiation_name' => $request['initiation_name'],
            'initiation_type' => $request['initiation_type'],
            'branch_id' => $request['branch'],
            'initiation_date' => $request['date'],
            'initiation_guru_id' => $request['initiation_guru_id'],
            'witness' => $request['witness'],
            'remarks' => $request['remarks'],
            'updatedby' => $user->id,
          ]);
          if ($request->file('files')){
              foreach($request->file('files') as $file)
              {
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                $imagename = substr(str_shuffle($permitted_chars), 0, 10).'.'.$file->getClientOriginalExtension();
                $imagesize = $file->getSize();
                $identitypath = "initiationfiles/";
                Storage::disk('local')->put($identitypath.$imagename, file_get_contents($file));

                InitiationFiles::create([
                  'initiation_id' => $id,
                  'photo' => $imagename,
                ]);
              }
          }
          activity('Initiation')->log('Data updated id ' . $id);
          return redirect()->back()->with('success', 'Successfully updated the Initiated Detail');
        }
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.');
      }
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = Initiation::findOrFail($id);
        $category->delete();
        activity('Initiation')->log('Moved to Trash');
        return redirect('/admin/initiation-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/initiation-trash')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = Initiation::withTrashed()->find($id);
        if ($item) {
            $item->restore();
        } else {
          return redirect('/admin/initiation')->with('error', 'Data is not in the trash folder.');
        }
        activity('Initiation')->log('Restore '.$item->title);
        return redirect('/admin/initiation')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
      try{
        $data = Initiation::withTrashed()->find($id);
        $filesexts = InitiationFiles::where('initiation_id', $id)->get();
        if($filesexts->count() != NULL){
          foreach($filesexts as $filesext){
            $datafile = InitiationFiles::findOrFail($filesext->id);

            if($datafile->photo != ''){
              Storage::disk('local')->delete('initiationfiles/'.$datafile->photo);
        		}
            $datafile->delete();
          }
        }
        activity('Initiation')->log('Data deleted id '.$id);
        $data->forceDelete();
        return redirect('/admin/initiation')->with('success', 'Data deleted successfully.');
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.');
      }
    }
}
