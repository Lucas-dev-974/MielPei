<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'validToken']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $tokenValidity = 24 * 60;
        
        Auth::factory()->setTTL($tokenValidity);
        
        if(!$token = Auth::attempt($validator->validated())){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $user = User::where('email', $request->email)->first();
        $vendor = $this->vendorExist($user->id);
        if($vendor){
            $user->vendor =  $vendor;
        }
        return response()->json([
            'user' => $user,
            'token' => $this->respondWithToken($token)
        ]);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'name'      => 'required|string',
            'last_name' => 'required|string',
            'name'      => 'required|string',
            'password'  => 'required|min:6',
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => false,
                "error" => $validator->errors()
                ]);
        }

        $user = User::where('email', $request->email)->first();

        if($user){
            return response()->json([
                'status' => false,
                'error' => 'Email déjà enregistrer'
            ]);
        }
        
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password),
            'role' => 'user',
            'phone'     => null
            ]
        ));

        $cred = ['email' => $request->email, 'password' => $request->password];

        $tokenValidity = 24 * 60;
        Auth::factory()->setTTL($tokenValidity);
        if(!$token = Auth::attempt($cred)){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'message' => 'Account created', 
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validToken()
    {
        $userConnected = $this->isConnected();
        if(!$userConnected){
            return response()->json([
                'success' => false,
                'error'   => 'votre token est invalide, veuillez vous connecté'
            ]);
        }
        return response()->json([
            'success' => true,
            'user'    => $userConnected
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }
}
