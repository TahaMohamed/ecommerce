<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Merchant\StoreResource;
use App\Http\Requests\Api\Merchant\StoreRequest;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store->loadCount('products');

        return StoreResource::make($store)
                            ->additional([
                                'status' => true,
                                'message' => ''
                            ]);
    }

    public function update(StoreRequest $request)
    {
        $store = auth()->user()->store->loadCount('products');
        $store->fill($request->validated())->save();

        return StoreResource::make($store)
                            ->additional([
                                'status' => true,
                                'message' =>  __('mobile.messages.success_add')
                            ]);
    }
}
