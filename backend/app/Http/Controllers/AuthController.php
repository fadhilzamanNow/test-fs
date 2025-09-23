<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthController extends Controller
{
    private function issueToken(User $user): string
    {
        $now = time();
        $payload = [
            'sub' => $user->id,      
            'iat' => $now,           
            'exp' => $now + 60*60*2, 
        ];
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    // POST /api/register
   
     public function register(Request $req)
    {
        // Validation happens first. If it fails, Laravel automatically
        // throws an exception and returns a 422 error, so it doesn't 
        // need to be inside the try block.
        $data = $req->validate([
            'username'     => 'required|string|max:50|unique:users,username',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:8',
            'role_name'    => 'required|string',   
            'module_name'  => 'required|string',   
        ]);

        // 👇 2. Start the 'try' block for your main logic
        try {
            $roleName   = strtolower(trim($data['role_name']));
            $moduleName = strtolower(trim($data['module_name']));

            // Safely find the models
           $role = Role::whereRaw('LOWER(role_name) = ?', [$roleName])->first();
            $module = Module::whereRaw('LOWER(module_name) = ?', [$moduleName])->first();

            // Check if models were found
            if (!$role || !$module) {
                return response()->json([
                    'message' => 'Invalid role_name or module_name.',
                    'errors' => [
                        'role_name'   => $role   ? null : ['Role not found.'],
                        'module_name' => $module ? null : ['Module not found.'],
                    ],
                ], 422);
            }

            // Create the user
            $user = User::create([
                'username'  => $data['username'],
                'email'     => $data['email'],
                'password'  => Hash::make($data['password']),
                'role_id'   => $role->id,
                'module_id' => $module->id,
                'created_at' => now()
            ]);

            // Return a successful response
            return response()->json([
                'message' => 'User registered successfully!',
                'user'  => [
                    'id'          => $user->id,
                    'username'    => $user->username,
                    'email'       => $user->email,
                    'role_name'   => $role->role_name,
                    'module_name' => $module->module_name,
                ],
            ], 201);

        } catch (Throwable $e) { // 👇 3. Catch any error or exception
            
            // Log the detailed error for debugging. This is CRITICAL.
            Log::error('Registration failed: ' . $e->getMessage());
            
            // Return a generic, user-friendly error message
            return response()->json([
                'message' => $e->getMessage(),
                'data' => $data
            ], 500); // 500 is the standard code for a server error
        }
    }


    // POST /api/login
    public function login(Request $req)
    {
        
        $data = $req->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'token' => $this->issueToken($user),
            'user'  => $user->only(['id','username','email']),
        ]);
    }

    // GET /api/me (protected)
    public function me(Request $req)
    {
        return response()->json($req->get('auth_user'));
    }
}
