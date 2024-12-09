<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DevoteeSkills;
use Illuminate\Support\Str;
use App\Models\Devotees;
use App\Models\Skills;
use Auth;

class DevoteeSkillsController extends Controller
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

        if($request['skills']){
          $jsonString = $request['skills'];
          foreach ($jsonString as $item) {
              $jsonString = $item;
              if (is_string($jsonString)) {
                  $array = json_decode($jsonString, true);
                  if (json_last_error() === JSON_ERROR_NONE) {
                      $myArray = array();
                      foreach ($array as $item) {
                        $myArray[] = ucfirst($item['value']);
                          if(Skills::where('title', $item['value'])->doesntExist()){
                          $skillrow = Skills::create([
                              'title' => $item['value'],
                              'createdby' => $user->id,
                              'status' => 'Active'
                          ]);
                        }
                      }
                      if($myArray){
                        foreach($myArray as $myarrayitem){
                          $getskillsrow = Skills::where('title', $myarrayitem)->first();
                          if(DevoteeSkills::where('devotee_id', $request['devotee'])->where('skill_id', $getskillsrow->id)->doesntExist()){
                            DevoteeSkills::create([
                              'devotee_id' => $request['devotee'],
                              'skill_id' => $getskillsrow->id,
                              'createdby' => $user->id
                            ]);
                          }
                        }
                      }
                  } else { echo "Error decoding JSON: " . json_last_error_msg(); }
              } else { echo "The provided input is not a JSON string."; }
          }
        }

        $getdevotee = Devotees::find($request['devotee']);
        activity('Devotee')->log('Skills Created for: '.$getdevotee->firstname.' '.$getdevotee->middlename.' '.$getdevotee->surname);
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
      try{
          $data = DevoteeSkills::findOrFail($id);
          activity('Devotee Skill')->log('Data deleted id '.$id);
          $data->delete();
          return redirect()->back()->with('success', 'Data deleted successfully.');
        } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred, please try again.');
      }
    }
}
