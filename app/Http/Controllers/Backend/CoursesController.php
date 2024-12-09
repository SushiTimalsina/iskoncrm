<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Courses;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:course-list|course-create|course-edit|course-delete', ['only' => ['index','show']]);
         $this->middleware('permission:course-create', ['only' => ['create','store']]);
         $this->middleware('permission:course-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:course-delete', ['only' => ['destroy', 'download', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        activity('Courses')->log('Viewed lists');
        $lists = Courses::orderBy('created_at', 'desc')->where('parent_id',NULL)->paginate(50);
        $parentlists = Courses::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();
        return view('backend.courses.index',compact('lists', 'parentlists', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/courses')->with('error', 'An error occurred, please try again.');
      }
    }

    public function trash()
    {
      try{
        activity('Courses')->log('Viewed lists');
        $lists = Courses::orderBy('created_at', 'desc')->onlyTrashed()->paginate(50);
        $parentlists = Courses::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();
        return view('backend.courses.index',compact('lists', 'parentlists', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/courses')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $validatedData = $request->validate([
           'icon' => 'mimes:jpg,png,jpeg'
       ]);
        $user = Auth::guard('admin')->user();
        $icon = $request->file('icon');
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        if($icon != ''){
          $identityname = substr(str_shuffle($permitted_chars), 0, 4).'.'.$request->icon->getClientOriginalExtension();
          $identitypath = "course/";
          Storage::disk('local')->put($identitypath.$identityname, file_get_contents($request->icon));

          $getimage = storage_path("app/course/".$identityname);
          $img = Image::read(file_get_contents($request->icon));
          $img->resize(500, 500, function ($constraint) {
            $constraint->aspectRatio();
          });
          $img->save(storage_path("app/course/".$identityname));
        }else{
          $identityname = '';
        }

        $createrow = Courses::create([
          'title' => $request['name'],
          'parent_id' => $request['parent'],
          'branch_id' => $request['branch'],
          'image' => $identityname,
          'status' => $request['status'],
          'createdby' => $user->id
        ]);
        activity('Courses')->log('Created Course id '. $createrow->title);
        return redirect('/admin/courses')->with('success', 'Data created successfully');
      } catch (\Exception $e) {
        return redirect('/admin/courses')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $edit = Courses::find($id);
        $childlists = Courses::where('parent_id', '=', $id)->pluck('id');
        if($childlists->count() != NULL){
          $child = [$childlists, $id];
        }else{ $child = $id;}
        $lists = Courses::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();
        activity('Courses')->log('Edit page visited id '.$id);
        return view('backend.courses.edit',compact('edit', 'lists', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/courses')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $validatedData = $request->validate([
           'icon' => 'mimes:jpg,png,jpeg|max:2024'
       ]);
        $user = Auth::guard('admin')->user();
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $identity = $request->file('icon');

        if ($request['removeid'] == 1) {
          $row = Courses::findOrFail($id);
          if ($row->image != '') {
            Storage::disk('local')->delete('course/' . $row->image);
          }
          $identityname = '';
        } else {
          if ($request->hasFile('icon')) {
            $datas = Courses::findOrFail($id);
            if ($datas->image != '') {
              Storage::disk('local')->delete('course/' . $datas->image);
            }

            $identityname = substr(str_shuffle($permitted_chars), 0, 4).'.'.$request->file('icon')->getClientOriginalExtension();
            $photopath = "course/";
            Storage::disk('local')->put($photopath . $identityname, file_get_contents($request->file('icon')));
          } else {
            $identityname = $request['image_old'];
          }
        }


        $primary = Courses::whereId($id)->update([
          'title' => $request['name'],
          'parent_id' => $request['parent'],
          'branch_id' => $request['branch'],
          'status' => $request['status'],
          'image' => $identityname,
          'updatedby' => $user->id
        ]);

        $sub = Courses::where('parent_id', $id)->update([
          'status' => $request['status'],
        ]);

        activity('Courses')->log('Data updated: '.$request['name']);
        return redirect('/admin/courses')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/courses')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    public function movetotrash(Request $request, string $id)
    {
      try{
        $category = Courses::findOrFail($id);
        $category->delete();
        activity('Courses')->log('Moved to Trash '.$category->title);
        return redirect('/admin/course-trash')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/course-trash')->with('error', 'An error occurred, please try again.');
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, string $id)
    {
      try{
        $item = Courses::withTrashed()->find($id);
        if ($item) {
            $item->restore();
        } else {
          return redirect('/admin/courses')->with('error', 'Data is not in the trash folder.');
        }
        activity('Courses')->log('Restore '.$item->title);
        return redirect('/admin/courses')->with('success', 'Data updated successfully');
      } catch (\Exception $e) {
        return redirect('/admin/courses')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      try{
        $item = Courses::withTrashed()->find($id);
        $getdata = Courses::where('parent_id', $id)->get();
        if($getdata->count() != NULL){
          activity('Courses')->log('Trying deleting data '.$item->title);
          return redirect('/admin/courses')->with('error', 'Please remove sub data before delete parent data.');
        }else{
          activity('Courses')->log('Data deleted: '.$item->title);
          $imageName = 'course/'.$item->image;
          if (Storage::disk('local')->exists('course/'.$item->image)) {
            Storage::disk('local')->delete($imageName);
          }
          $item->forceDelete();
          return redirect('/admin/courses')->with('success', 'Data deleted successfully.');
        }
      } catch (\Exception $e) {
        return redirect('/admin/courses')->with('error', 'An error occurred, please try again.'.$e->getMessage());
      }
    }
}
