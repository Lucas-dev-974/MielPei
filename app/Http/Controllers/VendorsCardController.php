<?php

namespace App\Http\Controllers;

use App\Models\VendorsCardModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VendorsCardController extends Controller
{
    public function get_cards(){
        $cards = DB::table('vendor_cards')->get();
        return $cards;
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'details' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }
        $userConnected = $this->isConnected();
        if($userConnected === false){
            return response()->json([
                'success' => false,
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $vendor = $this->vendorExist($userConnected->id);
        if(!$vendor){
            return response()->json([
                'success' => false,
                'error'   => 'vous devez être vendeur pour avoir une fiche de description'
            ]);
        }

        $card = DB::table('vendor_cards')->where('vendor_id', $vendor->id)->get();
        if(sizeof($card) > 0){
            return response()->json([
                'success' => false,
                'error'   => 'vous avez déjà une fiche de description.'
            ]);
        }

        DB::table('vendor_cards')->insert([
            'vendor_id' => $vendor->id,
            'details'    => 'production de mail venant de Salazie'
        ]);
        return response()->json([
            'success' => true
        ]);
    }

    public function update(Request $request){
        $userConnected = $this->isConnected();  
        $validator = Validator::make($request->all(), [
            'details' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }if(!$userConnected){
            return response()->json([
                'success' => false,
                'error' => 'veuillez vous connecter'
            ]);
        }

        $vendor = $this->vendorExist($userConnected->id);
        if(!$vendor){
            return response()->json([
                'success' => false,
                'error'   => 'vous devez être vendeur pour effectuer une modification sur une fiche descriptive'
            ]);
        }
        $card = VendorsCardModel::where('vendor_id', $userConnected->vendor->id)->update(['detail' => $request->details]);
        return response()->json([
            'success' => true,
        ]);

    }
}
