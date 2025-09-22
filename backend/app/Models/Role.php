<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasUuids;


    public $timestamps = false;

    public function user(){
        return $this->hasMany(User::class, "role_id");
    }


    protected $fillable = ["role_name"];
}
