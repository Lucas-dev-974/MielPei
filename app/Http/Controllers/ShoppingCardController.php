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
        $user = $this->isConnected();
        if($user === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        
        $cards = DB::table('shopping_card')->where('client_id', $user->id)->where('isBuyed', true)->get();
        foreach($cards as $card){
            $card->product_id = Products::find($card->product_id)->first();
            // $card->vendor_id  = User::find($card->vendor_id)->first();
        }
        return response()->json(['success' => true, 'cards' => $cards]);
    }
    
    // Récupère la liste des produits qui son dans le panier (produit non acheter)
    public function getNonBuyedCard(){
        $user = $this->isConnected();
        if($user === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }

        $cards = ShoppingCard::where('client_id', $user->id)
                             ->where('isBuyed', false)->get(); 
        
        if(strlen($cards) > 0){
            foreach($cards as $card){
                $card->product_id = Products::find($card->product_id);
                $card->product_id->img_url = ($card->product_id->img_url == null) ? "/images/products/default.jpg" : $card->product_id->img_url ;
            }
        }

        return response()->json(['success' => true, 'cards' => $cards]);
    }

    public function removeToCard(Request $request){
        $user = $this->isConnected();
        if($user === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $validator = Validator::make($request->all(), [
            'card_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }

        $deleted = ShoppingCard::where('id', $request->card_id)->delete();
        if($deleted === 0){
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
        $user = $this->isConnected();
        if($user === false){
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

        $card = new ShoppingCard();
        $card->vendor_id = $request->vendor_id;
        $card->client_id = $user->id;
        $card->product_id = $request->product_id;
        $card->quantity   = $request->quantity;
        $card->final_price = $request->quantity * $request->price;
        $card->isBuyed     = false;
        $card->save();
        // DB::table('shopping_card')->insert([
        //     'vendor_id' => $request->vendor_id,
        //     'clients_id' => $user->id,
        //     'product_id' => $request->product_id,
        //     'quantity'   => $request->quantity,
        //     'final_price' => $request->quantity * $request->price,
        //     'isBuyed'   => false,
        // ]);
        return response()->json([
            'success' => true,
        ]);
    }


}
