<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
      'devotee_id',
      'branch_id',
      'status',
      'createdby',
      'updatedby'
  ];

  public function getcreatedby()
  {
    return $this->belongsTo('App\Models\Admin', 'createdby', 'id');
  }

  public function getupdatedby()
  {
    return $this->belongsTo('App\Models\Admin', 'updatedby', 'id');
  }

  public function mentor()
  {
    return $this->hasMany('App\Models\mentor', 'id');
  }

   public function getbranch()
   {
     return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
   }

   public function getdevotee()
   {
     return $this->belongsTo('App\Models\Devotees', 'devotee_id', 'id');
   }
}
