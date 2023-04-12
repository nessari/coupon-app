<?php

namespace App\Services;

use Gloudemans\Shoppingcart\Facades\Cart;

class OrderService {
    public function all($request, $transaction_id) {
        $total = Cart::instance('default')->total();

        return [
            'transaction_id' => $transaction_id,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_zip_code' => $request->zip_code,
            'total' => $total,
        ];
    }
}