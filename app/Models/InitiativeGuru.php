<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class InitiativeGuru extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
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

    public function getdevotee()
    {
      return $this->belongsTo('App\Models\Devotees', 'name', 'id');
    }
}
