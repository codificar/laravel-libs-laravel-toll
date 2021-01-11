<?php

namespace Codificar\Toll\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TollCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'success' => true,
            'attributes' => [
                'id' => $this->id,
                'name' => $this->name,
            ],
        ];
    }
    
}
