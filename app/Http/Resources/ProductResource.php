<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'description_short' => $this->description_short,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'meta_title' => $this->meta_title,
            'on_sale' => $this->on_sale,
            'online_only' => $this->online_only,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'additional_shipping_cost' => $this->additional_shipping_cost,
            'width' => $this->width,
            'height' => $this->height,
            'weight' => $this->weight,
            'out_of_stock' => $this->out_of_stock,
            'active' => $this->active,
            'virtual' => $this->is_virtual,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'featured_image' => new ImageResource($this->getFirstMedia('product_featured_image')),
            'gallery' => ImageResource::collection($this->getMedia('product_gallery')),
        ];
    }
}
