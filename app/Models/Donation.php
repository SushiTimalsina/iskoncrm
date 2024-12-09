<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'devotee_id',
        'department_id',
        'branch_id',
        'sewa_id',
        'yatra_seasons_id',
        'course_batch_id',
        'title',
        'donation',
        'donationtype',
        'voucher',
        'createdby',
        'updatedby',
        'status'
    ];

    public function getcreatedby()
    {
      return $this->belongsTo('App\Models\Admin', 'createdby', 'id');
    }

    public function getupdatedby()
    {
      return $this->belongsTo('App\Models\Admin', 'updatedby', 'id');
    }

    public function getdevotee()
    {
      return $this->belongsTo('App\Models\Devotees', 'devotee_id', 'id');
    }

    public function getsewa()
    {
      return $this->belongsTo('App\Models\Sewa', 'sewa_id', 'id');
    }

    public function getdepartment()
    {
      return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }

    public function getbranch()
    {
      return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }
}
