<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class attributionsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $client = new clientsResource($this->client);
        return [
            'id'       => $this->id,
            'horraire' => $this->horraire,
            'client'   => $client,
        ];
    }
}
