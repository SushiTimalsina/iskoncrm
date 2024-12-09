<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\InitiationFiles;
use Storage;
use Auth;

class InitiationFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
          'files.*'=> 'mimes:pdf,jpg,jpeg,png',
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
                'initiation_id' => $request['initiationid'],
                'photo' => $imagename,
                'createdby' => $user->id,
              ]);
            }
        }

        activity('Initiation')->log('files uploaded for '.$request['initiationid']);
        return redirect()->back()->with('success', 'Successfully added an Initiated Detail');
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        //
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
        //
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
        $data = InitiationFiles::findOrFail($id);
        activity('Initiation')->log('File deleted');

        if($data->photo != ''){
          Storage::disk('local')->delete('initiationfiles/'.$data->photo);
    		}

        $data->delete();
        return redirect()->back()->with('success', 'File deleted successfully.');
      } catch (\Exception $e) {
        return redirect('/admin/initiation')->with('error', 'An error occurred, please try again.');
      }
    }
}
