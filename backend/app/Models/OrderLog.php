<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OrderLog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['order_id','from_status','to_status','changed_by','note','created_at'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function order() { return $this->belongsTo(Order::class, 'order_id'); }
    public function changer() { return $this->belongsTo(User::class, 'changed_by'); }
}
