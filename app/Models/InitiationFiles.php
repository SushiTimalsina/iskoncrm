<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitiationFiles extends Model
{
    use HasFactory;

    protected $fillable = [
        'initiation_id',
        'photo',
        'createdby',
        'updatedby'
    ];
}
