<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShoppingCardController extends Controller
{
    
    public function getBuyedCard(){
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        
        $cards = DB::table('shopping_card')->where('clients_id', $userConnected->id)->where('isBuyed', true)->get();
        return $cards;
    }
    
    // Récupère la liste des produits qui son dans le panier (produit non acheter)
    public function getNonBuyedCard(){
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $cards = DB::table('shopping_card')->where('clients_id', $userConnected->id)->where('isBuyed', false)->get();
        return $cards;
    }

    public function removeToCard(Request $request){
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }

        if(!$this->productExist($request->product_id)){
            return response()->json([
                'success' => false,
                'error'   => 'Vous ne pouvez pas retirer du panier un produit qui n\'existe pas/plus'
            ]);
        }

        $data = DB::table('shopping_card')->where('id', $request->product_id)->delete();
        if($data === 0){
            return response()->json([
                'success' => false,
                'error'   => 'Aucun produit trouver dans le panier. Impossible de supprimer'
            ]);
        }
        return response()->json([
            'success' => true
        ]);
    }

    public function add(Request $request){
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|integer',
            'quantity'    => 'required|integer',
            'product_id' => 'required|integer',
            'final_price' =>'required',

        ]);

        if($validator->fails() || !is_numeric($request->final_price)){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }

        if(!$this->productExist($request->product_id)){
            return response()->json([
                'success' => false,
                'error'   => 'Le produit renseigner n\'existe pas !'
            ]);
        }

        
        DB::table('shopping_card')->insert([
            'vendor_id' => $request->vendor_id,
            'clients_id' => $userConnected->id,
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity,
            'final_price' => $request->final_price,
            'isBuyed'   => false,
        ]);
        
        return response()->json([
            'success' => true,
        ]);
    }


}
