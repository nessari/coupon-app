<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutFormRequest;
use App\Models\Coupon;
use App\Models\User;
use App\Services\OrderService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Stripe\Exception\CardException;


class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Cart::instance('default')->count() == 0)
        {
            return redirect()->route('coupons-index');
        }
        $total = Cart::instance('default')->total();
        return Inertia::render('Checkout/Index', [
            'cartTotal' => $total
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderService $orderService, CheckoutFormRequest $request)
    {
        $cartItems = Cart::instance('default')->content()->map(function ($item) {
                return 
                    'Product ID: '.$item->id.', '.
                    'Product Name: '.$item->model->title.', '.
                    'Product Qty: '.$item->qty;
        })->values()->toJson();

        try {
            $user = Auth::user() ?? new User;
            $transaction_id = Str::uuid();
            
            $payment = $user->charge(ceil($request->amount), $request->payment_method_id, [
                'receipt_email' => $request->email,
                'statement_descriptor' => 'Coupon App',
                'description' => 'Enjoy',
                'metadata' => [
                    'Transaction ID' => $transaction_id,
                    'Item(s)' => $cartItems,
                    'Total Item(s) Count' => Cart::instance('default')->count(),
                ],
            ]);
            $payment = $payment->asStripePaymentIntent();

            $order = $user->orders()->create($orderService->all($request, $transaction_id));

            foreach(Cart::instance('default')->content() as $item) {
                $coupon = Coupon::find($item->model->id);
                $order->coupons()->attach($coupon, ['quantity' => $item->qty]);
            }

            Cart::destroy();

            return response([
                'success' => true,
                'order' => [
                    'transaction_id' => $order->transaction_id,
                    'billing_total' => $order->billing_total,
                    'coupons' => $order->coupons,
                ],
            ], 200);

        }catch (CardException $e) {
            return response([
                'errors' => $e->getMessage()
            ], 500);
        }catch (\Error $e) {
            return response([
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
