<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'plan_id','status','actual_ok','actual_ng',
        'due_date','created_at'
    ];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function plan() { return $this->belongsTo(ProductPlan::class, 'plan_id'); }
    public function logs() { return $this->hasMany(OrderLog::class, 'order_id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
