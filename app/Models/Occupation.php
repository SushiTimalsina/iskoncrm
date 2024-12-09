<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
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
       return $this->hasMany('App\Models\Occupation', 'parent_id');
   }

   public function getdevotee()
   {
     return $this->hasMany('App\Models\Devotees', 'occupations');
   }
}
