<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'coupon_id',
        'rating',
        'comment'
    ];

    protected $with = ['user'];

    public function avgByCoupon(Coupon $coupon)
    {
        $avg = $this->where('coupon_id', $coupon->id)->rating->avg();
        return $avg;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
