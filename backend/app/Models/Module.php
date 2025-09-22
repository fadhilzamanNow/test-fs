<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //

    use HasUuids;

    public $timestamps = false;

    protected $fillable = ["module_name"];

    public function user(){
        return $this->hasMany(User::class, "module_id");
    }
}
