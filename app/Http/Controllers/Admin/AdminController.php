<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Complaint;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            // Services disabled - no longer using services database
            'total_services' => 0,
            'active_services' => 0,
            'total_complaints' => Complaint::count(),
            'new_complaints' => Complaint::where('status', 'baru')->count(),
            'processing_complaints' => Complaint::where('status', 'sedang_diproses')->count(),
            'completed_complaints' => Complaint::where('status', 'selesai')->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_posts' => Post::with('user')->latest()->take(5)->get(),
            'recent_complaints' => Complaint::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
