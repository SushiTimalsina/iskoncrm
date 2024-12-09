<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YatraDocuments extends Model
{
    use HasFactory;

    protected $fillable = [
        'devotee_id',
        'yatra_id',
        'yatra_seasons_id',
        'type',
        'file',
        'createdby',
        'updatedby'
    ];
}
