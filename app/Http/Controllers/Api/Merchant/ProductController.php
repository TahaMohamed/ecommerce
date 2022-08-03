<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Merchant\ProductResource;
use App\Http\Requests\Api\Merchant\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::whereHas('store',function($q){
                                $q->where('merchant_id',auth()->id());
                            })
                            ->with('store')
                            ->filter($request)
                            ->latest()
                            ->paginate((int)($request->per_page ?? 10));

        return ProductResource::collection($products)
                                ->additional([
                                    'status' => true,
                                    'message' => ''
                                ]);
    }

    public function store(ProductRequest $request, Product $product)
    {
        $product->fill($request->validated()+['store_id' => auth()->user()->store?->id])->save();

        return ProductResource::make($product->load('store'))
                            ->additional([
                                'status' => true,
                                'message' =>  __('mobile.message.success_add')
                            ]);
    }

    public function show($id)
    {
        $product = Product::whereHas('store',function($q){
                                $q->where('merchant_id',auth()->id());
                            })->with('store')->findOrFail($id);

        return ProductResource::make($product)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::whereHas('store',function($q){
                            $q->where('merchant_id',auth()->id());
                        })->with('store')->findOrFail($id);

        $product->fill($request->validated())->save();

        return ProductResource::make($product)
            ->additional([
                'status' => true,
                'message' => __('mobile.message.success_update')
            ]);
    }

    public function destroy($id)
    {
        $product = Product::whereHas('store',function($q){
                        $q->where('merchant_id',auth()->id());
                    })->with('store')->findOrFail($id);

        $product->delete();

        return ProductResource::make($product)
            ->additional([
                'status' => true,
                'message' =>  __('mobile.message.success_delete')
            ]);
    }
}
