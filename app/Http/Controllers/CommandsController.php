<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCard;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommandsController extends Controller
{
    public function makeCommand(Request $request){
        $user = $this->isConnected();
        if($user === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $validator = Validator::make($request->all(), [
            'shopping_card_id' => 'required|integer',
            'total_price' => 'required|numeric'
        ]);

        if($validator->fails()){
            return new JsonResponse([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }

        $card = $this->IsUserShoppingCard($request->shopping_card_id, $user->id);
        if(!$card){
            return response()->json([
                'success' => false,
                'error'   => 'cet commande n\'est pas la votre !'
            ]);
        }

        DB::table('commands')->insert([
            'shopping_card_id' => $request->shopping_card_id,
            'client_id'        => $user->id,
            'total_price'      => $request->total_price,
            'commanded_date'   => new DateTime(),
        ]);

        return response()->json([
            'success' => true
        ]);

    }

    public function get(){
        $user = $this->isConnected();
        if($user === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }

        $commands = DB::table('commands')->where('client_id', $user->id)->get();
        return $commands;
    }

    public function getAllCommand(){

    }
}
