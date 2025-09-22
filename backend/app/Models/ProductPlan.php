<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPlan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'production_plans'; 

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'status',
        'due_date',
        'created_at',
        'created_by',
        'plan_name',
        "quantity"
    ];

    protected $casts = [
        'due_date' => 'date:Y-m-d',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(PlanLog::class, 'plan_id');
    }

    public function createdBy()
{
    return $this->belongsTo(User::class, 'created_by');
}
}
