<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ShoppingCard;
use App\Models\User;
use App\Models\Vendors;
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
        try{ // Vérifie si il y a un token pour autoriser l'accées aux données
            $user = Auth::userOrFail();
            return $user;
        }catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return false;
        }
    }

    public function vendorExist($client_id){
        $vendor = Vendors::where('client_id', $client_id)->first();
        if(!$vendor){
            return false;
        }
        return $vendor;
    }

    public function clientExist($client_id){
        $client = User::where('id', $client_id)->first();
        if(!$client){
            return false;
        }
        return $client;
    }
    
    public function productExist($product_id){
        $product = Products::where('id', $product_id)->first();
        if(!$product){
            return false;
        }
        return $product;
    }

    public function IsUserShoppingCard($shopping_card_id, $user_id){
        $card = ShoppingCard::where('id', $shopping_card_id)->get();
        if($card->clients_id !== $user_id){
            return false;
        }
        return $card;
    }

    public function IsAdmin($user_id){
        $user = User::where('id', $user_id)->get();
        if(!$user){
            return false;
        }
        if($user->role !== 'admin'){
            return false;
        }

        return true;
    }
    
}
