<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuestTakeCare extends Model
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

   public function getbranch()
   {
     return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
   }

   public function getdevotee()
   {
     return $this->belongsTo('App\Models\Devotees', 'devotee_id', 'id');
   }
}
