<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Vendors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    
    public function add(Request $request){
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'success' => false,
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $userConnected = $this->isConnected();
        $validator = Validator::make($request->all(), [
            'price' => 'required|integer',
            'details' => 'required|string',
            'quantity' => 'required|integer',
            'name'     => 'required|string'
        ]);

        if($validator->fails()){
            return new JsonResponse([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }
        
        $vendor = DB::table('vendors')->where('client_id', $userConnected->id)->first();
        // $vendor = Product::create(array_merge(
        //     $validator->validated(),
        //     ['vendors_id' => $vendor->id]
        // ));
        if(!$vendor){
            return response()->json([
                'success' => false,
                'error'   => 'vous devez être vendeur pour ajouter un produit !'
            ]);
        }
        
        $product = new Product();

        $product->vendors_id = $vendor->id;
        $product->price = $request->price;
        $product->name  = $request->name;
        $product->details = $request->details;
        $product->quantity = $request->quantity;

        $product->save();
        return $product;
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
        $product = Product::where(['id' => $request->product_id])->first();

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
                $product = Product::where(['id' => $request->product_id])->update(['price' => $request->value]);
                return response()->json([
                    'succes' => true
                ]);
                break;

            case 'quantity':
                $quantity = Product::where(['id' => $request->product_id])->first()->quantity;
                $option = explode(':', $request->value);

                if(!intval($option[1])){
                    return response()->json([
                        'success' => false,
                        'error'   => 'Seul un nombre est autorisé !'
                    ]);
                }
                if(sizeof($option) < 2){
                    return response()->json([
                        'success' => false,
                        'error'   => 'des options son manquante !'
                        ]);
                }
                if($option[0] === "+"){
                    $quantity += intval($option[1]);
                }elseif($option[0] == '-' ){
                    $quantity -= intval($option[1]);
                }else{
                    return response()->json([
                        'success' => false,
                        'error'   => 'option non reconnue !'
                    ]);
                }

                $product = Product::where(['id' => $request->product_id])->update(['quantity' => $quantity]);
                return response()->json([
                    'succes' => true
                ]);
                break;
            
            case 'details':
                $product = Product::where(['id' => $request->product_id])->update(['details' => $request->value]);
                return response()->json([
                    'succes' => true
                ]);
                break;

            default:
                return response()->json([
                    'success' => false,
                    'error'   => 'non de la table non reconnue !'
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
        $product = Product::where(['id' => $request->product_id])->first();

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
        $products = Product::orderBy('quantity', 'desc')->get();

        foreach($products as $product){
            if($product->url_img === null){
                $product->url_img = '/images/products/default.jpg';
            }
        }
        return $products;
    }
}
