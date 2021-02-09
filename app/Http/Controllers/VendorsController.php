<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class VendorsController extends Controller
{
    public function add_vendor(Request $request){
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }

        $validator = Validator::make($request->all(), [
            'cultur_coordinate' => '|json',
            'shop_name'          => 'required|string'
        ]);

        if($validator->fails()){
            return new JsonResponse([
                'status' => false,
                'error'  => 'Des champs sont incomplets, veuillez tous les completés !',
                'validator_error' => $validator->errors()
            ]);
        }

        $vendor = Vendors::where('client_id', $userConnected->id)->first();
        User::where('id', $userConnected->id)->update(['role' => 'vendor']);

        // return new JsonResponse($vendor);
        if($vendor){
            return new JsonResponse([
                'status' => false,
                'error'  => 'Votre compte est déjà liée à un compte vendeur !'
            ]);
        }

        $vendor = Vendors::create(array_merge(
            $validator->validated(),
            ['client_id' => $userConnected->id]
        ));

        return new JsonResponse([
            'success' => true,
            'vendor' => $vendor,
            'user'   => $userConnected
            
        ]);
    }

    public function update(Request $request){
        $userConnected = $this->isConnected();
        if($userConnected === false){
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

        $vendor = $this->vendorExist($userConnected->id);
        if(!$vendor){
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
                $vendor->update([
                    'cultur_coordinate' => $request->value,
                ]);
                break;

            case 'shop_name': 
                $vendor->update([
                    'shop_name' => $request->value
                ]);          
                break;
            
            default:
                return response()->json([
                    'success' => false,
                    'error'   => "nom de la table non reconnue"
                ]);
                break;
        }
        return $vendor;
    }

    public function delete(){
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $vendor = $this->vendorExist($userConnected->id);
        if(!$vendor){
            return response()->json([
                'success' => false,
                'error'   => 'vous n\'ete pas vendeur'
            ]);
        }
        User::where('id', $userConnected->id)->update(['role' => 'user']);
        $vendor->delete();
        return  new JsonResponse([
            'success' => true,
            'message' => 'vendeur supprimer'
        ]);  
    }

    public function get(){
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'success' => false,
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $vendor = $this->vendorExist($userConnected->id);
        if(!$vendor){
            return response()->json([
                'success' => false,
                'error'   => 'vous n\'ete pas le vendeur'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'vendor'   => $vendor
        ]);
    }

    
}
