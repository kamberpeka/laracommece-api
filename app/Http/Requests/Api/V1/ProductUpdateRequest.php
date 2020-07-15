<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\ProductConditionEnum;
use App\Enums\ProductVisibilityEnum;

class ProductUpdateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:190',
            'description' => 'nullable|string|max:5000',
            'description_short' => 'nullable|string|max:1000',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:190',
            'meta_title' => 'nullable|string|max:190',
            'on_sale' => 'nullable|boolean',
            'online_only' => 'nullable|boolean',
            'quantity' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'additional_shipping_cost' => 'nullable|integer|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'out_of_stock' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
            'virtual' => 'nullable|boolean'
        ];
    }
}
