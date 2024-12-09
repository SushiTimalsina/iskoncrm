<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Devotees extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'firstname',
        'middlename',
        'surname',
        'gotra',
        'email', 'email_enc',
        'mobile', 'mobile_enc',
        'phone',
        'identitytype',
        'identityid', 'identityid_enc',
        'identityimage',
        'dob',
        'bloodgroup',
        'gender',
        'education',
        'occupations',
        'photo',
        'branch_id',
        'createdby',
        'updatedby',
        'status',
        'ptole',
        'pwardno',
        'pmuni',
        'pdistrict',
        'pprovince',
        'ttole',
        'twardno',
        'tmuni',
        'tdistrict',
        'tprovince',
        'mentor',
        'marital_status',
        'nationality', 'member', 'dobtype', 'countrycode'
    ];

    public function getcreatedby()
    {
      return $this->belongsTo('App\Models\Admin', 'createdby', 'id');
    }

    public function getupdatedby()
    {
      return $this->belongsTo('App\Models\Admin', 'updatedby', 'id');
    }

    public function devotee()
    {
      return $this->hasMany('App\Models\AttendSewa', 'devotee_id');
    }

    public function getbranch()
    {
      return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }

    public function getmentor()
    {
      return $this->belongsTo('App\Models\Mentor', 'mentor', 'id');
    }

    public function courses()
    {
      return $this->hasMany('App\Models\Courses', 'devotee_id', 'id');
    }

    public function getinitiationguru()
    {
      return $this->belongsTo('App\Models\InitiativeGuru', 'initiation_guru_id', 'id');
    }

    public function initiation()
    {
      return $this->hasMany('App\Models\Initiation', 'devotee_id', 'id');
    }

    public function getoccupation()
    {
      return $this->belongsTo('App\Models\Occupation', 'occupations', 'id');
    }

    public function members()
    {
        return $this->hasMany(DevoteeFamilyMember::class);
    }
}
