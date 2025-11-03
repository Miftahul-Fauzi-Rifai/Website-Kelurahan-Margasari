<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tentang;
use App\Models\StrukturOrganisasi;
use App\Models\SosialMedia;

class TentangController extends Controller
{
    // Tampilkan form edit + daftar struktur + sosmed
    public function edit()
    {
        $tentang  = Tentang::first();
        $struktur = StrukturOrganisasi::orderBy('urutan')->get();
        $sosmed   = SosialMedia::all();

        return view('admin.tentang.edit', compact('tentang', 'struktur', 'sosmed'));
    }

    // Update deskripsi, gambar kantor, dan logo kelurahan
    public function update(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $tentang = Tentang::first() ?? new Tentang();
        $tentang->deskripsi = $request->deskripsi;

        // === Upload gambar kantor ===
        if ($request->hasFile('gambar')) {
            if (!empty($tentang->gambar_kantor) && file_exists(public_path($tentang->gambar_kantor))) {
                @unlink(public_path($tentang->gambar_kantor));
            }

            $file = $request->file('gambar');
            $namaFile = 'kantor_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/tentang'), $namaFile);
            $tentang->gambar_kantor = 'uploads/tentang/' . $namaFile;
        }

        // === Upload logo kelurahan ===
        if ($request->hasFile('logo')) {
            if (!empty($tentang->logo) && file_exists(public_path($tentang->logo))) {
                @unlink(public_path($tentang->logo));
            }

            $logo = $request->file('logo');
            $namaLogo = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/tentang'), $namaLogo);
            $tentang->logo = 'uploads/tentang/' . $namaLogo;
        }

        $tentang->save();

        return redirect()->route('admin.tentang.edit')->with('success', 'Informasi Tentang berhasil diperbarui!');
    }

    // === STRUKTUR ORGANISASI ===
    public function storeStruktur(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'nama'    => 'required|string|max:255',
            'urutan'  => 'nullable|integer',
        ]);

        StrukturOrganisasi::create([
            'jabatan' => $request->jabatan,
            'nama'    => $request->nama,
            'urutan'  => $request->urutan ?? 0,
        ]);

        return redirect()->route('admin.tentang.edit')->with('success', 'Struktur organisasi ditambahkan!');
    }

    public function destroyStruktur($id)
    {
        StrukturOrganisasi::findOrFail($id)->delete();
        return redirect()->route('admin.tentang.edit')->with('success', 'Data struktur dihapus!');
    }

    public function updateStruktur(Request $request, $id)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'nama'    => 'required|string|max:255',
        ]);

        $struktur = StrukturOrganisasi::findOrFail($id);
        $struktur->update([
            'jabatan' => $request->jabatan,
            'nama'    => $request->nama,
        ]);

        return response()->json(['success' => true, 'message' => 'Struktur organisasi diperbarui.']);
    }

    // === SOSIAL MEDIA ===
    public function storeSosial(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:255',
            'url'      => 'required|url|max:255',
        ]);

        SosialMedia::create([
            'platform' => $request->platform,
            'url'      => $request->url,
        ]);

        return redirect()->route('admin.tentang.edit')->with('success', 'Sosial media berhasil ditambahkan!');
    }

    public function destroySosial($id)
    {
        SosialMedia::findOrFail($id)->delete();
        return redirect()->route('admin.tentang.edit')->with('success', 'Sosial media dihapus!');
    }

    public function updateSosial(Request $request, $id)
    {
        $request->validate([
            'platform' => 'required|string|max:255',
            'url'      => 'required|url|max:255',
        ]);

        $sosmed = SosialMedia::findOrFail($id);
        $sosmed->update([
            'platform' => $request->platform,
            'url'      => $request->url,
        ]);

        return response()->json(['success' => true, 'message' => 'Sosial media diperbarui.']);
    }
}
