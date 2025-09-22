<?php

namespace App\Http\Middleware;

use App\Models\Module;
use App\Models\Role;
use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Throwable;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        $auth = $request->header('Authorization'); // "Bearer <token>"
        if (!$auth || !str_starts_with($auth, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = substr($auth, 7);

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (Throwable $e) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $user = User::find($decoded->sub ?? null);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 401);
        }

       $roleName   = Role::find($user->role_id)?->role_name;
        $moduleName = Module::find($user->module_id)?->module_name;

        $request->attributes->set('auth_user', [
            'id'          => $user->id,
            'username'    => $user->username,
            'email'       => $user->email,
            'role'   => $roleName,
            'module' => $moduleName,
        ]);

        return $next($request);
    }
}
