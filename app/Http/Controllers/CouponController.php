<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::query()
            ->latest()
            ->filter(request(['search', 'category']))
            ->paginate(9)
            ->withQueryString()
            ->through(fn($coupon) => [
                'id' => $coupon->id,
                'slug' => $coupon->slug,
                'title' => $coupon->title,
                'category' => $coupon->category,
                'excerpt' => $coupon->excerpt,
                'expiration' => $coupon->expiration,
                'og_price' => $coupon->og_price,
                'discounted_price' => $coupon->discounted_price
            ]);

        return Inertia::render('Coupons', [
            'coupons' => $coupons,
            'filters' => Request::only(['search', 'category']),
            'categories' => Category::all(),
        ]);
    }

    public function show(Coupon $coupon)
    {
        $saved = false;
        if(Auth::check())
        {
            $saved = $coupon->users()->where('user_id', Auth::id())->exists();
        }

        $reviews = Review::query()->latest()->where('coupon_id', $coupon->id)->paginate(10)->withQueryString();

        $hasReview = false;
        $exists = Review::where([['coupon_id', $coupon->id], ['user_id', Auth::id()]])->exists();
        if($exists)
        {
            $hasReview = true;
        }else {
            $hasReview = false;
        }

        $review = Review::where([['coupon_id', $coupon->id], ['user_id', Auth::id()]])->get();
        
        $avg_rating = Review::where('coupon_id', $coupon->id)->avg('rating');

        return Inertia::render('Coupon', [
            'coupon' => $coupon->load('reviews'),
            'saved' => $saved,
            'reviews' => $reviews,
            'avgRating' => round($avg_rating, 2)
        ]);
    }
}
