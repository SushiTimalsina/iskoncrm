<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CourseBatchDevotee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'devotee_id',
        'batch_id',
        'branch_id',
        'attendmark',
        'createdby',
        'updatedby'
    ];

    public function getdevotee()
    {
      return $this->belongsTo('App\Models\Devotees', 'devotee_id', 'id');
    }

    public function getcoursebatch()
    {
      return $this->belongsTo('App\Models\CourseBatch', 'batch_id', 'id');
    }
}
