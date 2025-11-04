<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Rt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar ketua RT
    public function index()
    {
        $users = User::with(['role', 'rt_relation'])
            ->whereHas('role', function($q) {
                $q->where('name', 'ketua_rt');
            })
            ->latest()
            ->paginate(15);
            
        return view('admin.users.index', compact('users'));
    }

    // Form tambah ketua RT
    public function create()
    {
        $rts = Rt::orderBy('rt_code')->get();
        return view('admin.users.create', compact('rts'));
    }

    // Simpan ketua RT baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'rt_code' => 'required|exists:rts,rt_code',
        ]);

        // Get RT data
        $rt = Rt::where('rt_code', $request->rt_code)->first();
        
        // Get ketua_rt role
        $ketuaRtRole = Role::where('name', 'ketua_rt')->first();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'rt' => $rt->rt_code,
            'role_id' => $ketuaRtRole->id,
            'is_active' => true
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun Ketua RT berhasil ditambahkan');
    }

    // Form edit ketua RT
    public function edit(User $user)
    {
        $rts = Rt::orderBy('rt_code')->get();
        return view('admin.users.edit', compact('user', 'rts'));
    }

    // Update ketua RT
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'rt_code' => 'required|exists:rts,rt_code',
        ]);

        // Get RT data
        $rt = Rt::where('rt_code', $request->rt_code)->first();
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'rt' => $rt->rt_code,
            'is_active' => $request->input('is_active', 0) == 1,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun Ketua RT berhasil diperbarui');
    }

    // Hapus ketua RT
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun Ketua RT berhasil dihapus');
    }

    // Toggle status aktif
    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.users.index')
            ->with('success', "Akun berhasil {$status}");
    }
}
