<?php

namespace App\Http\Controllers\Api\Consumer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Consumer\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $stores = Store::active()
                        ->filter($request)
                        ->withCount(['products' => fn($q) => $q->active()])
                        ->latest()
                        ->paginate((int)($request->per_page ?? 10));

        return StoreResource::collection($stores)
                                ->additional([
                                    'status' => true,
                                    'message' => ''
                                ]);
    }

    public function show($id)
    {
        $store = Store::active()
                        ->withCount(['products' => fn($q) => $q->active()])
                        ->findOrFail($id);

        return StoreResource::make($store)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }
}
