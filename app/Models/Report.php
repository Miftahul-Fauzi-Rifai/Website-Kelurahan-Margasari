<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'rt_code',
        'month',
        'title',
        'description',
        'activities',
        'total_residents',
        'total_households',
        'issues',
        'suggestions',
        'attachment',
        'status',
        'admin_notes',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    // Relationship dengan User (Ketua RT)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan RT
    public function rt()
    {
        return $this->belongsTo(Rt::class, 'rt_code', 'rt_code');
    }

    // Scope untuk filter berdasarkan bulan
    public function scopeForMonth($query, $month)
    {
        return $query->where('month', $month);
    }

    // Scope untuk filter berdasarkan RT
    public function scopeForRt($query, $rtCode)
    {
        return $query->where('rt_code', $rtCode);
    }

    // Scope untuk status
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Helper untuk format bulan
    public function getFormattedMonthAttribute()
    {
        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        [$year, $month] = explode('-', $this->month);
        return $months[$month] . ' ' . $year;
    }

    // Helper untuk status badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => '<span class="badge bg-secondary">Draft</span>',
            'submitted' => '<span class="badge bg-primary">Terkirim</span>',
            'reviewed' => '<span class="badge bg-info">Direview</span>',
            'approved' => '<span class="badge bg-success">Disetujui</span>',
            'rejected' => '<span class="badge bg-danger">Ditolak</span>',
        ];
        
        return $badges[$this->status] ?? '';
    }
}
