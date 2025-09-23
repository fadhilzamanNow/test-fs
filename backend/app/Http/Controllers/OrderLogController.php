<?php

namespace App\Http\Controllers;

use App\Models\OrderLog;
use Illuminate\Http\Request;

class OrderLogController extends Controller
{
    public function index(Request $request)
    {
        $orderId = $request->query('order_id');
        $search = $request->query('q');

        $query = OrderLog::with([
            'changer',
            'order.plan',  // eager load plan
        ]);

        if ($orderId) {
            $query->where('order_id', $orderId);
        }

        if ($search) {
            $like = "%{$search}%";
            $query->whereHas('order.plan', function ($q) use ($like) {
                $q->where('plan_name', 'ILIKE', $like);
            });
        }

        return response()->json(
            $query->orderByDesc('created_at')->paginate(7)
        );
    }

    public function show(string $id)
    {
        $log = OrderLog::with('changer')->findOrFail($id);
        return response()->json($log);
    }
}

