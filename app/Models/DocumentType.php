<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = ['nom', 'obligatoire'];

    protected $casts = ['obligatoire' => 'boolean'];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
