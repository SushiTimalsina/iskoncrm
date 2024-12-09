<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'branch_id',
        'parent_id',
        'image',
        'createdby',
        'updatedby',
        'status'
    ];

    public function getbranch()
    {
      return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }

    public function getcreatedby()
    {
      return $this->belongsTo('App\Models\Admin', 'createdby', 'id');
    }

    public function getupdatedby()
    {
      return $this->belongsTo('App\Models\Admin', 'updatedby', 'id');
    }

    public function subcategory(){
       return $this->hasMany('App\Models\Courses', 'parent_id');
   }

   public function courses()
   {
     return $this->hasMany('App\Models\Courses', 'course_id');
   }
}
