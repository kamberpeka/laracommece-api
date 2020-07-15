<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\RoleEnum;
use App\Http\Requests\Api\V1\AddressStoreRequest;
use App\Http\Requests\Api\V1\AddressUpdateRequest;
use App\Http\Resources\AddressResource;
use App\Http\Services\AddressService;
use App\Repositories\Contracts\AddressRepositoryContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AddressController extends ApiController
{
    /**
     * @var AddressRepositoryContract
     */
    private $addressRepository;

    /**
     * @param AddressRepositoryContract $addressRepository
     */
    public function __construct(AddressRepositoryContract $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if($request->user()->role === RoleEnum::ADMIN) {
            $addresses = $this->addressRepository
                ->paginate($request->get('per_page'));
        } else {
            $addresses = $this->addressRepository
                ->ofUser($request->user()->id)
                ->paginate($request->get('per_page'));
        }

        return AddressResource::collection($addresses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddressStoreRequest $request
     * @return AddressResource|JsonResponse
     */
    public function store(AddressStoreRequest $request)
    {
        $response = AddressService::store($request->user()->id, $request->validated());

        if($response->success()) {
            return new AddressResource($response->getModel());
        } else {
            return response()->json(null, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return AddressResource
     *
     * @throws AuthorizationException
     */
    public function show(int $id)
    {
        $address = $this->addressRepository->findOrFail($id);
        $this->authorize('view', $address);

        return new AddressResource($address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddressUpdateRequest $request
     * @param int $id
     * @return AddressResource|JsonResponse
     */
    public function update(AddressUpdateRequest $request, int $id)
    {
        $response = AddressService::update($request->user()->id, $id, $request->validated());

        if($response->success()) {
            return new AddressResource($response->getModel());
        } else {
            return response()->json(null, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(int $id)
    {
        $address = $this->addressRepository->findOrFail($id);

        $this->authorize('delete', $address);

        if($address->delete()) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }
}
