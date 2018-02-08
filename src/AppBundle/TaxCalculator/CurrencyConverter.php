<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 08.02.18
 * Time: 11:17
 */

namespace AppBundle\TaxCalculator;

class CurrencyConverter
{
    private $apiUrl = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange';

    /**
     * @param float $value
     * @param string $currencyFrom
     * @param \DateTime $date
     * @return float
     */
    public function convertToUahBasedOnNbuRate(float $value, string $currencyFrom, \DateTime $date): float
    {
        $rate = $this->getCurrencyRate($currencyFrom, $date);

        return $value * $rate;
    }

    /**
     * @param string $currency
     * @param \DateTime $date
     * @return float
     */
    public function getCurrencyRate(string $currency, \DateTime $date): float
    {
        $rate = 1;

        $queryToApi = http_build_query([
            'date' => $date->format('Ymd'),
            'json' => ''
        ]);

        $url = $this->apiUrl . '?' . $queryToApi;

        $jsonResult = json_decode(file_get_contents($url), true);

        foreach ($jsonResult as $currencyData) {
            if ($currencyData['cc'] === $currency) {
                $rate = $currencyData['rate'];
            }
        }

        return (float)$rate;
    }
}