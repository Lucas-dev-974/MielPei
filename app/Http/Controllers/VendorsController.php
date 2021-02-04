<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            'cultur_coordinate' => 'required|json',
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
        User::where('id', $userConnected->id)->update(['is_vendor' => true]);

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

    public function updateShopName(Request $request){
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }

        $validator = Validator::make($request->all(), [
            'ShopName' => 'required|string'
        ]);

        if($validator->fails()){
            return new JsonResponse([
                'success' => false,
                'error'   => 'Le nouveau nom de la boutique est requis !'
            ]);
        }

        $vendor = Vendors::where('client_id', $userConnected->id)->update(['shop_name' => $request->ShopName]);
        return $vendor;
    }


    public function delete(){
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        User::where('id', $userConnected->id)->update(['is_vendor' => false]);
        Vendors::where('client_id', $userConnected->id)->first()->delete();

        return  new JsonResponse([
            'success' => true,
            'message' => 'vendeur supprimer'
        ]);  
    }
}
