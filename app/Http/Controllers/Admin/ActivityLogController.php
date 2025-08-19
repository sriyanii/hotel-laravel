<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Validasi
        $request->validate([
            'search' => 'nullable|string',
            'role' => 'nullable|in:admin,resepsionis',
            'type' => 'nullable|in:login,logout,create,update,delete',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $query = ActivityLog::with('user')->latest();

        // Filter pencarian
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('description', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($q) => 
                      $q->where('name', 'like', "%{$request->search}%")
                  );
            });
        }

        // Filter role
        if ($request->role) {
            $query->where('role', $request->role);
        }

        // Filter tipe aktivitas
        if ($request->type) {
            $query->where('activity_type', $request->type);
        }

        // Filter tanggal
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $activities = $query
    ->paginate(5)
    ->onEachSide(1) 
    ->appends($request->query());


        return view('admin.activities.index', [
            'activities' => $activities,
            'roles' => ['admin' => 'Admin', 'resepsionis' => 'Resepsionis'],
            'types' => [
                'login' => 'Login',
                'logout' => 'Logout',
                'create' => 'Buat Data',
                'update' => 'Update Data',
                'delete' => 'Hapus Data'
            ]
        ]);
    }

    public function show(ActivityLog $activity)
    {
        return view('admin.activities.show', compact('activity'));
    }
}