<?php

namespace App\Http\Services;

use App\Repositories\Contracts\AddressRepositoryContract;
use App\Support\Classes\ServiceResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AddressService
{
    /**
     * @var AddressRepositoryContract
     */
    private static $addressRepository;

    /**
     * @param AddressRepositoryContract $addressRepository
     */
    public function __construct(AddressRepositoryContract $addressRepository)
    {
        self::$addressRepository = $addressRepository;
    }

    /**
     * @param int $user_id
     * @param array $data
     * @return ServiceResponse
     */
    public static function store(int $user_id, array $data)
    {
        try {
            DB::beginTransaction();

            $address = self::$addressRepository->create(
                Arr::only($data, [
                    'alias',
                    'first_name',
                    'last_name',
                    'company',
                    'address1',
                    'address2',
                    'postcode',
                    'city',
                    'state',
                    'country',
                    'phone',
                    'phone_mobile',
                    'vat_number',
                    'other'
                ]) + ['user_id' => $user_id]
            );

            DB::commit();

            return new ServiceResponse(true, $address);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('AddressService::store Exception Error: ' . $e->getMessage());

            return new ServiceResponse(false);
        }
    }

    /**
     * @param int $user_id
     * @param int $id
     * @param array $data
     * @return ServiceResponse
     */
    public static function update(int $user_id, int $id, array $data)
    {
        try {
            DB::beginTransaction();

            $address = self::$addressRepository->findOrFail($id);

            if($address->hasOrders()){
                $replicatedAddress = $address->replicate();
                $replicatedAddress->push();
                $address->delete();

                $toBeUpdated = $replicatedAddress;
            } else {
                $toBeUpdated = $address;
            }

            $toBeUpdated->update(
                Arr::only($data, [
                    'alias',
                    'first_name',
                    'last_name',
                    'company',
                    'address1',
                    'address2',
                    'postcode',
                    'city',
                    'state',
                    'country',
                    'phone',
                    'phone_mobile',
                    'vat_number',
                    'other'
                ])
            );

            DB::commit();

            return new ServiceResponse(true, $toBeUpdated);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('AddressService::update Exception Error: ' . $e->getMessage());

            return new ServiceResponse(false);
        }
    }
}
