<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use App\Models\ActivityLog;

class UserActivityController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Middleware bisa dipanggil tanpa parent::__construct()
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = UserActivity::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $activity = UserActivity::with('user')->findOrFail($id);
        return view('admin.activities.show', compact('activity'));
    }
}