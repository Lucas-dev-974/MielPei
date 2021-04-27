<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\User;
use App\Models\VendorDetails;
use App\Models\Vendors;
use DateTime;
use Hamcrest\Core\HasToString;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function __construct(){
        $this->user = $this->isConnected();
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'price' => 'required|numeric',
            'details' => 'required|string',
            'quantity' => 'required|integer',
            'name'     => 'required|string',
            'img'      => 'required|image'
        ]);
        
        ($validator->fails()) ?     // Si une valeur entrante est manquante retourne une erreur
        abort(response()->json(['success' => false, 'error'   => $validator->errors()])) : false;
            
        ($this->user->role === 'user') ?  // Si l'utilisateur n'est pas vendeur alors return une erreur
        abort(response()->json(['success' => false, 'error'   => 'vous devez être vendeur pour ajouter un produit !'])) : false;
        
        
        // Define image name and upload it in storage server with the name created
        $current_datime = date("Y.m.d-h.i");
        $img_name = "{$this->user->id}-{$current_datime}"  . '.' . $request->img->extension();
        $request->img->move(public_path('images/products'), $img_name);

        $product = new Products();
            $product->vendor = $this->user->vendor->id;
            $product->price = $request->price;
            $product->name  = $request->name;
            $product->details = $request->details;
            $product->quantity = $request->quantity;
            $product->url_img  = 'images/products/' . $img_name;
        $product->save();

        return response()->json(['success' => true, 'product' => $product]);
    }

    public function update(Request $request){
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

        $vendor = $this->userIsVendor($this->user)->vendor;

        $product = Products::where(['id' => $request->product_id])->first();

        if($product->vendor !== $vendor->id){
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
                $update = Products::where(['id' => $request->product_id])->update(['price' => $request->value]);
                if(!$update){
                    return response()->json(["success" => false, "errors" => "Une erreur est survenue lors de la mise a jour du produit"]);
                }else{
                    return response()->json([
                        'success' => true
                    ]);
                }

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
                $update = Products::where(['id' => $request->product_id])->update(['details' => $request->value]);
                if(!$update){
                    return response()->json(["success" => false, "errors" => "Une erreur est survenue lors de la mise a jour du produit"]);
                }else{
                    return response()->json([
                        'success' => true
                    ]);
                }
                break;
            
            case 'name':
                $update =  Products::where(['id' => $request->product_id])->update(['name' => $request->value]);
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
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return new JsonResponse([
                'success' => false,
                'error'   => 'Des champs sont manquants veuillez tous les compléter !'
            ]);
        }

        $vendor  = $this->userIsVendor($this->user)->vendor;
        $product = Products::where(['id' => $request->product_id])->first();

        if($product->vendor !== $vendor->id){
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

        $products = Products::get();
        $products = $this->get_SimpleProductVendorInformation($products);
        return $products;
    }

    public function getBestProductsSold(){
        $products = Products::orderBy('total_sold', 'desc')->get();
        $products = $this->get_SimpleProductVendorInformation($products); 
        return response()->json(['success' => true, 'products' => $products]);
    }

    public function getVendorProducts(Request $request){
        $user = $this->userIsVendor($this->user);
        $products = Products::where('vendor', $user->vendor->id)->get();
        return response()->json(['success' => true, 'products' => $products]);
    }

    private function get_SimpleProductVendorInformation($products){
        foreach($products as $product){
            $vendor =  VendorDetails::find($product->vendor)->select(['user_id', 'id', 'shop_name'])->first();
            $user   = User::find($vendor->user_id)->select(['name', 'last_name', 'email'])->first();
            $vendor->user = $user;
            $product->vendor = $vendor;
        }
        return $products;
    }
}
