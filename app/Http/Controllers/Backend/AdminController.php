<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use App\Models\Devotees;
use App\Mail\UserWelcomeEmail;
use App\Models\Branch;
use App\Notifications\UserResetPasswordEmail;
use Illuminate\Support\Facades\Crypt;
use Hash;
use Mail;
use Notification;
use Auth;
use DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      try{
        $user = Auth::guard('admin')->user();
        $users = Admin::orderBy('id','DESC')->get();
        $roles = Role::pluck('name','name')->all();
        $branches = Branch::orderBy('title','ASC')->get();
        $listusers = Admin::orderBy('name','ASC')->get();
        $devotees = Devotees::all();
        activity('Admin')->log('Viewed lists');
        return view('backend.admins.index',compact('users', 'roles', 'devotees', 'user', 'branches', 'listusers'));
      } catch (\Exception $e) {
        return redirect('/admin/admins')->with('error', 'An error occurred, please try again.');
      }
    }

    public function encryptdata()
    {
      $getadmins = Admin::all();
      foreach($getadmins as $getadmin){

        Admin::whereId($getadmin->id)->update([
          'name' => Crypt::encrypt($getadmin->name)
        ]);
      }
      return redirect('/admin/admins/')->with('success', 'Data enc successfully');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchfilter(Request $request)
    {
      try{
        $devotees = Devotees::all();
        $listusers = Admin::orderBy('name','ASC')->get();
        $branches = Branch::where('status', 'Active')->orderBy('title','ASC')->get();
        activity('Devotee')->log('Viewed lists');

        if($request['search'] == 'true'){
          if($request['user']){
            $users = Admin::where('id', $request['user'])->get();
          }else{
            $query = Admin::orderBy('created_at', 'desc');
            if($request['branch']){
              $query->where('branch_id', '=', $request['branch']);
            }

            if($request['status']){
              $query->where('status', '=', $request['status']);
            }
            $users = $query->get();
          }
        }
        return view('backend.admins.index',compact('branches', 'devotees', 'users','listusers'));
      } catch (\Exception $e) {
        return redirect('/admin/admins')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $roles = Role::pluck('name','name')->all();
        $devotees = Devotees::orderBy('firstname','ASC')->get();
        activity('User')->log('Create page visited.');
        $branches = Branch::where('status', 'Active')->orderBy('title','ASC')->get();
        return view('backend.admins.add',compact('roles', 'devotees', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/admins')->with('error', 'An error occurred, please try again.');
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
        $this->validate($request, [
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'admin' => 'required',
            'branch' => 'required'
        ]);

        $user = Auth::guard('admin')->user();
        $request['password'] = Hash::make($request['password']);
        $token = app('auth.password.broker')->createToken($user);

        $devoteeid = $request['devotee'];
        $devotee = Devotees::find($devoteeid);
        if(!empty($devotee->email_enc)){
          $checkuser = Admin::where('devotee_id', '=', $devoteeid)->first();
          if($checkuser === null){
            if($devotee->firstname != NULL){ $firstname = Crypt::decrypt($devotee->firstname); }else{ $firstname = NULL; }
            if($devotee->middlename != NULL){ $middlename = Crypt::decrypt($devotee->middlename); }else{ $middlename = NULL; }
            if($devotee->surname != NULL){ $surname = Crypt::decrypt($devotee->surname); }else{ $surname = NULL; }

            $name = $firstname.' '.$middlename.' '.$surname;

          //add new user to database
          $user = new Admin;
          $user->name = Crypt::encrypt($name);
          $user->email = Crypt::decrypt($devotee->email_enc);
          $user->password = $request['password'];
          $user->devotee_id = $devoteeid;
          $user->status = $request['status'];
          $user->createdby = $user->id;
          $user->branch_id = $request['branch'];
          $user->is_admin = $request['admin'];
          $user->save();

          //User::sendWelcomeEmail($user);


            $user->assignRole($request->input('roles'));
            activity('Admin')->log('Data created id '.$user->id);

            $details = [
                    'email' => $devotee->email
                ];

                //$usercheck = new User;

            //Notification::send($devotee->email, new UserResetPasswordEmail($details));
             //User::sendWelcomeEmail($usercheck);


            return redirect('/admin/admins')->with('success','Admin created successfully');
          }else{
            return redirect('/admin/admins')->with('error','Admin already created.');
          }

        }else{
          return redirect('/admin/admins')->with('error','Email required to create admin. Please update devotee email first and try again.');
        }
      } catch (\Exception $e) {
        return redirect('/admin/admins')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $user = Admin::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $devotees = Devotees::all();
        $branches = Branch::all();
        activity('Admin')->log('Admin visit id '.$id);
        return view('backend.admins.view',compact('user','roles','userRole', 'devotees', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/admins')->with('error', 'An error occurred, please try again.');
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
        $user = Admin::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $devotees = Devotees::orderBy('firstname','ASC')->get();
        $branches = Branch::orderBy('title','ASC')->get();
        activity('Admin')->log('User visit id '.$id);
        return view('backend.admins.edit',compact('user','roles','userRole', 'devotees', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/admins')->with('error', 'An error occurred, please try again.');
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
         $this->validate($request, [
           'roles' => 'required'
         ]);

         $input = $request->all();
         $user = Admin::find($id);
         $user->update($input);
         DB::table('model_has_roles')->where('model_id', $id)->delete();
         $user->assignRole($request->input('roles'));

         return redirect('/admin/admins')->with('success', 'User updated successfully');
       } catch (\Exception $e) {
         return redirect('/admin/admins')->with('error', 'An error occurred, please try again.'.$e->getMessage());
       }
     }

     public function updatePassword(Request $request, $id)
     {
       try{
         $this->validate($request, [
           'password' => 'required|same:confirm-password',
         ]);

         $user = Admin::find($id);

         if ($request->has('password')) {
           $user->password = Hash::make($request->password);
         }

         $user->save();
         return redirect('/admin/admins')->with('success', 'Password updated successfully');
       } catch (\Exception $e) {
         return redirect('/admin/admins')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $user = Auth::guard('admin')->user();
        if($user->id != $id){
          if($user->hasRole('Admin')){
            return redirect()->route('backend.admins.index')->with('error','Admin can not be deleted.');
          }else{
            activity('Admin')->log('Data deleted id '.$id);
            Admin::find($id)->delete();
            return redirect()->route('backend.admins.index')->with('success','User deleted successfully');
          }
        }else{
          return redirect()->route('backend.admins.index')->with('eoor',"Current user can't be deleted.");
        }
      } catch (\Exception $e) {
          return redirect('/admin/admins')->with('error', 'An error occurred, please try again.');
        }
    }
}
