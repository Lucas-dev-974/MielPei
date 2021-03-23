<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VendorDetails;
use App\Models\Vendors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class VendorsController extends Controller
{
    public function add_vendor(Request $request){
        $user = $this->isConnected();
        if($user === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }

        $validator = Validator::make($request->all(), [
            'cultur_coordinate'  => 'json|nullable',
            'shop_name'          => 'required|string'
        ]);

        if($validator->fails()){
            return new JsonResponse([
                'status' => false,
                'error'  => 'Des champs sont incomplets, veuillez tous les completés !',
                'validator_error' => $validator->errors()
            ]);
        }

        // return new JsonResponse($vendor);
        if($user->role === "vendor"){
            return new JsonResponse([
                'status' => false,
                'error'  => 'Votre compte est déjà liée à un compte vendeur !'
            ]);
        }

        $user->role = 'vendor';
        $user->save();

        $vendor_details = VendorDetails::create(array_merge($validator->validated(), [
            'user_id' => $user->id
        ]));

        $user->vendor = $vendor_details;

        return new JsonResponse([
            'success' => true,
            'user'   => $user,
        ]);
    }

    public function update(Request $request){
        $user = $this->isConnected();
        if($user === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }

        $validator = Validator::make($request->all(), [ 
            'row_name' => 'string|required',
            'value'    => 'string|required'
        ]);
        
        if($validator->fails()){
            return new JsonResponse([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }

        $user = $this->userIsVendor($user);
        if($user->role === 'user'){
            return response()->json([
                "success" => false,
                "error"   => 'Vous devez être vendeur pour effectué cet action !'
            ]);
        }

        switch($request->row_name){
            case 'cultur_coordinate':
                if(!is_string($request->value) && !is_array(json_decode($request->value, true))){
                    return response()->json([
                        'success' => false,
                        'error'   => 'Un json est attendu !'
                    ]);
                }
                $success = VendorDetails::where('user_id', $user->id)->update(['cultur_coordinate' => $request->value]);
                ($success) ? abort(response()->json(['success' => true])): abort(response()->json(['success' => false]));  
                break;

            case 'shop_name': 
                // return $user;
                $success = VendorDetails::where('user_id', $user->id)->update(['shop_name' => $request->value]);
                ($success) ? abort(response()->json(['success' => true])): abort(response()->json(['success' => false]));  
                break;

            case 'profile_img_url': 
                // return $user;
                $success = VendorDetails::where('user_id', $user->id)->update(['profile_img_url' => $request->value]);
                $success ? abort(response()->json(['success' => true])): abort(response()->json(['success' => false]));  
                break;
            
            default:
                return response()->json([
                    'success' => false,
                    'error'   => "nom de la table non reconnue"
                ]);
                break;
        }
        return $user->vendor;
    }

    public function delete(){
        $user = $this->isConnected();
        if($user === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $user = $this->userIsVendor($user);
        if($user->role === 'user'){
            return response()->json([
                'success' => false,
                'error'   => 'vous n\'ete pas vendeur'
            ]);
        }
        User::where('id', $user->id)->update(['role' => 'user']);
        $success = VendorDetails::where('user_id', $user->id)->delete();
        $success ? abort(response()->json(['success' => true, 'message' => 'vendeur supprimer'])) : 
                   abort(response()->json(['success' => false, 'message' => 'Une erreur c\'est produite ! Veuillez contacté l\'admin']));
    }

    public function get(){
        $user = $this->isConnected();
        if($user === false){
            return response()->json([
                'success' => false,
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $user = $this->userIsVendor($user);
        ($user->role === 'user') ? abort(response()->json(['success' => false, 'error' => 'vous n\'ete pas vendeur'])) : false;
        
        
        return response()->json([
            'success' => true,
            'user'   => $user
        ]);
    }

    
}
