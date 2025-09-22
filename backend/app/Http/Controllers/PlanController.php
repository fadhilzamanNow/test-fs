<?php

namespace App\Http\Controllers;

use App\Models\ProductPlan;
use App\Models\PlanLog;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    // GET /plans?page=1&search=...
    public function index(Request $request)
    {
        $search  = $request->query('search');
        $perPage = (int) $request->query('per_page', 15);

        $query = ProductPlan::with('product')->orderByDesc('created_at');

        if ($search) {
            $like = "%{$search}%";
            $query->whereHas('product', fn($q) => $q->where('name','ilike',$like));
        }

        return response()->json($query->paginate($perPage));
    }

    // GET /plans/{id}
public function show(string $id)
{
    $plan = ProductPlan::with([
        'product',
        'statusLogs' => function ($q) {
            $q->with('changer.role', 'changer.module');
        },
        'createdBy.role',
        'createdBy.module',
    ])->findOrFail($id);

    return response()->json([
        'id'         => $plan->id,
        'product_id' => $plan->product_id,
        'plan_name'  => $plan->plan_name,
        'status'     => $plan->status,
        'due_date'   => $plan->due_date?->format('Y-m-d'),
        'created_at' => $plan->created_at,
        'created_by' => $plan->createdBy ? [
            'id'       => $plan->createdBy->id,
            'username' => $plan->createdBy->username,
            'role'     => $plan->createdBy->role?->role_name,
            'module'   => $plan->createdBy->module?->module_name,
        ] : null,
        'product' => $plan->product ? [
            'id'         => $plan->product->id,
            'name'       => $plan->product->name,
            'created_at' => $plan->product->created_at,
        ] : null,
        'status_logs' => $plan->statusLogs->map(function ($log) {
            return [
                'id'          => $log->id,
                'plan_id'     => $log->plan_id,
                'from_status' => $log->from_status,
                'to_status'   => $log->to_status,
                'note'        => $log->note,
                'created_at'  => $log->created_at,
                'changed_by'  => $log->changer ? [
                    'id'       => $log->changer->id,
                    'username' => $log->changer->username,
                    'role'     => $log->changer->role?->role_name,
                    'module'   => $log->changer->module?->module_name,
                ] : null,
            ];
        }),
    ]);
}



    // PATCH /plans/{id}
    public function update(Request $request, string $id)
    {
        $plan = ProductPlan::findOrFail($id);

        $data = $request->validate([
            'due_date' => 'sometimes|date',
        ]);

        $plan->update($data);

        return response()->json($plan);
    }

    // PATCH /plans/{id}/status
    public function changeStatus(Request $request, string $id)
    {
        $plan = ProductPlan::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'note'   => 'nullable|string'
        ]);

        $from = $plan->status;
        $to   = $data['status'];

        if ($from !== $to) {
            $plan->update(['status' => $to]);

            PlanLog::create([
                'plan_id'     => $plan->id,
                'from_status' => $from,
                'to_status'   => $to,
                'changed_by'  => $request->get('auth_user')['id'] ?? null,
                'note'        => $data['note'] ?? null,
                'created_at'  => now(),
            ]);
        }

        return response()->json($plan);
    }

    // DELETE /plans/{id}
    public function destroy(string $id)
    {
        $plan = ProductPlan::findOrFail($id);
        $plan->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
