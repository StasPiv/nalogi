<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 08.02.18
 * Time: 14:41
 */

namespace AppBundle\TaxCalculator;


class RequiredSellDefiner
{
    private $regExp = '/Зарахування коштів від обов\'язкового продажу (\d+\.\d+) (\w+) за курсом (\d+\.\d+)/';

    /**
     * @param string $sellDestination
     * @param $matches
     * @return bool
     */
    public function checkRequiredSell(string $sellDestination, &$matches): bool
    {
        $result = preg_match(
            iconv('CP1251', 'UTF-8', $this->regExp),
            iconv('CP1251', 'UTF-8', $sellDestination),
            $matches
        );

        return $result;
    }
}