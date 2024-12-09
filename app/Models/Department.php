<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'branch_id',
        'parent_id',
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
       return $this->hasMany('App\Models\Department', 'parent_id');
     }

   public function department()
   {
     return $this->hasMany('App\Models\department', 'department_id');
   }

   public function attendsewa()
   {
     return $this->hasMany('App\Models\AttendSewa', 'department_id');
   }
}
