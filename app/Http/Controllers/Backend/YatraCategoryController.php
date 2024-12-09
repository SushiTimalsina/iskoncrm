<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Yatra;
use App\Models\YatraCategory;
use Illuminate\Support\Str;
use DB;
use Auth;

class YatraCategoryController extends Controller
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
        $lists = YatraCategory::orderBy('created_at', 'desc')->get();
        return view('backend.yatra-category.index',compact('lists'));
      } catch (\Exception $e) {
        return redirect('/admin/yatra-category')->with('error', 'An error occurred, please try again.');
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
        $slug = Str::slug($request['name'], '-');
        $createrow = YatraCategory::create([
          'title' => $request['name'],
          'slug' => $slug,
          'status' => $request['status'],
          'createdby' => $user->id
        ]);
        activity('Yatra Category')->log('Created id'.$createrow->id);
        return redirect('/admin/yatra-category')->with('success', 'Data created successfully');
      } catch (\Exception $e) {
        return redirect('/admin/yatra-category')->with('error', 'An error occurred, please try again.');
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
        $edit = YatraCategory::find($id);
        activity('Yatra Category')->log('Edit page viewed id'.$id);
        return view('backend.yatra-category.edit',compact('edit'));
      } catch (\Exception $e) {
        return redirect('/admin/yatra-category')->with('error', 'An error occurred, please try again.');
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
        $primary = YatraCategory::whereId($id)->update([
          'title' => $request['name'],
          'slug' => $slug,
          'status' => $request['status'],
          'updatedby' => $user->id
        ]);

        activity('Yatra Category')->log('Data updated id '.$id);
        return redirect('/admin/yatra-category')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/yatra-category')->with('error', 'An error occurred, please try again.');
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
          $data = YatraCategory::findOrFail($id);
          activity('Yatra Category')->log('Data deleted id '.$id);
          $data->delete();
          return redirect('/admin/yatra-category')->with('success', 'Data deleted successfully.');
        } catch (\Exception $e) {
        return redirect('/admin/yatra-category')->with('error', 'An error occurred, please try again.');
      }
    }
}
