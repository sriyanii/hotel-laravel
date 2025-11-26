<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RatePlan;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class RatePlanController extends Controller
{
    public function index()
    {
        $ratePlans = RatePlan::latest()->paginate(10);
        $tipeKamarList = TipeKamar::pluck('tipe_kamar')->toArray();
        
        // Calculate stats for the quick stats cards
        $stats = $this->calculateStats();
        
        return view('admin.rate-plans.index', compact('ratePlans', 'tipeKamarList', 'stats'));
    }

    public function create()
    {
        $tipeKamarList = $this->getRoomTypeOptions();
        return view('admin.rate-plans.create', compact('tipeKamarList'));
    }

    public function store(Request $request)
    {
        $validRoomTypes = TipeKamar::pluck('tipe_kamar')->toArray();
        $validOptions = array_merge(['all'], $validRoomTypes);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:seasonal,event,promotion',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'room_types' => 'required|array|min:1',
            'room_types.*' => ['required', Rule::in($validOptions)],
            'rate_adjustment_sign' => 'required|in:+,-',
            'rate_adjustment_value' => 'required|numeric|min:0',
            'rate_adjustment_type' => 'required|in:percentage,fixed',
            'min_stay' => 'nullable|integer|min:1',
            'release_days' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'nullable',
        ]);

        $roomTypes = $request->room_types;
        if (in_array('all', $roomTypes)) {
            $roomTypes = ['all'];
        }

        RatePlan::create([
            'name' => $request->name,
            'type' => $request->type,
            'room_types' => $roomTypes,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'rate_adjustment_sign' => $request->rate_adjustment_sign,
            'rate_adjustment_value' => $request->rate_adjustment_value,
            'rate_adjustment_type' => $request->rate_adjustment_type,
            'min_stay' => $request->min_stay,
            'release_days' => $request->release_days,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.rate-plans.index')
            ->with('success', 'Rate plan created successfully!');
    }

    public function edit(RatePlan $ratePlan)
    {
        $tipeKamarList = TipeKamar::pluck('tipe_kamar');
        // Tidak perlu explode karena room_types sudah di-cast sebagai array
        return view('admin.rate-plans.edit', compact('ratePlan', 'tipeKamarList'));
    }

    public function update(Request $request, RatePlan $ratePlan)
    {
        $validRoomTypes = TipeKamar::pluck('tipe_kamar')->toArray();
        $validOptions = array_merge(['all'], $validRoomTypes);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:seasonal,event,promotion',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'room_types' => 'required|array|min:1',
            'room_types.*' => ['required', Rule::in($validOptions)],
            'rate_adjustment_sign' => 'required|in:+,-',
            'rate_adjustment_value' => 'required|numeric|min:0',
            'rate_adjustment_type' => 'required|in:percentage,fixed',
            'min_stay' => 'nullable|integer|min:1',
            'release_days' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ], [
            'room_types.required' => 'Please select at least one room type.',
            'room_types.*.in' => 'One or more selected room types are invalid.',
        ]);

        $roomTypes = $request->room_types;
        if (in_array('all', $roomTypes)) {
            $roomTypes = ['all'];
        }

        $ratePlan->update([
            'name' => $request->name,
            'type' => $request->type,
            'room_types' => $roomTypes,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'rate_adjustment_sign' => $request->rate_adjustment_sign,
            'rate_adjustment_value' => $request->rate_adjustment_value,
            'rate_adjustment_type' => $request->rate_adjustment_type,
            'min_stay' => $request->min_stay,
            'release_days' => $request->release_days,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.rate-plans.index')
            ->with('success', 'Rate plan updated successfully!');
    }

    public function destroy(RatePlan $ratePlan)
    {
        $ratePlan->delete();
        return redirect()->route('admin.rate-plans.index')
            ->with('success', 'Rate plan deleted successfully!');
    }

    private function getRoomTypeOptions()
    {
        return TipeKamar::pluck('tipe_kamar')->toArray();
    }

    /**
     * Calculate statistics for the quick stats cards
     */
    private function calculateStats()
    {
        $today = Carbon::today();
        
        // Active plans (is_active = true and within date range)
        $activePlans = RatePlan::where('is_active', true)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->count();

        // Upcoming plans (start_date in future)
        $upcomingPlans = RatePlan::where('start_date', '>', $today)
            ->count();

        // Seasonal plans
        $seasonalPlans = RatePlan::where('type', 'seasonal')
            ->count();

        // Calculate average revenue increase (this is a placeholder - you might want to calculate based on actual data)
        // For demo purposes, we'll calculate based on active percentage-based rate adjustments
        $activePercentagePlans = RatePlan::where('is_active', true)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('rate_adjustment_type', 'percentage')
            ->where('rate_adjustment_sign', '+')
            ->avg('rate_adjustment_value');

        $revenueIncrease = $activePercentagePlans ? round($activePercentagePlans, 1) : 12.0;

        return [
            'active_plans' => $activePlans,
            'upcoming_plans' => $upcomingPlans,
            'seasonal_plans' => $seasonalPlans,
            'revenue_increase' => $revenueIncrease,
        ];
    }
}