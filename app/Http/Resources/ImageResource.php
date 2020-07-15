<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\Support\File;

class ImageResource extends JsonResource
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
            'uuid' => $this->uuid,
//            'full_url' => $this->getFullUrl(),
            'base64' => $this->getBase64Array(),
            'collection_name' => $this->collection_name,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'size' => File::getHumanReadableSize($this->size),
            'manipulations' => $this->manipulations,
            'custom_properties' => $this->custom_properties,
            'responsive_images' => $this->responsive_images,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
