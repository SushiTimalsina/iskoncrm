<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Initiation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'devotee_id',
        'initiation_guru_id',
        'initiation_name',
        'initiation_type',
        'initiation_date',
        'branch_id',
        'witness',
        'remarks',
        'discipleconfirm',
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

    public function getinitiationguru()
    {
        return $this->belongsTo('App\Models\InitiativeGuru', 'initiation_guru_id', 'id');
    }
}
