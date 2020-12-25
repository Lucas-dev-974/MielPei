<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collection_OrdinateurResource;
use App\Models\ordinateurModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdinateursController extends Controller
{
    function get(Request $request){
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
        $data = $request->validate(['nom' => 'required|string']);
        $addOrdi = new ordinateurModel();
        $addOrdi->nom = $data['nom'];
        $addOrdi->save();
        return new Collection_OrdinateurResource($addOrdi);
    }

    function del(Request $req){
        $data = Validator::make($req->query(), [
            'id' => 'required'
        ])->validate();
        
        if(isset($data['id']) && !empty($data['id'])){
            $modelOrdi = ordinateurModel::where('id', $data['id'])->delete();
        }
    }

    function pagination(Request $req){
        
    }
}
