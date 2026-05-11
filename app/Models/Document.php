<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'permit_id', 'document_type_id', 'uploaded_by',
        'file_name', 'file_path', 'uploaded_at',
    ];

    protected $casts = ['uploaded_at' => 'datetime'];

    public function permit()
    {
        return $this->belongsTo(Permit::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
