<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'has_voted', 'is_active'];

    protected $casts = [
        'has_voted' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function votesGiven()
    {
        return $this->hasMany(Vote::class, 'voter_id');
    }

    public function votesReceived()
    {
        return $this->hasMany(Vote::class, 'nominee_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
