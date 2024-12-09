<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\PasswordReset;
use Mail;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'devotee_id',
        'status',
        'is_online',
        'last_activity',
        'createdby',
        'updatedby',
        'branch_id',
        'loginip'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getbranch()
    {
      return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }

    public function sendPasswordResetNotification($token)
    {
      $this->notify(new PasswordReset($token));
    }

    public static function sendWelcomeEmail($user)
    {
      // Generate a new reset password token
      $token = app('auth.password.broker')->createToken($user);

      $url = url('password/reset', $token).'?email='.$user;

      // Send email
      Mail::send('emails.userwelcomemail', ['user' => $user, 'token' => $token, 'url' => $url], function ($m) use ($user) {
        $m->from('test@test.com', 'Your App Name');

        $m->to($user->email, $user->name)->subject('Welcome to APP');
      });
    }
}
