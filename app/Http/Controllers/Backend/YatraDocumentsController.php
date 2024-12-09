<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Yatra;
use App\Models\YatraDocuments;
use Illuminate\Support\Str;
use DB;
use Storage;
use Auth;

class YatraDocumentsController extends Controller
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
        $identity = $request->file('file');
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

        if ($identity != '') {
          $identityname = substr(str_shuffle($permitted_chars), 0, 4) . '.' . $request->file('file')->getClientOriginalExtension();
          $identitypath = "yatra/";
          Storage::disk('local')->put($identitypath . $identityname, file_get_contents($request->file('file')));
        } else {
          $identityname = '';
        }


        $createrow = YatraDocuments::create([
          'devotee_id' => $request['devotee'],
          'yatra_id' => $request['yatra'],
          'yatra_seasons_id' => $request['seasons'],
          'type' => $request['type'],
          'file' => $identityname,
          'createdby' => $user->id
        ]);
        activity('Yatra Documents')->log('uploaded');
        return redirect()->back()->with('success', 'Data created successfully');
      } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        //
    }
}
