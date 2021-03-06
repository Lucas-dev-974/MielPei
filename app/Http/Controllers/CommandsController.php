<?php

namespace App\Http\Controllers;

use App\Models\Commands;
use App\Models\ShoppingCard;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommandsController extends Controller
{
    private function __constructor(){
        $this->user = $this->isConnected();
    }

    public function makeCommand(Request $request){
        $errors = [];
       
        $errors += ($this->user === false) ? ['veuillez vous connecter'] : [];
        
        $validator = Validator::make($request->all(), [
            'shopping_card_id' => 'required|integer',
            'total_price' => 'required|numeric'
        ]);
        
        // Validator errors
        ($validator->fails()) ? abort(response()->json(["success" => false, 'errors' => $validator->errors()]))  : []; 
        
        $card = $this->IsUserShoppingCard($request->shopping_card_id, $this->user->id);
        $errors += (!$card) ? ['cet commande n\'est pas la votre ou n\'est plus disponilbe !'] : [];  // Si le panier n'appartien pas au client attendue
        return "ok";
        $state = Commands::create(array_merge($validator), ['
            commanded_date'   => new DateTime()
        ]);
        return $state;
        
        
        DB::table('commands')->insert([
            'shopping_card_id' => $request->shopping_card_id,
            'client_id'        => $this->user->id,
            'total_price'      => $request->total_price,
            'commanded_date'   => new DateTime(),
        ]);

        return response()->json([
            'success' => true
        ]);

    }

    public function get(){
        $commands = DB::table('commands')->where('client_id', $this->user->id)->get();
        return $commands;
    }

    public function getAllCommand(){

    }
}
