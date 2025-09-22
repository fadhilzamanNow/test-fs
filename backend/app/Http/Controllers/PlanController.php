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

    public function store(Request $request)
{
    $data = $request->validate([
        'plan_name'  => 'required|string|max:100',    // or use plan_no if you really have it
        'product_id' => 'required|uuid|exists:products,id',
        'quantity'   => 'required|integer|min:1',
        'due_date'   => 'nullable|date',              // make column nullable in migration
    ]);

    $plan = ProductPlan::create([
        'plan_name'  => $data['plan_name'],
        'product_id' => $data['product_id'],
        'quantity'   => $data['quantity'],
        'status'     => 'pending',                    // force initial status
        'due_date'   => $data['due_date'] ?? null,    // ok if column nullable
        'created_at' => now(),                        // ensure in $fillable
        'created_by' => $request->get('auth_user')['id'] ?? null, // if you added created_by
    ]);

    // initial log (avoid NULL if from_status is NOT NULL)
    PlanLog::create([
        'plan_id'     => $plan->id,
        'from_status' => 'pending',                   // not null-safe
        'to_status'   => 'pending',
        'changed_by'  => $plan->created_by,
        'note'        => 'Plan created',
        'created_at'  => $plan->created_at,
    ]);

    return response()->json($plan, 201);
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
        'quantity' => $plan->quantity,
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

            if ($to === 'approved' && !$plan->due_date) {
            $updateData['due_date'] = now()->addDays(7)->format('Y-m-d');
        }

        $plan->update($updateData);

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
