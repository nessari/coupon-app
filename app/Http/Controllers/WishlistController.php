<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function index()
    {
        if(!Auth::check())
        {
            abort(401);
        }

        $user = Auth::user();

        $coupons = $user
            ->coupons()
            ->latest()
            ->wherePivot('user_id', $user->getKey())
            ->get(['id', 'title', 'slug', 'expiration', 'discounted_price', 'image']);

        return Inertia::render('User/Saved',[
            'coupons' => $coupons
        ]);
    }

    public function create($coupon)
    {
        if(!Auth::check())
        {
            abort(401);
        }

        $user = Auth::user();
        $user->coupons()->attach($coupon);

        return back();
    }

    public function destroy($coupon)
    {
        if(!Auth::check())
        {
            abort(401);
        }

        $user = Auth::user();
        $user->coupons()->detach($coupon);

        return back();
    }
}
