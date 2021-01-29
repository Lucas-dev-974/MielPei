<?php

namespace App\Http\Controllers;

use App\Http\Resources\clientsResource;
use App\Models\attributionsModel;
use App\Models\ClientsModel;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
{
    function search(Request $request){
        $input = Validator::make($request->query(), [
            'inputName' => 'string|required'
        ])->validate();

        $model = ClientsModel::where('nom', 'like', '%'.$input['inputName'].'%')->get();

        return $model;
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string',
            'prenom' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }

        $client = ClientsModel::make(array_merge(
            $validator->validated()
        ));

        $client->save();
        
        return response()->json([
            'succes' => true,
            'message' => 'Le client a été créer',
            'client'  => $client
        ]);
    }
}
