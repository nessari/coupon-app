<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Partner;
use Inertia\Inertia;
use Request;

class MapController extends Controller
{
    public function index()
    {
        $partners = Partner::all();

        $filteredPartners = $partners;

        if(request('lat') && request('lng') || request('partner')) {
            $filteredPartners = Partner::query()
                ->filter(request(['lat', 'lng', 'partner']))
                ->get();
        }

        return Inertia::render('GeoSearch', [
            'partners' => $partners,
            'filteredPartners' => $filteredPartners->load('coupons'),
            'filters' => Request::only(['lat', 'lng', 'partner'])
        ]);

    }

    public function show(Partner $partner)
    {
        return Inertia::render('GeoSearch', [
            'partner' => $partner->load('coupons')
        ]);
    }
}
