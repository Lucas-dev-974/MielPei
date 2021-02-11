<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $user = $this->isConnected();
        $this->user = $user;
    }

    public function get_AllUsers(){

        ($this->user->role != 'admin') ? abort(response()->json(['Vous n\'ête pas autorizé'], 401)) : false ; // Retourne une erreur si l'utilisateur n'est pas admin
        
        $users = User::all();
        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    public function get_UserByRole(Request $request){
        ($this->user->role != 'admin') ? abort(response()->json(['Vous n\'ête pas autorizé'], 401)) : false ; // Retourne une erreur si l'utilisateur n'est pas admin
        $validator = Validator::make($request->all(), [
            'role' => 'required|string'
        ]);
        ($validator->fails()) ? abort(response()->json([
            'success' => false,
            'error'   => $validator->errors()
        ])) : false;

        
        $users = User::where('role', $request->role)->get();
        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    public function update_UserMail(Request $request){
        ($this->user->role != 'admin') ? abort(response()->json(['Vous n\'ête pas autorizé'], 401)) : false ; 
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'user_new_mail' => 'required|email',
        ]);

        ($validator->fails()) ? abort(response()->json([
            'success' => false,
            'error' => $validator->errors()
            ])) : false;

        $user = User::where('id', $request->user_id)->update(['email' => $request->user_new_mail]);
        if(!$user){
            return response()->json(['error' => 'Une erreur est survenue..'], 500);
        }
        return response()->json(['success' => true], 200);
    }

    public function update_UserRole(Request $request){
        // Si l'utilisateur n'est pas admin alor return error
        ($this->user->role != 'admin') ? abort(response()->json(['success' => false, 'error' => 'Vous n\'ête pas autorizé'])) : false ; 
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'user_new_role' => 'required|string'
        ]);

        ($validator->fails()) ? abort(response()->json(['success' => false, 'error' => $validator->errors()])) : false;
        
        // Get the user
        $the_user = User::find($request->user_id);
        
        (!$the_user) ? abort(response()->json(['success' => false, 'error' => 'l\'utilisateur n\'existe pas !'])) : false;
        
        switch($request->user_new_role){
            case 'vendor':
                if(!$the_user->vendor){
                    $created_state = Vendors::create([
                        'shop_name' => 'boutique créer par l\'admin',
                        'client_id' => $request->user_id
                    ]);
                    (!$created_state) ? abort(response()->json([ 'success' => false, 'error'   => 'une erreur est survenue !'])) : false;
                }
                break;

            case 'user':
                if($the_user->role === 'vendor'){
                    $the_user->vendor->products()->delete();
                
                    $delete_state = Vendors::where('client_id', $the_user->id)->delete();
                    (!$delete_state) ? abort(response()->json([ 'success' => false, 'error'   => 'supression de du vendeur échoué'])) : false;
                }
                break;
            case 'admin':
                break;
        }
        if($request->user_new_role === 'vendor'){
            
        }elseif($request->user_new_role === 'user' ){
            
        }
        // Update
        $update_state = $the_user->update(['role' => $request->user_new_role]);
        (!$update_state) ? abort(response()->json(['success' => false, 'error' => 'update error'])) : false;

        return response()->json(['success' => true], 200);
    }

    // Désactivé un compte utilisateur
    public function disable_UserAccount(Request $request){
        ($this->user->role != 'admin') ? abort(response()->json(['Vous n\'ête pas autorizé'], 401)) : false ; 
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'state' => 'required|boolean'
        ]);

        ($validator->fails()) ? abort(response()->json(['error' => $validator->errors()], 400)) : false;

        $user = User::where('id', $request->user_id)->update(['active_account' => $request->state]);
        if(!$user){
            return response()->json(['error' => 'Une erreur est survenue..'], 500);
        }
        return response()->json(['success' => true], 200);
    }

    // Supression d'un compte utilisateur
    public function delete_UserAccount(Request $request){
        ($this->user->role != 'admin') ? abort(response()->json(['Vous n\'ête pas autorizé'], 401)) : false ; 
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer'
        ]);

        ($validator->fails()) ? abort(response()->json(['error' => $validator->errors()], 400)) : false;

        $user = User::where('id', $request->user_id)->delete();
        if(!$user){
            return response()->json(['error' => 'Une erreur est survenue..'], 500);
        }
        return response()->json(['success' => true], 200);
    }

}
