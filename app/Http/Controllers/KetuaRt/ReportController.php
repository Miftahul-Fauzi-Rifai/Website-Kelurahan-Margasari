<?php

namespace App\Http\Controllers\KetuaRt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    // Dashboard Ketua RT
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistik laporan
        $stats = [
            'total_reports' => Report::where('user_id', $user->id)->count(),
            'draft_reports' => Report::where('user_id', $user->id)->where('status', 'draft')->count(),
            'submitted_reports' => Report::where('user_id', $user->id)->where('status', 'submitted')->count(),
            'approved_reports' => Report::where('user_id', $user->id)->where('status', 'approved')->count(),
        ];

        // Laporan terbaru
        $recent_reports = Report::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Cek apakah bulan ini sudah ada laporan
        $current_month = now()->format('Y-m');
        $this_month_report = Report::where('user_id', $user->id)
            ->where('month', $current_month)
            ->first();

        return view('ketua-rt.dashboard', compact('stats', 'recent_reports', 'this_month_report'));
    }

    // Daftar laporan
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('ketua-rt.reports.index', compact('reports'));
    }

    // Form tambah laporan
    public function create()
    {
        $user = Auth::user();
        $current_month = now()->format('Y-m');
        
        // Cek apakah bulan ini sudah ada laporan
        $existing = Report::where('user_id', $user->id)
            ->where('month', $current_month)
            ->first();

        if ($existing) {
            return redirect()->route('ketua-rt.reports.edit', $existing)
                ->with('info', 'Laporan bulan ini sudah ada, silakan edit');
        }

        return view('ketua-rt.reports.create');
    }

    // Simpan laporan
    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'activities' => 'nullable|string',
            'total_residents' => 'nullable|integer|min:0',
            'total_households' => 'nullable|integer|min:0',
            'issues' => 'nullable|string',
            'suggestions' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
        ]);

        $user = Auth::user();

        // Cek duplikat
        $existing = Report::where('user_id', $user->id)
            ->where('month', $request->month)
            ->first();

        if ($existing) {
            return back()->withErrors(['month' => 'Laporan untuk bulan ini sudah ada'])->withInput();
        }

        $data = $request->except('attachment');
        $data['user_id'] = $user->id;
        $data['rt_code'] = $user->rt;
        $data['status'] = 'draft';

        // Upload attachment
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('reports', 'public');
            $data['attachment'] = $path;
        }

        $report = Report::create($data);

        return redirect()->route('ketua-rt.reports.index')
            ->with('success', 'Laporan berhasil disimpan sebagai draft');
    }

    // Lihat detail laporan
    public function show(Report $report)
    {
        // Pastikan hanya bisa lihat laporan sendiri
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        return view('ketua-rt.reports.show', compact('report'));
    }

    // Form edit laporan
    public function edit(Report $report)
    {
        // Pastikan hanya bisa edit laporan sendiri
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        // Tidak bisa edit jika sudah direview
        if (in_array($report->status, ['approved', 'rejected'])) {
            return redirect()->route('ketua-rt.reports.show', $report)
                ->with('error', 'Laporan yang sudah direview tidak dapat diedit');
        }

        return view('ketua-rt.reports.edit', compact('report'));
    }

    // Update laporan
    public function update(Request $request, Report $report)
    {
        // Pastikan hanya bisa update laporan sendiri
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        // Tidak bisa update jika sudah direview
        if (in_array($report->status, ['approved', 'rejected'])) {
            return back()->with('error', 'Laporan yang sudah direview tidak dapat diedit');
        }

        $request->validate([
            'month' => 'required|date_format:Y-m',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'activities' => 'nullable|string',
            'total_residents' => 'nullable|integer|min:0',
            'total_households' => 'nullable|integer|min:0',
            'issues' => 'nullable|string',
            'suggestions' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->except('attachment');

        // Upload attachment baru
        if ($request->hasFile('attachment')) {
            // Hapus file lama
            if ($report->attachment) {
                Storage::disk('public')->delete($report->attachment);
            }
            
            $path = $request->file('attachment')->store('reports', 'public');
            $data['attachment'] = $path;
        }

        $report->update($data);

        return redirect()->route('ketua-rt.reports.index')
            ->with('success', 'Laporan berhasil diperbarui');
    }

    // Kirim laporan (submit)
    public function submit(Report $report)
    {
        // Pastikan hanya bisa submit laporan sendiri
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        if ($report->status !== 'draft') {
            return back()->with('error', 'Hanya laporan draft yang bisa dikirim');
        }

        $report->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->route('ketua-rt.reports.index')
            ->with('success', 'Laporan berhasil dikirim ke admin');
    }

    // Hapus laporan
    public function destroy(Report $report)
    {
        // Pastikan hanya bisa hapus laporan sendiri
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        // Tidak bisa hapus jika sudah disubmit
        if ($report->status !== 'draft') {
            return back()->with('error', 'Hanya laporan draft yang bisa dihapus');
        }

        // Hapus attachment
        if ($report->attachment) {
            Storage::disk('public')->delete($report->attachment);
        }

        $report->delete();

        return redirect()->route('ketua-rt.reports.index')
            ->with('success', 'Laporan berhasil dihapus');
    }
}
