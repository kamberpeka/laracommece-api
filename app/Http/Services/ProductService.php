<?php

namespace App\Http\Services;

use App\Repositories\Contracts\ProductRepositoryContract;
use App\Support\Classes\ServiceResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

class ProductService
{
    /**
     * @var ProductRepositoryContract
     */
    private static $productRepository;

    /**
     * @param ProductRepositoryContract $productRepository
     */
    public function __construct(ProductRepositoryContract $productRepository)
    {
        self::$productRepository = $productRepository;
    }

    /**
     * @param array $data
     * @return ServiceResponse
     */
    public static function store(array $data)
    {
        try {
            DB::beginTransaction();

            $product = self::$productRepository->create(
                Arr::only($data, self::fields())
            );

            $product->refresh();

            if(request()->has('featured_image')){
                $product->addMediaFromRequest('featured_image')
                    ->toMediaCollection('product_featured_image');
            }

            if(request()->has('gallery')){
                $product->addMultipleMediaFromRequest(['gallery'])
                    ->each(function (FileAdder $fileAdder) {
                        $fileAdder->toMediaCollection('product_gallery');
                    });
            }

            DB::commit();

            return new ServiceResponse(true, $product);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ProductService::store Exception Error: ' . $e->getMessage());

            return new ServiceResponse(false, null, $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param array $data
     * @return ServiceResponse
     */
    public static function update(int $id, array $data)
    {
        try {
            DB::beginTransaction();

            $product = self::$productRepository->findOrFail($id);

            $product->update(
                Arr::only($data, self::fields())
            );

            if(request()->has('featured_image')){
                $product->addMediaFromRequest('featured_image')
                    ->toMediaCollection('product_featured_image');
            }

            if(request()->has('gallery')){
                $product->addMultipleMediaFromRequest(['gallery'])
                    ->each(function (FileAdder $fileAdder) {
                        $fileAdder->toMediaCollection('product_gallery');
                    });
            }

            DB::commit();

            return new ServiceResponse(true, $product);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ProductService::update Exception Error: ' . $e->getMessage());

            return new ServiceResponse(false, null, $e->getMessage());
        }
    }

    /**
     * @return array
     */
    public static function fields()
    {
        return [
            'name',
            'description',
            'description_short',
            'meta_description',
            'meta_keywords',
            'meta_title',
            'on_sale',
            'online_only',
            'quantity',
            'price',
            'additional_shipping_cost',
            'width',
            'height',
            'weight',
            'out_of_stock',
            'active',
            'virtual'
        ];
    }

    /**
     * ToDo: Maybe we should check quantity from attributes too
     *
     * @param int|null $product_id
     * @param int|null $required_qta
     * @return bool
     */
    public static function hasAvailableProductQuantity(?int $product_id, ?int $required_qta = 1)
    {
        if($product_id === null || $required_qta === null || $required_qta < 1){
            return false;
        }

        $product = self::$productRepository->find($product_id);

        if($product){
            return ($product->quantity >= $required_qta);
        }

        return false;
    }
}
