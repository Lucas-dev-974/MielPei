<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ShoppingCard;
use App\Models\User;
use App\Models\VendorDetails;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

 class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function isConnected(){
        try{ // Vérifie si il y a un token en place pour autoriser l'accées aux données
            $user = Auth::userOrFail();
            if($user->role === 'vendor'){   // Si l'user est un vendeur alors on retourne ses détails dans vendor
                $user->vendor = VendorDetails::where("user_id", $user->id)->first();
            }
            return $user;
        }catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return false;   
            // abort(response()->json(['success' => false, 'error' => 'veuillez vous connecter'])) ;
        }
    }

    public function userIsVendor($user){
        if($user->role != 'vendor'){
            return false;
        }
        $vendor = VendorDetails::where('user_id', $user->id)->select(['id', 'cultur_coordinate', 'shop_name', 'profile_img_url'])->get();
        $user->vendor = $vendor[0];
        return $user;
    }

    public function clientExist($client_id){
        $client = User::where('id', $client_id)->first();
        return (!$client) ? false : $client;
    }
    
    public function productExist($product_id){
        $product = Products::where('id', $product_id)->first();
        return (!$product) ?  false :  $product;
    }

    public function IsUserShoppingCard($shopping_card_id, $user_id){
        $card = ShoppingCard::where('id', $shopping_card_id)->get();
        return ($card->clients_id !== $user_id) ? false : $card;
    }

    public function IsAdmin($user_id){
        $user = User::where('id', $user_id)->get();
        return ($user->role !== 'admin') ?  false :  true;
    }    
}
