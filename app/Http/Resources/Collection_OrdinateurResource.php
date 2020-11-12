<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Collection_OrdinateurResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $attributions = attributionsResource::collection($this->attributions);
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'attribution' => $attributions,
        ];
    }
}
