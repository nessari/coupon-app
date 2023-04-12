<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {   $items = Cart::instance('default')->content();
        $total = Cart::instance('default')->total();
        return Inertia::render('Cart/Index', [
            'cartItems' => $items,
            'cartTotal' => $total
        ]);
    }

    public function store(Request $request) {
        Cart::instance('default')
            ->add($request->id, $request->title, $request->quantity, $request->price, 0,
            [ 'slug' => $request->slug, 'expiretion' => $request->expiretion, 'image' => $request->image, 'excerpt' => $request->excerpt, 'description' => $request->description, 'og_price' => $request->og_price])
            ->associate('App\Models\Coupon');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        Cart::instance('default')->update($id, $request->quantity);
        return back();
    }

    public function destroy($id)
    {
        Cart::instance('default')->remove($id);
        return back();
    }

    public function destroyAll()
    {
        Cart::destroy();
        return back();
    }
}
