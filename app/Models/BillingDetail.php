<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    use HasFactory;

    protected $fillable = [ 'address', 'city', 'zip_code' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
