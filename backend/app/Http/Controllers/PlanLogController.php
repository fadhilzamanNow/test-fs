<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanLog;

class PlanLogController extends Controller
{
   public function index(Request $request)
    {
        $planId = $request->query('plan_id');
        $search = $request->query('q');

        $query = PlanLog::with([
            'changer:id,username,email',
            'plan:id,plan_name',
        ]);

        if ($planId) {
            $query->where('plan_id', $planId);
        }

        if ($search) {
            $like = "%{$search}%";
            $query->whereHas('plan', function ($q) use ($like) {
                $q->where('plan_name', 'ILIKE', $like);
            });
        }

        return response()->json(
            $query->orderByDesc('created_at')->paginate(7)
        );
    }

public function show($id)
{
    $log = PlanLog::with([
        'changer:id,username,email',   
        'plan:id,plan_name',
    ])->findOrFail($id);

    return response()->json($log);
}

}
