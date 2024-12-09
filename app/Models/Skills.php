<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skills extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'title',
      'parent_id',
      'createdby',
      'updatedby',
      'status'
    ];

    public function subcategory(){
       return $this->hasMany('App\Models\Skills', 'parent_id');
   }

   public function getdevotee()
   {
     return $this->hasMany('App\Models\DevoteeSkills', 'devotee_id');
   }

   public function getcreatedby()
   {
     return $this->belongsTo('App\Models\Admin', 'createdby', 'id');
   }

   public function getupdatedby()
   {
     return $this->belongsTo('App\Models\Admin', 'updatedby', 'id');
   }
}
