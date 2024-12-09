<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CourseFacilitator extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'devotee_id',
      'course_id',
      'branch_id',
      'createdby',
      'updatedby',
      'status'
    ];

    protected $casts = [ 'course_id' => 'array' ];


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

    public function getcourse()
    {
      return $this->belongsTo('App\Models\Courses', 'course_id', 'id');
    }

    public function getbranch()
    {
      return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }
}
