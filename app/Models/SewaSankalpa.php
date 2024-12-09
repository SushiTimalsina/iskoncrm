<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SewaSankalpa extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'guesttakecare_id'
    'devotee_id',
    'sewa_id',
    'branch_id', 'amount', 'start_date', 'end_date', 'duration',
    'status',
    'createdby',
    'updatedby'
  ];
}
