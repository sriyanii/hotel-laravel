<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = ActivityLog::with(['user' => function($query) {
                        $query->select('id', 'name');
                     }])
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);
                     
        return view('admin.activities.index', compact('activities'));
    }
}