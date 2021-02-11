<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        ($this->user->role != 'admin') ? abort(response()->json(['Vous n\'ête pas autorizé'], 401)) : false ; 
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'user_new_role' => 'required|string'
        ]);

        ($validator->fails()) ? abort(response()->json(['error' => $validator->errors()], 400)) : false;

        $user = User::where('id', $request->user_id)->update(['role' => $request->user_new_role]);
        if(!$user){
            return response()->json(['error' => 'Une erreur est survenue..'], 500);
        }
        return response()->json(['success' => true], 200);
    }

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
