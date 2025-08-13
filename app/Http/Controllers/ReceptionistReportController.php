<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReceptionistReportController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = $request->input('date_range', 
            Carbon::now()->subWeek()->format('Y-m-d').' - '.Carbon::now()->format('Y-m-d')
        );

        [$startDate, $endDate] = explode(' - ', $dateRange);

        $activities = Activity::receptionistActivities()
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])
            ->with(['user', 'subject'])
            ->latest()
            ->paginate(20);

        $stats = [
            'total_activities' => Activity::receptionistActivities()
                                ->whereBetween('created_at', [
                                    Carbon::parse($startDate)->startOfDay(),
                                    Carbon::parse($endDate)->endOfDay()
                                ])->count(),
            'check_ins' => Activity::where('description', 'check_in')
                              ->receptionistActivities()
                              ->whereBetween('created_at', [
                                  Carbon::parse($startDate)->startOfDay(),
                                  Carbon::parse($endDate)->endOfDay()
                              ])->count(),
            // Tambahkan statistik lainnya sesuai kebutuhan
        ];

        return view('admin.reports.receptionist', compact(
            'activities', 'stats', 'dateRange'
        ));
    }

    public function detail($receptionistId)
    {
        $receptionist = User::findOrFail($receptionistId);
        
        $activities = Activity::where('causer_id', $receptionistId)
            ->receptionistActivities()
            ->latest()
            ->paginate(20);

        return view('admin.reports.receptionist-detail', compact(
            'receptionist', 'activities'
        ));
    }
}