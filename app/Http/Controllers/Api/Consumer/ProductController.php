<?php

namespace App\Http\Controllers\Api\Consumer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Consumer\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request,$store_id)
    {
        $products = Product::where('store_id',$store_id)
                            ->active()
                            ->filter($request)
                            ->latest()
                            ->paginate((int)($request->per_page ?? 10));

        return ProductResource::collection($products)
                                ->additional([
                                    'status' => true,
                                    'message' => ''
                                ]);
    }

    public function show($id)
    {
        $product = Product::active()->with('store')->findOrFail($id);

        return ProductResource::make($product)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }
}
