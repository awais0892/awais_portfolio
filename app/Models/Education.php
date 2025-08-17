<?php
// app/Models/Education.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'education';

    protected $fillable = [
        'degree', 'institution', 'location', 'start_date', 'end_date',
        'grade', 'description', 'achievements', 'type', 'order', 'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'achievements' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('start_date', 'desc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getDurationAttribute()
    {
        $start = $this->start_date->format('Y');
        $end = $this->end_date ? $this->end_date->format('Y') : 'Present';
        
        return $start . ' - ' . $end;
    }
}