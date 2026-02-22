<?php
// app/Models/Experience.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'achievements',
        'technologies',
        'order',
        'is_active',
        'company_logo'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_active' => 'boolean',
        'achievements' => 'array',
        'technologies' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('start_date', 'desc');
    }

    public function getDurationAttribute()
    {
        $start = $this->start_date;
        $end = $this->is_current ? now() : $this->end_date;

        return $start->format('M Y') . ' - ' . ($this->is_current ? 'Present' : $end->format('M Y'));
    }

    public function getFormattedStartDateAttribute()
    {
        return $this->start_date->format('M Y');
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->is_current ? 'Present' : ($this->end_date ? $this->end_date->format('M Y') : '');
    }
}