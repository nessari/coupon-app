<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Partner extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['coupons'];

    public function scopeFilter($query, array $filters)
    {
        if(isset($filters['lat']) && isset($filters['lng'])) {
            $lat = $filters['lat'];
            $lng = $filters['lng'];
            $radius = 5;
            $distance = DB::raw("*, ( 6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance");
        }
        
        $query->when(isset($filters['lat']) && isset($filters['lng']), fn($query) =>
            $query->select($distance)->orderBy('distance')->where('distance', '<=', $radius)->limit(1)
        );

        $query->when(isset($filters['partner']), fn($query, $partner) =>
            $query->find($partner)
        );
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }
}
