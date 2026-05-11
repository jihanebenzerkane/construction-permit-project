<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    protected $fillable = [
        'permit_type_id', 'citizen_id', 'architect_id', 'status_id', 'district_id',
        'reference_number', 'project_title', 'project_address', 'surface', 'priority',
        'submitted_at', 'risk_score', 'risk_level', 'ai_priority', 'technical_review_required',
        'ai_recommendations',
    ];

    protected $casts = [
        'ai_recommendations' => 'array',
        'technical_review_required' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public function permitType()
    {
        return $this->belongsTo(PermitType::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function citizen()
    {
        return $this->belongsTo(User::class, 'citizen_id');
    }

    public function architect()
    {
        return $this->belongsTo(User::class, 'architect_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function histories()
    {
        return $this->hasMany(PermitHistory::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function technicalReviews()
    {
        return $this->hasMany(TechnicalReview::class);
    }

    public function archive()
    {
        return $this->hasOne(Archive::class);
    }
}
