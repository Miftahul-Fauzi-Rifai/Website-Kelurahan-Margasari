<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportReviewController extends Controller
{
    // Daftar semua laporan
    public function index(Request $request)
    {
        $query = Report::with(['user', 'rt'])->latest();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan RT
        if ($request->filled('rt_code')) {
            $query->where('rt_code', $request->rt_code);
        }

        // Filter berdasarkan bulan
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        $reports = $query->paginate(15);

        // Statistik
        $stats = [
            'total' => Report::count(),
            'submitted' => Report::where('status', 'submitted')->count(),
            'reviewed' => Report::where('status', 'reviewed')->count(),
            'approved' => Report::where('status', 'approved')->count(),
            'rejected' => Report::where('status', 'rejected')->count(),
        ];

        return view('admin.reports.index', compact('reports', 'stats'));
    }

    // Lihat detail laporan
    public function show(Report $report)
    {
        $report->load(['user', 'rt']);
        return view('admin.reports.show', compact('report'));
    }

    // Update status laporan
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:reviewed,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $report->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
        ]);

        $statusText = [
            'reviewed' => 'direview',
            'approved' => 'disetujui',
            'rejected' => 'ditolak',
        ];

        return back()->with('success', "Laporan berhasil {$statusText[$request->status]}");
    }

    // Hapus laporan (admin only)
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil dihapus');
    }

    // Export laporan (untuk fitur masa depan)
    public function export(Request $request)
    {
        // TODO: Implement export to Excel/PDF
        return back()->with('info', 'Fitur export akan segera tersedia');
    }
}
