<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rt;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Rt::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('rt_code', 'LIKE', "%{$search}%")
                  ->orWhere('ketua_rt_name', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }

        $rts = $query->orderBy('rt_code')->paginate(15);
        
        return view('admin.rts.index', compact('rts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rt_code' => 'required|string|max:10|unique:rts,rt_code',
            'name' => 'nullable|string|max:255',
            'ketua_rt_name' => 'required|string|max:255',
            'ketua_rt_phone' => 'required|string|max:20',
            'num_households' => 'required|integer|min:0',
            'num_population' => 'required|integer|min:0',
            'num_male' => 'required|integer|min:0',
            'num_female' => 'required|integer|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // Auto-generate name if not provided
        if (empty($validated['name'])) {
            $validated['name'] = 'RT ' . $validated['rt_code'];
        }

        Rt::create($validated);

        return redirect()->route('admin.rts.index')
            ->with('success', 'Data RT berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rt $rt)
    {
        return view('admin.rts.show', compact('rt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rt $rt)
    {
        return view('admin.rts.edit', compact('rt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rt $rt)
    {
        $validated = $request->validate([
            'rt_code' => ['required', 'string', 'max:10', Rule::unique('rts')->ignore($rt->id)],
            'name' => 'nullable|string|max:255',
            'ketua_rt_name' => 'required|string|max:255',
            'ketua_rt_phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'num_households' => 'required|integer|min:0',
            'num_population' => 'required|integer|min:0',
            'num_male' => 'required|integer|min:0',
            'num_female' => 'required|integer|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // Auto-generate name if not provided
        if (empty($validated['name'])) {
            $validated['name'] = 'RT ' . $validated['rt_code'];
        }

        $rt->update($validated);

        return redirect()->route('admin.rts.index')
            ->with('success', 'Data RT berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rt $rt)
    {
        // Check if RT has related users (Ketua RT)
        if ($rt->users()->exists()) {
            return back()->with('error', 'RT tidak dapat dihapus karena masih memiliki Ketua RT yang terdaftar!');
        }

        $rt->delete();

        return redirect()->route('admin.rts.index')
            ->with('success', 'Data RT berhasil dihapus!');
    }

    /**
     * Show form to edit detailed RT data
     */
    public function editDetail(Rt $rt)
    {
        return view('admin.rts.detail', compact('rt'));
    }

    /**
     * Update detailed RT data
     */
    public function updateDetail(Request $request, Rt $rt)
    {
        $validated = $request->validate([
            'ketua_rt_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cropped_image' => 'nullable|string',
            'ketua_rt_age' => 'nullable|integer|min:17|max:100',
            'ketua_rt_profession' => 'nullable|string|max:255',
            'ketua_rt_tenure_years' => 'nullable|integer|min:0|max:50',
            
            // Mata Pencaharian
            'pedagang' => 'nullable|numeric|min:0|max:100',
            'karyawan' => 'nullable|numeric|min:0|max:100',
            'buruh' => 'nullable|numeric|min:0|max:100',
            'mata_pencaharian_lainnya' => 'nullable|numeric|min:0|max:100',
            
            // Bantuan Sosial
            'pkh' => 'nullable|integer|min:0',
            'blt' => 'nullable|integer|min:0',
            'bantuan_lainnya' => 'nullable|integer|min:0',
            
            // Kegiatan Rutin
            'pengajian' => 'nullable|string|in:kurang_dari_3,lebih_dari_3',
            'posyandu' => 'nullable|string|in:kurang_dari_3,lebih_dari_3',
            'kerja_bakti' => 'nullable|string|in:kurang_dari_3,lebih_dari_3',
            'kegiatan_lainnya' => 'nullable|string|in:kurang_dari_3,lebih_dari_3',
            
            // Fasilitas Umum
            'masjid' => 'nullable|integer|min:0',
            'musholla' => 'nullable|integer|min:0',
            'posyandu_count' => 'nullable|integer|min:0',
            'bank_sampah' => 'nullable|integer|min:0',
            'pos_ronda' => 'nullable|integer|min:0',
            'fasum_lainnya' => 'nullable|string',
            
            // Kondisi Infrastruktur
            'kondisi_jalan' => 'nullable|string|in:baik,sedang,buruk',
            'kondisi_saluran_air' => 'nullable|string|in:baik,sedang,buruk',
            'kondisi_penerangan' => 'nullable|string|in:baik,sedang,buruk',
            
            // Masalah Lingkungan
            'masalah_banjir' => 'nullable|boolean',
            'masalah_sampah' => 'nullable|boolean',
            
            // Tingkat Pendidikan
            'lulusan_sd' => 'nullable|numeric|min:0|max:100',
            'lulusan_smp' => 'nullable|numeric|min:0|max:100',
            'lulusan_sma' => 'nullable|numeric|min:0|max:100',
            'lulusan_kuliah' => 'nullable|numeric|min:0|max:100',
        ]);

        // Handle upload foto
        if ($request->filled('cropped_image')) {
            // Hapus foto lama jika ada
            if ($rt->ketua_rt_photo && \Storage::disk('public')->exists($rt->ketua_rt_photo)) {
                \Storage::disk('public')->delete($rt->ketua_rt_photo);
            }

            // Simpan foto baru dari cropped image (base64)
            $image = $request->cropped_image;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'ketua_rt/' . $rt->rt_code . '_' . time() . '.jpg';
            
            \Storage::disk('public')->put($imageName, base64_decode($image));
            $rt->ketua_rt_photo = $imageName;
        }

        // Update profil ketua RT
        $rt->ketua_rt_age = $request->ketua_rt_age;
        $rt->ketua_rt_profession = $request->ketua_rt_profession;
        $rt->ketua_rt_tenure_years = $request->ketua_rt_tenure_years;

        // Update mata pencaharian
        $rt->mata_pencaharian = [
            'pedagang' => $request->pedagang ?? 0,
            'karyawan' => $request->karyawan ?? 0,
            'buruh' => $request->buruh ?? 0,
            'lainnya' => $request->mata_pencaharian_lainnya ?? 0,
        ];

        // Update bantuan sosial
        $rt->bantuan_sosial = [
            'pkh' => $request->pkh ?? 0,
            'blt' => $request->blt ?? 0,
            'lainnya' => $request->bantuan_lainnya ?? 0,
        ];

        // Update kegiatan rutin
        $rt->kegiatan_rutin = [
            'pengajian' => $request->pengajian ?? '',
            'posyandu' => $request->posyandu ?? '',
            'kerja_bakti' => $request->kerja_bakti ?? '',
            'lainnya' => $request->kegiatan_lainnya ?? '',
        ];

        // Update fasilitas umum
        $rt->fasilitas_umum = [
            'masjid' => $request->masjid ?? 0,
            'musholla' => $request->musholla ?? 0,
            'posyandu' => $request->posyandu_count ?? 0,
            'bank_sampah' => $request->bank_sampah ?? 0,
            'pos_ronda' => $request->pos_ronda ?? 0,
            'lainnya' => $request->fasum_lainnya,
        ];

        // Update kondisi infrastruktur
        $rt->kondisi_infrastruktur = [
            'jalan' => $request->kondisi_jalan,
            'saluran_air' => $request->kondisi_saluran_air,
            'penerangan' => $request->kondisi_penerangan,
        ];

        // Update masalah lingkungan
        $rt->masalah_lingkungan = [
            'banjir' => $request->has('masalah_banjir'),
            'sampah' => $request->has('masalah_sampah'),
        ];

        // Update tingkat pendidikan
        $rt->tingkat_pendidikan = [
            'sd' => $request->lulusan_sd ?? 0,
            'smp' => $request->lulusan_smp ?? 0,
            'sma' => $request->lulusan_sma ?? 0,
            'kuliah' => $request->lulusan_kuliah ?? 0,
        ];

        $rt->save();

        return redirect()->route('admin.rts.index')
            ->with('success', 'Data detail RT berhasil diperbarui!');
    }
}

