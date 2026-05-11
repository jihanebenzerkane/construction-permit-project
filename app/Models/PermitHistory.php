<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermitHistory extends Model
{
    protected $fillable = [
        'permit_id', 'old_status_id', 'new_status_id',
        'changed_by', 'commentaire', 'changed_at',
    ];

    protected $casts = ['changed_at' => 'datetime'];

    public function permit()
    {
        return $this->belongsTo(Permit::class);
    }

    public function oldStatus()
    {
        return $this->belongsTo(Status::class, 'old_status_id');
    }

    public function newStatus()
    {
        return $this->belongsTo(Status::class, 'new_status_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
