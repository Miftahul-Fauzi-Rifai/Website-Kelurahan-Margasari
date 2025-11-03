<?php

namespace App\Http\Controllers;

use App\Models\Tentang;
use App\Models\StrukturOrganisasi;
use App\Models\SosialMedia;

class TentangController extends Controller
{
    public function index()
    {
        $tentang = Tentang::first();
        $struktur = StrukturOrganisasi::orderBy('urutan')->get();
        $sosmed = SosialMedia::all();

        return view('about', compact('tentang', 'struktur', 'sosmed'));
    }
}
