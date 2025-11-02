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
        'ketua_rt_photo',
        'address',
        'ketua_rt_age',
        'ketua_rt_profession',
        'ketua_rt_tenure_years',
        'num_households',
        'num_population',
        'num_male',
        'num_female',
        'latitude',
        'longitude',
        'boundaries',
        'mata_pencaharian',
        'bantuan_sosial',
        'kegiatan_rutin',
        'fasilitas_umum',
        'kondisi_infrastruktur',
        'masalah_lingkungan',
        'tingkat_pendidikan',
    ];

    protected $casts = [
        'boundaries' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'mata_pencaharian' => 'array',
        'bantuan_sosial' => 'array',
        'kegiatan_rutin' => 'array',
        'fasilitas_umum' => 'array',
        'kondisi_infrastruktur' => 'array',
        'masalah_lingkungan' => 'array',
        'tingkat_pendidikan' => 'array',
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
