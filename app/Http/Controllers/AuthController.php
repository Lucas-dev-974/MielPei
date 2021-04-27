<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VendorDetails;
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
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register', 'validToken']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {   
        $errors = [];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        $errors +=  ($validator->fails()) ? [$validator->errors()] : [];

        $tokenValidity = 24 * 60;
        
        Auth::factory()->setTTL($tokenValidity);
        
        $errors += (!$token = Auth::attempt($validator->validated())) ? ["Email ou mot de passe incorrecte"] : [];
        // Si il y'a des erreurs, alors on retourne les erreurs
        (sizeof($errors) != 0) ? abort(response()->json(["statu" => false, "errors" => $errors])) : null;

        
        $user = User::where('email', $request->email)->first();

        if($user->role === "vendor" || $user->role === "admin"){ // Si l'utilisateur est un producteur
            $vendor = VendorDetails::where('user_id', $user->id)->first();
            $user->vendor = $vendor;
        }
        
        if(!$user->active_account){
            return response()->json([
                'success' => false,
                'error'   => 'votre compte à été bloquer par l\'admin du site'
            ]);
        }
        return response()->json([
            'user' => $user,
            'token' => $this->respondWithToken($token)
        ]);
    }

    public function register(Request $request){
        $errors = [];

        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'name'      => 'required|string',
            'last_name' => 'required|string',
            'password'  => 'required|min:6|string',
            'password_confirm' => 'required|min:6|string'
        ]);
        
        // Si des champs sont manquant alors on stock le validator fails dans errors sinn retourne un tableau vide 
        $errors +=  ($validator->fails()) ? [$validator->errors()] : [];
        $user = User::where('email', $request->email)->first();
        $errors += ($user) ? ["error" => "Email déjà enregistrer"] : []; // Si un l'email est déjà enregistrer
        $errors += ($request->password !== $request->password_confirm) ? ["Les mots de passe ne correspondent pas ! "] : [];
        (sizeof($errors) != 0) ? abort(response()->json(["statu" => false, "errors" => $errors])) : null;

        $user = User::create(array_merge(
            $validator->validated(),
            [
            'password' => bcrypt($request->password),
            'role' => 'user',
            'active_account' => true,
            'phone'     => $request->phone ? $request->phone : null,
            ]
        ));

        $cred = ['email' => $request->email, 'password' => $request->password];

        $tokenValidity = 24 * 60;
        Auth::factory()->setTTL($tokenValidity);
        if(!$token = Auth::attempt($cred)){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'success'  => true,
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
        $user = $this->isConnected();
        if(!$user){
            return response()->json([
                'success' => false,
                'error'   => 'votre token est invalide, veuillez vous connecté'
            ]);
        }

        if($user->role == "vendor" || $user->role == "admin"){
            $user->vendor = VendorDetails::where('user_id', $user->id);
        }

        if($user->role === "vendor"){
            $vendor = VendorDetails::where('user_id', $user->id)->first();
            $user->vendor = $vendor;
        }
        return  response()->json([
            'success' => true,
            'user'    => $user
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
