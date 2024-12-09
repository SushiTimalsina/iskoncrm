<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use App\Models\Devotees;
use App\Mail\UserWelcomeEmail;
use App\Models\Branch;
use App\Notifications\UserResetPasswordEmail;
use Illuminate\Support\Facades\Crypt;
use DB;
use Hash;
use Mail;
use Notification;
use Auth;

class UserController extends Controller
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
        $users = User::orderBy('id','DESC')->paginate(50);
        $roles = Role::pluck('name','name')->all();
        $branches = Branch::all();
        $listusers = User::all();
        $devotees = Devotees::all();
        activity('User')->log('Viewed lists');
        return view('backend.users.index',compact('users', 'roles', 'devotees', 'user', 'branches', 'listusers'));
      } catch (\Exception $e) {
        return redirect('/admin/users')->with('error', 'An error occurred, please try again.');
      }
    }

    public function encryptdata()
    {
      $getadmins = User::all();
      foreach($getadmins as $getadmin){

        User::whereId($getadmin->id)->update([
          'name' => Crypt::encrypt($getadmin->name)
        ]);
      }
      return redirect('/admin/users/')->with('success', 'Data enc successfully');
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
        $listusers = User::all();
        $branches = Branch::where('status', 'Active')->get();
        activity('Devotee')->log('Viewed lists');

        if($request['search'] == 'true'){
          if($request['user']){
            $users = User::where('id', $request['user'])->paginate(50);
          }else{
            $query = User::orderBy('created_at', 'desc');
            if($request['branch']){
              $query->where('branch_id', '=', $request['branch']);
            }

            if($request['status']){
              $query->where('status', '=', $request['status']);
            }
            $users = $query->paginate(50);
          }
        }
        return view('backend.users.index',compact('branches', 'devotees', 'users','listusers'));
      } catch (\Exception $e) {
        return redirect('/admin/users')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        activity('User')->log('Create page visited.');
        $branches = Branch::where('status', 'Active')->get();
        return view('backend.users.add',compact('devotees', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/users')->with('error', 'An error occurred, please try again.');
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
            'password' => 'required',
        ]);

        $user = Auth::guard('admin')->user();
        $request['password'] = Hash::make($request['password']);

        $token = app('auth.password.broker')->createToken($user);
        $devotee = Devotees::find($request['devotee']);
        if(!empty($devotee->email)){
          $checkuser = User::where('devotee_id', '=', $request['devotee'])->first();
          if($checkuser === null){
            $name = $devotee->firstname.' '.$devotee->middlename.' '.$devotee->surname;
          $user = new User;
          $user->name = $name;
          $user->email = $devotee->email;
          $user->password = $request['password'];
          $user->devotee_id = $request['devotee'];
          $user->status = $request['status'];
          $user->createdby = $user->id;
          $user->branch_id = $devotee->branch_id;
          $user->save();

          //User::sendWelcomeEmail($user);

            activity('User')->log('Data created id '.$user->id);

            $details = [
                    'email' => $devotee->email
                ];

                //$usercheck = new User;

            //Notification::send($devotee->email, new UserResetPasswordEmail($details));
             //User::sendWelcomeEmail($usercheck);


            return redirect('/admin/users')->with('success','User created successfully');
          }else{
            return redirect('/admin/users')->with('error','User already created.'.$e->getMessage());
          }

        }else{
          return redirect('/admin/users')->with('error','Email required to create user. Please update devotee email first and try again.');
        }
      } catch (\Exception $e) {
        return redirect('/admin/users')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $devotees = Devotees::all();
        $branches = Branch::all();
        activity('User')->log('User visit id '.$id);
        return view('backend.users.view',compact('user','roles','userRole', 'devotees', 'branches'));
      } catch (\Exception $e) {
        return redirect('/admin/users')->with('error', 'An error occurred, please try again.');
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

     public function updatePassword(Request $request, $id)
     {
       try{
         $this->validate($request, [
           'password' => 'required|same:confirm-password',
         ]);

         $user = User::find($id);

         if ($request->has('password')) {
           $user->password = Hash::make($request->password);
         }

         $user->save();
         return redirect('/admin/users')->with('success', 'Password updated successfully');
       } catch (\Exception $e) {
         return redirect('/admin/users')->with('error', 'An error occurred, please try again.'.$e->getMessage());
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
        activity('User')->log('Data deleted');
        User::find($id)->delete();
        return redirect()->route('backend.users.index')->with('success','User deleted successfully');
      } catch (\Exception $e) {
          return redirect('/admin/users')->with('error', 'An error occurred, please try again.'.$e->getMessage());
        }
    }
}
