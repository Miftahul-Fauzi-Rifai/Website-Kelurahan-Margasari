<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rt;

class RtController extends Controller
{
    public function index(Request $request)
    {
        $query = Rt::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('rt_code', 'LIKE', "%{$search}%")
                  ->orWhere('rw_code', 'LIKE', "%{$search}%")
                  ->orWhere('ketua_rt_name', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }

        // Mobile responsive pagination - less items on mobile
        $perPage = $request->header('User-Agent') && 
                   (str_contains(strtolower($request->header('User-Agent')), 'mobile') ||
                    str_contains(strtolower($request->header('User-Agent')), 'android') ||
                    str_contains(strtolower($request->header('User-Agent')), 'iphone')) ? 8 : 12;

        $rts = $query->orderBy('rt_code')->paginate($perPage);
        
        // Data untuk peta: SEMUA RT untuk peta (tidak terbatas pencarian atau pagination)
        $allRts = Rt::all(); // Mengambil semua RT tanpa filter
        $mapPoints = $allRts->filter(fn ($rt) => $rt->latitude && $rt->longitude)
            ->map(function ($rt) {
                return [
                    'rt_code' => $rt->rt_code,
                    'rw_code' => $rt->rw_code,
                    'name' => $rt->name ?? ('RT ' . $rt->rt_code),
                    'ketua_rt_name' => $rt->ketua_rt_name,
                    'ketua_rt_phone' => $rt->ketua_rt_phone,
                    'num_population' => $rt->num_population,
                    'num_households' => $rt->num_households,
                    'lat' => (float) $rt->latitude,
                    'lng' => (float) $rt->longitude,
                ];
            })->values();

        return view('rt.index', [
            'rts' => $rts,
            'mapPoints' => $mapPoints,
            'search' => $request->get('search')
        ]);
    }

    public function show(string $rt_code)
    {
        $rt = Rt::where('rt_code', $rt_code)->firstOrFail();
        
        return view('rt.show', compact('rt'));
    }
}
