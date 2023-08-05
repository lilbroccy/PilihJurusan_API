<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'total' => $this->count(),
            'retrieve' => $this->where('retrieve', '1')->count(),
            "data" => $this->where('retrieve', '1')->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'description' => $item->description,
                    'links' => [
                        "self" => "https://interview-api.pilihjurusan.id/foods/{$item->id}"
                    ]
                ];
        }),
        "message" => "Success retrieving food."
        ];
    }
}
