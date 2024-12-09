<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YatraCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'branch_id',
        'createdby',
        'updatedby',
        'status'
    ];
}
