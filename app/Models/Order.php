<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'transaction_id',
        'billing_email',
        'billing_name',
        'billing_address',
        'billing_city',
        'billing_zip_code',
        'billing_total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class)->withPivot('quantity');
    }
}
