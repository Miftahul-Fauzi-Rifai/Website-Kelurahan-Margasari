<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{

    public function index(Request $request)
    {
        $query = Complaint::with('admin')->latest();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Filter by priority
        if ($request->has('prioritas') && $request->prioritas != '') {
            $query->where('prioritas', $request->prioritas);
        }

        // Search by nama pelapor or judul
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_pelapor', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('judul_pengaduan', 'LIKE', '%' . $request->search . '%');
            });
        }

        $complaints = $query->paginate(10);

        $categories = [
            'infrastruktur' => 'Infrastruktur',
            'kebersihan' => 'Kebersihan Lingkungan', 
            'keamanan' => 'Keamanan dan Ketertiban',
            'pelayanan' => 'Pelayanan Administrasi',
            'kesehatan' => 'Kesehatan Masyarakat',
            'ekonomi' => 'Ekonomi dan Perdagangan',
            'pendidikan' => 'Pendidikan',
            'sosial' => 'Sosial Kemasyarakatan',
            'lainnya' => 'Lainnya'
        ];

        $stats = [
            'total' => Complaint::count(),
            'baru' => Complaint::where('status', 'baru')->count(),
            'proses' => Complaint::where('status', 'sedang_diproses')->count(),
            'selesai' => Complaint::where('status', 'selesai')->count(),
        ];

        return view('admin.complaints.index', compact('complaints', 'categories', 'stats'));
    }

    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:baru,sedang_diproses,selesai,ditolak',
            'tanggapan_admin' => 'nullable|string|max:1000'
        ]);

        $complaint->update([
            'status' => $request->status,
            'tanggapan_admin' => $request->tanggapan_admin,
            'tanggal_tanggapan' => now(),
            'admin_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diupdate!');
    }

    public function destroy(Complaint $complaint)
    {
        // Delete photo if exists
        if ($complaint->foto_pendukung) {
            Storage::disk('public')->delete($complaint->foto_pendukung);
        }

        $complaint->delete();

        return redirect()->route('admin.complaints.index')->with('success', 'Pengaduan berhasil dihapus!');
    }

    public function export()
    {
        // Simple CSV export
        $complaints = Complaint::with('admin')->get();
        
        $filename = 'pengaduan_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($complaints) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'ID', 'Nama Pelapor', 'Email', 'Telepon', 'Alamat', 
                'Judul Pengaduan', 'Kategori', 'Prioritas', 'Status', 
                'Tanggal Dibuat', 'Tanggapan Admin', 'Admin'
            ]);

            // Data
            foreach ($complaints as $complaint) {
                fputcsv($file, [
                    $complaint->id,
                    $complaint->nama_pelapor,
                    $complaint->email_pelapor,
                    $complaint->telepon_pelapor,
                    $complaint->alamat_pelapor,
                    $complaint->judul_pengaduan,
                    $complaint->kategori,
                    $complaint->prioritas,
                    $complaint->status,
                    $complaint->created_at->format('Y-m-d H:i'),
                    $complaint->tanggapan_admin,
                    $complaint->admin ? $complaint->admin->name : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}