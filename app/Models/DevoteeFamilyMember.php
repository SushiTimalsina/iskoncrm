<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevoteeFamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'devotees_id',
        'devotee_id',
        'createdby',
        'updatedby',
        'role'
    ];

    public function family()
    {
      return $this->belongsTo(Devotees::class);
    }
}
