<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        if(!Auth::check())
        {
            abort(401);
        }

        $orders = Order::query()
            ->latest()
            ->where('user_id', Auth::id())
            ->with('coupons')
            ->get();

        return Inertia::render('User/Orders',[
            'orders' => $orders
        ]);
    }

    public function show(Order $order)
    {
        return Inertia::render('User/OrderDetails', [
            'order' => $order->load('coupons')
        ]);
    }
}
