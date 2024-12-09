<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yatra extends Model
{
    use HasFactory;

    protected $fillable = [
        'devotee_id',
        'branch_id',
        'contact',
        'childadult_id',
        'yatra_id',
        'yatra_seasons_id',
        'othertravel',
        'tnc',
        'createdby',
        'updatedby',
        'status'
    ];

    public function getdevotee()
    {
      return $this->belongsTo('App\Models\Devotees', 'devotee_id', 'id');
    }

    public function getbranch()
    {
      return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }

    public function getoccupation()
    {
      return $this->belongsTo('App\Models\Occupation', 'occupations', 'id');
    }

    public function getyatra()
    {
      return $this->belongsTo('App\Models\YatraCategory', 'yatra_id', 'id');
    }

    public function getyatraseason()
    {
      return $this->belongsTo('App\Models\YatraSeason', 'yatra_seasons_id', 'id');
    }
}
