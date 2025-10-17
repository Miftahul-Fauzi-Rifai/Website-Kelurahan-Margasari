<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // Public methods - no authentication required
    
    public function index()
    {
        return view('complaint.index');
    }

    public function create()
    {
        $categories = [
            'infrastruktur' => 'Infrastruktur (Jalan, Drainase, dll)',
            'kebersihan' => 'Kebersihan Lingkungan', 
            'keamanan' => 'Keamanan dan Ketertiban',
            'pelayanan' => 'Pelayanan Administrasi',
            'kesehatan' => 'Kesehatan Masyarakat',
            'ekonomi' => 'Ekonomi dan Perdagangan',
            'pendidikan' => 'Pendidikan',
            'sosial' => 'Sosial Kemasyarakatan',
            'lainnya' => 'Lainnya'
        ];

        return view('complaint.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'email_pelapor' => 'nullable|email|max:255',
            'telepon_pelapor' => 'required|string|max:20',
            'alamat_pelapor' => 'required|string|max:500',
            'judul_pengaduan' => 'required|string|max:255',
            'deskripsi_pengaduan' => 'required|string',
            'kategori' => 'required|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'foto_pendukung' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nama_pelapor.required' => 'Nama pelapor wajib diisi',
            'telepon_pelapor.required' => 'Nomor telepon wajib diisi',
            'alamat_pelapor.required' => 'Alamat wajib diisi',
            'judul_pengaduan.required' => 'Judul pengaduan wajib diisi',
            'deskripsi_pengaduan.required' => 'Deskripsi pengaduan wajib diisi',
            'kategori.required' => 'Kategori wajib dipilih',
            'prioritas.required' => 'Prioritas wajib dipilih',
            'foto_pendukung.image' => 'File harus berupa gambar',
            'foto_pendukung.max' => 'Ukuran file maksimal 2MB'
        ]);

        $data = $request->all();
        
        // Handle file upload
        if ($request->hasFile('foto_pendukung')) {
            $image = $request->file('foto_pendukung');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('complaints', $imageName, 'public');
            $data['foto_pendukung'] = $imagePath;
        }

        Complaint::create($data);

        return redirect()->route('complaint.success')->with('success', 'Pengaduan berhasil dikirim. Terima kasih atas partisipasi Anda!');
    }

    public function success()
    {
        return view('complaint.success');
    }

}