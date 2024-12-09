<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CourseBatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'facilitators_id',
        'course_id',
        'branch_id',
        'certificate',
        'fullmarks',
        'examtype',
        'fee',
        'unit',
        'unitdays',
        'start_date',
        'end_date',
        'type',
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

    public function getcourse()
    {
      return $this->belongsTo('App\Models\Courses', 'course_id', 'id');
    }

    public function getfacilitator()
    {
      return $this->belongsTo('App\Models\CourseFacilitator', 'facilitators_id', 'id');
    }

    public function getbranch()
    {
      return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }
}
