<?php

namespace App\Traits;

trait Filter
{
    public function scopeFilter($q, $request)
    {
        $q->when($request->serach, function ($q) use ($request) {
            $q->where('name', 'LIKE', "%$request->serach%")->orWhere('description', 'LIKE', "%$request->serach%");
        })->when(isset($request->is_active) && in_array($request->is_active, [1, 0]), function ($q) use ($request) {
            $q->where('is_active', $request->is_active);
        });
    }

    public function scopeUserFilter($q, $request)
    {
        $q->filter($request);
        $q->when($request->email, function ($q) use ($request) {
            $q->where('email', 'LIKE', "%$request->email%");
        })->when($request->phone, function ($q) use ($request) {
            $q->where('phone', 'LIKE', "%$request->phone%");
        });
    }
}
