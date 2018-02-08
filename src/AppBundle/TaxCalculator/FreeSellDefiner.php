<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 08.02.18
 * Time: 13:23
 */

namespace AppBundle\TaxCalculator;


class FreeSellDefiner
{
    private $regExp = '/Зарах\. від вільного продажу (\d+\.\d+) (\w+) за курсом (\d+\.\d+)/';

    /**
     * @param string $sellDestination
     * @param $matches
     * @return bool
     */
    public function checkFreeSell(string $sellDestination, &$matches): bool
    {
        $result = preg_match(
            iconv('CP1251', 'UTF-8', $this->regExp),
            iconv('CP1251', 'UTF-8', $sellDestination),
            $matches
        );

        return $result;
    }
}