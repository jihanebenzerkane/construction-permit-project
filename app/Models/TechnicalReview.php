<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalReview extends Model
{
    protected $fillable = [
        'permit_id', 'reviewed_by', 'conformite', 'remarque', 'reviewed_at',
    ];

    protected $casts = [
        'conformite' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function permit()
    {
        return $this->belongsTo(Permit::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
