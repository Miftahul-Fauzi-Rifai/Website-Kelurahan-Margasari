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
            $validated['name'] = 'RT ' . str_pad($validated['rt_code'], 3, '0', STR_PAD_LEFT);
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
            'num_households' => 'required|integer|min:0',
            'num_population' => 'required|integer|min:0',
            'num_male' => 'required|integer|min:0',
            'num_female' => 'required|integer|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // Auto-generate name if not provided
        if (empty($validated['name'])) {
            $validated['name'] = 'RT ' . str_pad($validated['rt_code'], 3, '0', STR_PAD_LEFT);
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
}

