<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\User;
use App\Models\Vendors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->user = $this->isConnected();
    }
    public function add(Request $request){
        // if($userConnected === false){
        //     return response()->json([
        //         'success' => false,
        //         'error' => 'veuillez vous connecter'
        //     ]) ;
        // }
        $userConnected = $this->isConnected();
        $validator = Validator::make($request->all(), [
            'price' => 'required|numeric',
            'details' => 'required|string',
            'quantity' => 'required|integer',
            'name'     => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }
        
        if($userConnected->role !== 'vendor'){
            return response()->json([
                'success' => false,
                'error'   => 'vous devez être vendeur pour ajouter un produit !'
            ]);
        }
        $vendor = User::find($userConnected->id)->vendor;   
        
        $product = new Products();

        $product->vendors_id = $vendor->id;
        $product->price = $request->price;
        $product->name  = $request->name;
        $product->details = $request->details;
        $product->quantity = $request->quantity;

        $product->save();
        return \response()->json(['success' => true, 'product' => $product]);
    }

    public function update(Request $request){
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $validator = Validator::make($request->all(), [
            'row_name' => 'required|string',
            'value'    => 'required',
            'product_id' => 'required|integer'
        ]);

        if($validator->fails()){
            return new JsonResponse([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }

        $vendor = Vendors::where(['client_id' => $userConnected->id])->first();
        $product = Products::where(['id' => $request->product_id])->first();

        if($product->vendors_id !== $vendor->id){
            return new JsonResponse([
                'success' => false,
                'error'   => 'Vous n\'ête pas le vendeur de cet article !'
            ]);
        }

        switch($request->row_name){
            case 'price':
                if(!intval($request->value)){
                    return response()->json([
                        'success' => false,
                        'error'   => 'Seul un nombre est autorisé !'
                    ]);
                }
                $product = Products::where(['id' => $request->product_id])->update(['price' => $request->value]);
                return response()->json([
                    'success' => true
                ]);
                break;

            case 'quantity':
                $option = explode(':', $request->value);
                if(sizeof($option) > 1){
                    
                    if(!intval($option[1])){
                        return response()->json([
                            'success' => false,
                            'error'   => 'Seul un nombre est autorisé !'
                        ]);
                    }
                    $quantity = Products::where(['id' => $request->product_id])->first()->quantity;
                    if($option[0] === "+"){
                        $quantity += intval($option[1]);
                    }elseif($option[0] == '-' ){
                        $quantity -= intval($option[1]);
                    }                    
                    $product = Products::where(['id' => $request->product_id])->update(['quantity' => $quantity]);
                }else{  
                    $product = Products::where(['id' => $request->product_id])->update(['quantity' => $request->value]);
                }
                return response()->json([
                    'success' => true
                ]);
                break;
            
            case 'details':
                $product = Products::where(['id' => $request->product_id])->update(['details' => $request->value]);
                return response()->json([
                    'success' => true
                ]);
                break;
            
            case 'name':
                $update = $this->user->vendor->products()->where('id', $request->product_id)->update(['name' => $request->value]);
                if(!$update){
                    return response()->json([
                        'success' => false,
                        'error'   => 'une erreur est survenue'
                    ]);
                }

                return response()->json(['success' => true]);

            default:
                return response()->json([
                    'success' => false,
                    'error'   => 'nom de la table non reconnue !'
                ]);
                break;
        }
    }

    public function delete(Request $request){
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
            return new JsonResponse([
                'success' => false,
                'error'   => 'Des champs sont manquants veuillez tous les compléter !'
            ]);
        }

        $vendor  = Vendors::where(['client_id' => $userConnected->id])->first();
        $product = Products::where(['id' => $request->product_id])->first();

        if($product->vendors_id !== $vendor->id){
            return new JsonResponse([
                'success' => false,
                'error'   => 'Vous n\'ête pas le vendeur de cet article !'
            ]);
        }

        $product->delete();
        return new JsonResponse([
            'success' => true,
        ]); 
    }

    public function getProducts(Request $request){
        $validator = Validator::make($request->all(), [
            'products_limit_per_page' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }

        $products = DB::table('products')->get();
        return $products;
    }

    public function getBestProductsSold(){
        $products = Products::orderBy('total_sold', 'desc')->get();

        foreach($products as $product){
            if($product->url_img === null){
                $product->url_img = '/images/products/default.jpg';
            }
        }
        return response()->json(['success' => true, 'products' => $products]);
    }

    public function getVendorProducts(){
        $user = $this->isConnected();
        $vendor = $user->vendor;
        $products = $vendor->products;
        return response()->json(['success' => true, 'products' => $products]);
    }
}
