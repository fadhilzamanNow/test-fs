<?php

namespace App\Http\Controllers;

use App\Models\OrderLog;
use Illuminate\Http\Request;

class OrderLogController extends Controller
{
    public function index(Request $request)
    {
        $orderId = $request->query('order_id');
        $query = OrderLog::with('changer');

        if ($orderId) {
            $query->where('order_id', $orderId);
        }

        return response()->json($query->orderByDesc('created_at')->paginate(15));
    }

    public function show(string $id)
    {
        $log = OrderLog::with('changer')->findOrFail($id);
        return response()->json($log);
    }
}

