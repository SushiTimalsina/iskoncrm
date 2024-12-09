<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
      'title',
      'parent_id',
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

  public function subcategory(){
      return $this->hasMany('App\Models\Branch', 'parent_id');
   }

   public function branch()
   {
     return $this->hasMany('App\Models\Branch', 'branch_id');
   }

   public function courses()
   {
     return $this->hasMany('App\Models\Courses', 'branch_id');
   }

   public function mentor()
   {
     return $this->hasMany('App\Models\Mentor', 'branch_id');
   }
/*
   public function User()
   {
     return $this->hasMany('App\Models\Admin', 'branch_id');
   }*/

   public function coursefacilitator()
   {
     return $this->hasMany('App\Models\CourseFacilitator', 'branch_id');
   }
}
