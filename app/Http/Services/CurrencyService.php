<?php

namespace App\Http\Services;

use App\Repositories\Contracts\CurrencyRepositoryContract;
use App\Support\Classes\ServiceResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CurrencyService
{
    /**
     * @var CurrencyRepositoryContract
     */
    private static $currencyRepository;

    /**
     * @param CurrencyRepositoryContract $currencyRepository
     */
    public function __construct(CurrencyRepositoryContract $currencyRepository)
    {
        self::$currencyRepository = $currencyRepository;
    }

    /**
     *
     * @return ServiceResponse
     */
    public static function updateRates()
    {
        try {
            $currencies = self::$currencyRepository
                ->all(['iso_code']);

            if($currencies){
                $codes = $currencies
                    ->where('iso_code', '!=', env('DEFAULT_CURRENCY', 'EUR'))
                    ->pluck('iso_code')
                    ->toArray();

                $rates = json_decode(
                    file_get_contents("https://api.exchangeratesapi.io/latest?base=" . env('DEFAULT_CURRENCY', 'EUR') . "&symbols=" . implode(',', $codes)),
                    true
                );

                foreach ($currencies as $currency)
                {
                    if($currency->iso_code == $rates['base'])
                        $currency->conversion_rate = 1;
                    else
                        $currency->conversion_rate = $rates['rates'][$currency->iso_code];

                    $currency->save();
                }
            } else {
                throw new Exception("Missing currencies");
            }

            return new ServiceResponse(true);

        } catch (Exception $e) {
            Log::error('CurrencyService::updateRates Exception Error: ' . $e->getMessage());

            return new ServiceResponse(false);
        }
    }
}
