<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        // Check if a coupon is already applied
        if (session()->has('coupon')) {
            return response()->json(['error' => 'A coupon is already applied. Please remove it first.']);
        }

        // Find the coupon by code
        $coupon = Coupon::where('code', $request->code)->first();

        // Validate the coupon
        if (!$coupon) {
            return response()->json(['error' => 'Invalid coupon code']);
        }

        // Check if the coupon is valid (not expired and active)
        if (!$coupon->isValid()) {
            return response()->json(['error' => 'Coupon expired or inactive']);
        }

        // Check if the user has already used this coupon
        $user = auth()->user();

        // Check if the user has already used this coupon
        if ($coupon->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'You already used this coupon']);
        }

        DB::beginTransaction();

        try {
            $coupon->users()->attach($user->id);
            $coupon->increment('used_count');

            session([
                'coupon' => [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'discount' => $coupon->discount
                ],
                'coupon.code' => $coupon->code,
                'coupon.discount' => $coupon->discount
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Coupon applied successfully',
                'discount' => $coupon->discount
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function removeCoupon(Request $request)
    {
        $user = auth()->user();

        // Get coupon from session
        $couponData = session('coupon');

        if ($couponData) {
            DB::beginTransaction();

            try {
                $coupon = Coupon::find($couponData['id']);

                if ($coupon) {
                    // Detach user from coupon (remove from pivot table)
                    $coupon->users()->detach($user->id);

                    // Decrement used_count
                    $coupon->decrement('used_count');
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Something went wrong'], 500);
            }
        }

        // Remove the applied coupon from session
        session()->forget('coupon');
        session()->forget('coupon.code');
        session()->forget('coupon.discount');
        session()->forget('discount');

        return response()->json([
            'success' => 'Coupon removed successfully',
            'discount' => 0
        ]);
    }

}
