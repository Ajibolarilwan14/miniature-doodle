<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
    return [
        'name'  =>  $this->name,
        'description'   =>  $this->description ?? 'No Description Set',
        'product_category_id'   =>  $this->product_category_id,
    ];
    }
}