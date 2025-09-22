<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PlanLog extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'plan_logs';
    public $timestamps = false;

    protected $fillable = [
        'plan_id',
        'from_status',
        'to_status',
        'changed_by',
        'note',
        'created_at',
    ];

    public function plan()
    {
        return $this->belongsTo(ProductPlan::class, 'plan_id');
    }

    public function changer()
{
    return $this->belongsTo(User::class, 'changed_by');
}

}
