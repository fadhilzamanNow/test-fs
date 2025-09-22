<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements JWTSubject
{
    //

    use HasUuids;
    use HasFactory;
    use Notifiable;

    protected $table = "users";
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $keyType = "string";
    const CREATED_AT = "created_at";


    public function newUniqueId()
    {
        return (string) Uuid::uuid4();
    }
    
    public function role(){
        return $this->belongsTo(Role::class,"role_id");
    }

    public function module(){
        return $this->belongsTo(Module::class,"module_id");
    }

    protected $fillable = ["username","email",  "password","role_id","module_id","created_at"];

    public $timestamps = false;

     public function getJWTIdentifier(){ return $this->getKey(); }
    public function getJWTCustomClaims(): array { return []; }

}
