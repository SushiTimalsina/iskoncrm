<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendCourse extends Model
{
    use HasFactory;

    protected $fillable = [
      'devotee_id',
      'branch_id',
      'course_id',
      'batch_id',
      'date',
      'time',
      'type',
      'status',
      'createdby',
      'updatedby'
    ];

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
