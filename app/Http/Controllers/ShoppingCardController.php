<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Products;
use App\Models\ShoppingCard;
use App\Models\VendorDetails;
use App\Models\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ShoppingCardController extends Controller
{
    public function __construct(){
        $this->user = $this->isConnected();
    }
    
    public function getBuyedCard(){
        $cards = ShoppingCard::where('client_id', $this->user->id)->where('isBuyyed', true)->get();
        foreach($cards as $card){
            $card->product = Products::find($card->product_id)->first();
            $card->vendor  = User::find($card->vendor)->first();
        }
        return response()->json(['success' => true, 'cards' => $cards]);
    }
    
    // Récupère la liste des produits qui son dans le panier (produit non acheter)
    public function getNonBuyedCard(){
        $cards = ShoppingCard::where('client_id', $this->user->id)->where('isBuyed', false)->get(); 
        foreach($cards as $card ){ 
            $product = Products::find($card->product)->select(['price', 'details', 'name', 'url_img'])->first();
            $vendor  = VendorDetails::find($card->vendor)->select(['shop_name', 'user_id', 'profile_img_url'])->first();
            $vendor->user = User::find($vendor->user_id)->select(['name', 'last_name', 'email', 'phone'])->first();
            $card->vendor = $vendor;
            $card->product = $product;
        }
        return response()->json(['success' => true, 'cards' => $cards]);
    }

    public function removeToCard(Request $request){
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
        $validator = Validator::make($request->all(), [
            'quantity'   => 'required|integer',
            'product_id' => 'required|integer',

        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }

        $product = $this->productExist($request->product_id);
        if(!$product){
            return response()->json([
                'success' => false,
                'error'   => 'Le produit renseigner n\'existe pas !'
            ]);
        }

        $shoppingCardProduct = ShoppingCard::where(['product' => $request->product_id, 'client_id' => $this->user->id])->first();
        if($shoppingCardProduct){
            $shoppingCardProduct->quantity += $request->quantity;
            $shoppingCardProduct->final_price += $product->price;
            $shoppingCardProduct->save();
        }else{
            $card = new ShoppingCard();
                $card->vendor    = $product->vendor;
                $card->client_id = $this->user->id;
                $card->product   = $request->product_id;
                $card->quantity  = $request->quantity;
                $card->final_price = $request->quantity * $product->price;
                $card->isBuyed     = false;
            $card->save();
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function updateQuantity(Request $request){
        $validator = Validator::make($request->all(), [
            'options' => 'required|string',
            'shopping_card_id' => 'required|integer'
        ]);
            
        ($validator->fails()) ? abort(response()->json(['success' => false, 'error' => $validator->errors()])) : false;
        
        $shoppingCard = ShoppingCard::where(['client_id' => $this->user->id, 'id' => $request->shopping_card_id])->first(); // Get the shopping card datas

        $product      = Products::find($shoppingCard->product)->select("price")->first();        
        switch($request->options){
            case '+':
                $shoppingCard->quantity += 1;
                $shoppingCard->final_price += $product->price;
                $success = $shoppingCard->save();
                return $success ? response()->json(['success' => true])  : response()->json(['success' => false]);
            case '-':
                if($shoppingCard->quantity <= 1){ 
                    return response()->json(['success' => false, 'error' => 'Veuillez suprimer ce produit du panier, impossible de diminuer la quantité en dessous de 1']); 
                } 
                $shoppingCard->quantity -= 1;
                $shoppingCard->final_price -= $product->price;
                $success = $shoppingCard->save();
                return $success ? response()->json(['success' => true])  : response()->json(['success' => false]);
        }
    }

    public function buy(Request $req){
        $validator = Validator::make($req->all(), ['shoppingCardID']);
        if($validator->fails()) return response()->json(["success" => false, "error" => $validator->fails()]);

        $shoppingCard = ShoppingCard::find($req->shoppingCardID)->get();
        // $shoppingCard->isBuye

    }
}
