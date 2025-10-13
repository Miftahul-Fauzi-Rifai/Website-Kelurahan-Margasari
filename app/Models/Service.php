<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'requirements',
        'process',
        'icon',
        'contact_person',
        'phone',
        'processing_days',
        'fee',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'fee' => 'decimal:2'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });
    }
}
