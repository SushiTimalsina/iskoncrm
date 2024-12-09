<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevoteeSkills extends Model
{
    use HasFactory;

    protected $fillable = [
      'devotee_id',
      'skill_id',
      'createdby',
      'updatedby'
    ];

    public function getskill()
    {
      return $this->belongsTo('App\Models\Skills', 'skill_id', 'id');
    }
}
