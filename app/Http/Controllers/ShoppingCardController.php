<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ShoppingCard;
use App\Models\Vendors;
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
        foreach($cards as $card){
            $card->product_id = Products::find($card->product_id)->first();
            $card->vendor_id  = Vendors::find($card->vendor_id)->first();
        }
        return response()->json(['success' => true, 'cards' => $cards]);
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
        foreach($cards as $card){
            $card->product_id = Products::where('id', $card->product_id)->first();
            $card->vendor_id  = Vendors::where('id',  $card->vendor_id)->first();
        }
        return response()->json(['success' => true, 'cards' => $cards]);
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
            'price' =>'required|numeric',

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
                'error'   => 'Le produit renseigner n\'existe pas !'
            ]);
        }
        
        // $insertion = ShoppingCard::create(array_merge(
        //     $validator->validated(),
        //     [ 'clients_id' => $userConnected->id, 'isBuyed' => false]
        // ));
        DB::table('shopping_card')->insert([
            'vendor_id' => $request->vendor_id,
            'clients_id' => $userConnected->id,
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity,
            'final_price' => $request->quantity * $request->price,
            'isBuyed'   => false,
        ]);
        return response()->json([
            'success' => true,
        ]);
    }


}
