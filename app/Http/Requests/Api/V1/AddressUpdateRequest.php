<?php

namespace App\Http\Requests\Api\V1;

use App\Repositories\Contracts\AddressRepositoryContract;

class AddressUpdateRequest extends ApiFormRequest
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
        parent::__construct();

        $this->addressRepository = $addressRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $address = $this->addressRepository->findOrFail($this->route('address'));

        return $this->user()->can('update', $address);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alias' => 'required|string|max:190',
            'first_name' => 'required|string|max:190',
            'last_name' => 'required|string|max:190',
            'company' => 'nullable|string|max:190',
            'address1' => 'required|string|max:190',
            'address2' => 'nullable|string|max:190',
            'postcode' => 'nullable|string|max:12',
            'city' => 'required|string|max:190',
            'state' => 'nullable|string|max:190',
            'country' => 'required|string|max:190',
            'phone' => 'nullable|string|max:32',
            'phone_mobile' => 'nullable|string|max:32',
            'vat_number' => 'nullable|string|max:32',
            'other' => 'nullable|string|max:1000'
        ];
    }
}
