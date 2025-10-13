<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'nama_pelapor',
        'email_pelapor',
        'telepon_pelapor',
        'alamat_pelapor',
        'judul_pengaduan',
        'deskripsi_pengaduan',
        'kategori',
        'prioritas',
        'foto_pendukung',
        'status',
        'tanggapan_admin',
        'tanggal_tanggapan',
        'admin_id'
    ];

    protected $casts = [
        'tanggal_tanggapan' => 'datetime',
    ];

    // Relationship to admin who responded
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Scopes for filtering
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('prioritas', $priority);
    }

    // Status badge colors
    public function getStatusBadgeColor()
    {
        return match($this->status) {
            'baru' => 'warning',
            'sedang_diproses' => 'info',
            'selesai' => 'success',
            'ditolak' => 'danger',
            default => 'secondary'
        };
    }

    // Priority badge colors
    public function getPriorityBadgeColor()
    {
        return match($this->prioritas) {
            'tinggi' => 'danger',
            'sedang' => 'warning',
            'rendah' => 'success',
            default => 'secondary'
        };
    }
}
