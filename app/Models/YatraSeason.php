<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YatraSeason extends Model
{
    use HasFactory;

    protected $fillable = [
        'yatra_id',
        'branch_id',
        'name',
        'price',
        'route',
        'pricedetails',
        'createdby',
        'updatedby',
        'status'
    ];

    public function getyatra()
    {
      return $this->belongsTo('App\Models\YatraCategory', 'yatra_id', 'id');
    }
}
