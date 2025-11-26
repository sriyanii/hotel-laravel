<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons,code',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        Coupon::create([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'max_uses' => $request->max_uses,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'), // ✅ INI YANG DIPERBAIKI
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon created successfully!'
        ]);
    }
}