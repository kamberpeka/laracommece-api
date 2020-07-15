<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Services\CurrencyService;
use App\Repositories\Contracts\CurrencyRepositoryContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class CurrencyController extends ApiController
{
    /**
     * @var CurrencyRepositoryContract
     */
    private $currencyRepository;

    /**
     * @param CurrencyRepositoryContract $currencyRepository
     */
    public function __construct(CurrencyRepositoryContract $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateRates(Request $request)
    {
        $response = CurrencyService::updateRates();

        if($response->success()){
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }
}
