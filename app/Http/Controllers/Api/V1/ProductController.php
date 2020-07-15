<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ProductStoreRequest;
use App\Http\Requests\Api\V1\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Services\ProductService;
use App\Repositories\Contracts\ProductRepositoryContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends ApiController
{
    /**
     * @var ProductRepositoryContract
     */
    private $productRepository;

    /**
     * @param ProductRepositoryContract $productRepository
     */
    public function __construct(ProductRepositoryContract $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->middleware('auth:sanctum')->only([
            'store',
            'update',
            'destroy'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->paginate($request->get('per_page'));

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return ProductResource|JsonResponse
     */
    public function store(ProductStoreRequest $request)
    {
        $response = ProductService::store($request->validated());

        if($response->success()) {
            return new ProductResource($response->getModel());
        } else {
            return response()->json(['message' => $response->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return ProductResource|JsonResponse
     */
    public function show(string $slug)
    {
        $product = $this->productRepository->findOrFailBy('slug', $slug);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param int $id
     * @return ProductResource|JsonResponse
     */
    public function update(ProductUpdateRequest $request, int $id)
    {
        $response = ProductService::update($id, $request->validated());

        if($response->success()) {
            return new ProductResource($response->getModel());
        } else {
            return response()->json(null, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        return response()->json(null);
    }
}
