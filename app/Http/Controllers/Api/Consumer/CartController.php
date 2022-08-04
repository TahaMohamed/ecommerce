<?php

namespace App\Http\Controllers\Api\Consumer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Consumer\CartResource;
use App\Http\Requests\Api\Consumer\CartRequest;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $carts = Cart::where('consumer_id',auth()->id())
                            ->with('store')
                            ->latest()
                            ->paginate((int)($request->per_page ?? 10));

        return CartResource::collection($carts)
                                ->additional([
                                    'status' => true,
                                    'message' => ''
                                ]);
    }

    public function store(CartRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = Cart::firstOrCreate(['consumer_id' => auth()->id(),'store_id'  => $product->store_id]);
        $cart->cartProducts()->updateOrCreate(['product_id' => $product->id],$request->validated());

        return CartResource::make($cart->load('store','cartProducts'))
                            ->additional([
                                'status' => true,
                                'message' =>  __('mobile.message.success_add')
                            ]);
    }

    public function show($id)
    {
        $cart = auth()->user()->carts()->with('store','cartProducts')->findOrFail($id);

        return CartResource::make($cart)
                            ->additional([
                                'status' => true,
                                'message' => ''
                            ]);
    }

    public function destroy($id)
    {
        $cart_product = CartProduct::with(['cart' => fn($q) => $q->with('store','cartProducts')])
                                    ->whereHas('cart',fn($q) => $q->where('consumer_id',auth()->id()))
                                    ->findOrFail($id);
        $cart_product->delete();
       
        return CartResource::make($cart_product->cart)
                            ->additional([
                                'status' => true,
                                'message' =>  __('mobile.message.success_delete')
                            ]);
    }
}
