<?php

namespace App\Http\Controllers;

use App\Http\Resources\attributionsResource;
use App\Models\attributionsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttributionController extends Controller
{
    function addAttr(Request $req){
        if($this->isConnected() === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        $data = Validator::make($req->query(), [
            'heure'     => 'required',
            'id_ordi'   => 'required',
            'id_client' => 'required',
            'date'      => 'required',
        ])->validate();
        
        if($data){
            $new_attr = new attributionsModel();
            $new_attr->id_client = $data['id_client'];
            $new_attr->id_ordi   = $data['id_ordi'];
            $new_attr->horraire  = $data['heure'];
            $new_attr->date      = $data['date'];
            $new_attr->save();
            return $new_attr;
        }
    }

    function deleteAttribution(Request $req, $id){
        if($this->isConnected() === false){
            return response()->json([
                'error' => 'veuillez vous connecter'
            ]) ;
        }
        if(isset($id) && !empty($id)){
            $attrMb = attributionsModel::where('id', $id);
            $attrMb->delete();
        }
    }
}
