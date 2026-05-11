<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['nom', 'couleur'];

    public function permits()
    {
        return $this->hasMany(Permit::class);
    }
}
