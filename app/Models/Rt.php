<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    protected $fillable = [
        'rt_code',
        'name',
        'ketua_rt_name',
        'ketua_rt_phone',
        'num_households',
        'num_population',
        'num_male',
        'num_female',
        'latitude',
        'longitude',
        'boundaries',
    ];

    protected $casts = [
        'boundaries' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function getDisplayNameAttribute(): string
    {
        return 'RT ' . $this->rt_code;
    }

    /**
     * Get the users (Ketua RT) associated with this RT.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'rt', 'rt_code');
    }
}
