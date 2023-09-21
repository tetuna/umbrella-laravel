<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $description = $this->description;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => strlen($description) > 30 ? substr($description, 0, 30) . "..." : $description,
            'price' => $this->price,
            'categories' => CategoryResource::collection($this->categories),
        ];
    }
}
