<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrukturOrganisasi;

class StrukturController extends Controller
{
    public function index()
    {
        $struktur = StrukturOrganisasi::orderBy('urutan')->get();
        return view('admin.struktur.index', compact('struktur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
        ]);

        StrukturOrganisasi::create($request->all());
        return redirect()->route('admin.struktur.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        StrukturOrganisasi::findOrFail($id)->delete();
        return redirect()->route('admin.struktur.index')->with('success', 'Data berhasil dihapus!');
    }
}
