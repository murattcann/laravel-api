<?php

namespace App\Http\Resources;

use App\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductWithCategoriesResource extends JsonResource
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
            "_id" => $this->id,
            "title" => $this->title,
            "price" => $this->price,
            "categories" => CategoryResource::collection($this->whenLoaded("categories"))
        ];
    }
}
