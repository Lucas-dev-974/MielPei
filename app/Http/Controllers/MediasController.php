<?php

namespace App\Http\Controllers;

use App\Models\ImagesProducts;
use App\Models\Products;
use App\Models\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MediasController extends Controller
{
    public function get_imagesByProductId(Request $request){

    }

    public function set_ImageProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'default' => 'required|boolean',  // Si l'image est l'image de présentation
            'product_id' => 'required|integer'
        ]);

        $user = $this->isConnected();
        if(!$user){
            return response()->json([
                'success' => false,
                'error'   => 'Veuillez vous connecté !'
            ]);
        }
        $vendor = $this->vendorExist($user->id);
        if(!$vendor){
            return response()->json([
                'success' => false,
                'error'   => 'Vous devez être vendeur pour effectué cet action !'
            ]);
        }

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
                'error'   => 'désolé, le produit n\'existe pas'
            ]);
        }
        if($product->vendors_id !== $vendor->id){
            return response()->json([
                'success' => false,
                'error'   => 'désolé, le produit n\'est pas à vous, vous ne pouvez le modifié'
            ]);
        }
        
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images/products'), $imageName);
        if($request->default){
            $success = Products::where('vendor_id', $vendor->id)->update([
                'url_img' => '/images/products/' . $imageName
            ]);
            if(!$success){
                return response()->json([
                    'success' => false,
                    'error' => 'une erreur est survenue lors de la mise en ligne de l\'image'
                ]);
            }
        }else{
            $success = ImagesProducts::create(
            [
                'product_id' => $product->id,
                'url'       => '/images/products/' . $imageName,
                'name'      => $imageName
            ]);
            if(!$success){
                return response()->json([
                    'success' => false,
                    'error' => 'une erreur est survenue lors de la mise en ligne de l\'image'
                ]);
            }
        }
       
        return response()->json([
            'success' => true,
            'message' => 'la photo du produit à été ajouté',
            'img-url' => '/images/products/' . $imageName
        ]);
    }
    

    public function set_ProfileImageVendors(Request $request){
        $user = $this->isConnected();
        if(!$user){
            return response()->json([
                'success' => false,
                'error'   => 'veuillez vous connecté !'
            ]);
        }if(!$this->vendorExist($user->id)){
            return response()->json([
                'success' => false,
                'error'   => 'vous devez être vendeur pour effectuer cet opération'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }

        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images/vendors/profiles-medias'), $imageName);
        $data = Vendors::where('client_id', $user->id)->update(['profile_img_url' => '/images/vendors/profiles-medias/' . $imageName]);
        if(!$data){
            return response()->json([
                'success' => false,
                'error'   => 'une erreur est survenue !'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'votre photo de profile à été ajouté, modifié',
        ]);
    }
}
