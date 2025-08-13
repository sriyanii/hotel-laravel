<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'search'     => 'nullable|string',
            'per_page'   => 'nullable|integer',
            'date_range' => 'nullable|string'
        ]);

        $query = ActivityLog::with('user')->latest();

        // Filter pencarian
        if (!empty($validated['search'])) {
            $search = $validated['search'];
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter tanggal
        if (!empty($validated['date_range'])) {
            $dates = explode(' - ', $validated['date_range']);
            if (count($dates) === 2) {
                $startDate = date('Y-m-d', strtotime($dates[0]));
                $endDate   = date('Y-m-d', strtotime($dates[1]));
                $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            }
        }

        // Pagination
        $activities = $query->paginate($validated['per_page'] ?? 20);

        return view('admin.activities.index', compact('activities'));
    }

    public function show(ActivityLog $activity)
{
    return view('admin.activities.show', compact('activity'));
}

}
