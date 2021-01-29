<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collection_OrdinateurResource;
use App\Models\ordinateurModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrdinateursController extends Controller
{

    function get(Request $request){
        
        if($this->isConnected() === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }

        $date = Validator::make($request->query(), [
            'date' => 'date|required'
        ])->validate();

        $date = ordinateurModel::with(['attributions' => function($q) use ($date) {
            $q->where('date', $date['date'])
            ->with(['client']);
        }])->paginate(3);

        return Collection_OrdinateurResource::collection($date);
    }

    function add(Request $request){
        if($this->isConnected() === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $data = $request->validate(['nom' => 'required|string']);
        $addOrdi = new ordinateurModel();
        $addOrdi->nom = $data['nom'];
        $addOrdi->save();
        return new Collection_OrdinateurResource($addOrdi);
    }

    function del(Request $req){
        if($this->isConnected() === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $data = Validator::make($req->query(), [
            'id' => 'required'
        ])->validate();
        
        if(isset($data['id']) && !empty($data['id'])){
            $modelOrdi = ordinateurModel::where('id', $data['id'])->delete();
        }
    }

    public function update(Request $request){
        if($this->isConnected() === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $validator = Validator::make($request->all(), [
            'computerID' => 'required|integer',
            'computerName' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()
            ]);
        }

        $computer = ordinateurModel::find($request->computerID);
        $computer->nom = $request->computerName;
        $computer->save();

        return response()->json([
            'success' => true,
            'message' => "L'oridnateur à été modifier avec succées !"
        ]);
    }

    function pagination(Request $req){
        
    }
}
