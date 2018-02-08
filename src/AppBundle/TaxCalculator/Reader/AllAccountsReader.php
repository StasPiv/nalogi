<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 08.02.18
 * Time: 11:25
 */

namespace AppBundle\TaxCalculator\Reader;

use AppBundle\TaxCalculator\CurrencyConverter;
use AppBundle\TaxCalculator\FreeSellDefiner;
use AppBundle\TaxCalculator\Reader;
use AppBundle\TaxCalculator\RequiredSellDefiner;
use AppBundle\TaxCalculator\TaxRow;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class AllAccountsReader implements Reader
{
    const CREDIT_FIELD_NAME = 'Кредит';
    const DATE_FIELD_NAME = 'Дата операції';
    const CURRENCY_FIELD_NAME = 'Валюта';
    const SELL_DESTINATION_FIELD_NAME = 'Призначення платежу';

    /**
     * @var FreeSellDefiner
     */
    private $freeSellDefiner;

    /**
     * @var RequiredSellDefiner
     */
    private $requiredSellDefiner;

    /**
     * @var CurrencyConverter
     */
    private $currencyConverter;

    /**
     * AllAccountsReader constructor.
     * @param FreeSellDefiner $freeSellDefiner
     * @param RequiredSellDefiner $requiredSellDefiner
     * @param CurrencyConverter $currencyConverter
     */
    public function __construct(
        FreeSellDefiner $freeSellDefiner,
        RequiredSellDefiner $requiredSellDefiner,
        CurrencyConverter $currencyConverter
    ) {
        $this->freeSellDefiner = $freeSellDefiner;
        $this->requiredSellDefiner = $requiredSellDefiner;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * @param mixed $source
     * @return Collection|TaxRow[]
     */
    function parseSource($source): Collection
    {
        if (!is_string($source)) {
            throw new \RuntimeException('source must be string - path of file');
        }

        if (!file_exists($source)) {
            throw new \RuntimeException($source . ' doesn\'t exist');
        }

        $fh = fopen($source, 'r+');

        $taxRows = new ArrayCollection();

        $header = $this->parseCsvRow($fh);

        foreach ([self::CREDIT_FIELD_NAME, self::DATE_FIELD_NAME, self::CURRENCY_FIELD_NAME, self::SELL_DESTINATION_FIELD_NAME] as $requiredField) {
            if (!in_array($requiredField, $header)) {
                throw new \RuntimeException($requiredField . ' is missing in header');
            }
        }

        while ($csvRow = $this->parseCsvRow($fh)) {
            $namedRow = array_combine($header, $csvRow);

            $credit = (float)$namedRow[self::CREDIT_FIELD_NAME];

            if ($credit == 0) {
                continue;
            }

            $freeSell = $this->freeSellDefiner->checkFreeSell($namedRow[self::SELL_DESTINATION_FIELD_NAME], $matches);

            $taxRow = new TaxRow(
                new \DateTime($namedRow[self::DATE_FIELD_NAME]),
                $namedRow[self::CURRENCY_FIELD_NAME],
                $credit,
                $namedRow[self::SELL_DESTINATION_FIELD_NAME],
                $freeSell
            );


            if ($freeSell) {
                $taxRow->setBankBaseValue((float)$matches[1])
                       ->setBankCurrency((string)$matches[2])
                       ->setBankRate((float)$matches[3] / 100);
            }

            $requiredSell = $this->requiredSellDefiner
                ->checkRequiredSell($namedRow[self::SELL_DESTINATION_FIELD_NAME], $matches);

            if ($requiredSell) {
                $taxRow->setRequiredSell(true)
                    ->setBankBaseValue((float)$matches[1])
                    ->setBankCurrency((string)$matches[2])
                    ->setBankRate((float)$matches[3] / 100);
            }

            $taxRow->setNbuRate(
                $this->currencyConverter->getCurrencyRate(
                    $taxRow->getBankCurrency(),
                    $taxRow->getDate()
                )
            );

            $taxRows->add($taxRow);
        }

        return $taxRows;
    }

    /**
     * @param $fh
     * @return array|bool
     */
    private function parseCsvRow($fh)
    {
        $getCsvResult = fgetcsv($fh, 1024, ';');

        if (!$getCsvResult) {
            return false;
        }

        return $this->convertToUtf8($getCsvResult);
    }

    /**
     * @param $row
     *
     * @return array
     */
    private function convertToUtf8($row): array
    {
        if (!is_array($row)) {
            throw new \RuntimeException('row is not array: ' . json_encode($row));
        }

        foreach ($row as &$value) {
            $value = iconv('CP1251', 'UTF-8', $value);
        }

        return $row;
    }

}