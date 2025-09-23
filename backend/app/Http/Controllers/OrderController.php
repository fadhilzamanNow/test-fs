<?php

// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLog;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 7);
        $orders = Order::with('plan.product')->paginate($perPage);
        return response()->json($orders);
    }

    public function show(string $id)
    {
        $order = Order::with(['plan.product','creator','logs.changer'])->findOrFail($id);
        return response()->json($order);
    }

    public function updateStatus(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $data = $request->validate([
            'status'    => 'required|in:waiting,in_progress,done,cancelled',
            'actual_ok' => 'nullable|integer|min:0',
            'actual_ng' => 'nullable|integer|min:0',
            'note'      => 'nullable|string',
        ]);

        $from = $order->status;
        $to   = $data['status'];

        $update = ['status' => $to];
        if ($to === 'in_progress' && !$order->started_at) {
            $update['started_at'] = now();
        }
        if ($to === 'done') {
            $update['finished_at'] = now();
            if ($request->filled('actual_ok')) $update['actual_ok'] = $data['actual_ok'];
            if ($request->filled('actual_ng')) $update['actual_ng'] = $data['actual_ng'];
        }

        $order->update($update);

        OrderLog::create([
            'order_id'   => $order->id,
            'from_status'=> $from,
            'to_status'  => $to,
            'changed_by' => $request->get('auth_user')['id'] ?? null,
            'note'       => $data['note'] ?? null,
        ]);

        return response()->json($order->fresh());
    }
}

