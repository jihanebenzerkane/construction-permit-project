<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'cin', 'role_id', 'district_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function permitsAsCitizen()
    {
        return $this->hasMany(Permit::class, 'citizen_id');
    }

    public function permitsAsArchitect()
    {
        return $this->hasMany(Permit::class, 'architect_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    public function technicalReviews()
    {
        return $this->hasMany(TechnicalReview::class, 'reviewed_by');
    }

    public function archives()
    {
        return $this->hasMany(Archive::class, 'archived_by');
    }

    public function apiTokens()
    {
        return $this->hasMany(UserApiToken::class);
    }

    public function isCitoyen(): bool
    {
        return $this->role?->nom === 'citoyen';
    }

    public function isArchitecte(): bool
    {
        return $this->role?->nom === 'architecte';
    }

    public function isAgent(): bool
    {
        return $this->role?->nom === 'agent_urbanisme';
    }

    public function isTechnical(): bool
    {
        return $this->role?->nom === 'service_technique';
    }

    public function isAdmin(): bool
    {
        return $this->role?->nom === 'administrateur';
    }
}
