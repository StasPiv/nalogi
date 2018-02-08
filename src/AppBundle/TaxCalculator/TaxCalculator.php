<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 08.02.18
 * Time: 11:16
 */

namespace AppBundle\TaxCalculator;


use Doctrine\Common\Collections\ArrayCollection;

class TaxCalculator
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var CurrencyConverter
     */
    private $currencyConverter;

    /**
     * TaxCalculator constructor.
     * @param Reader $reader
     * @param CurrencyConverter $currencyConverter
     */
    public function __construct(Reader $reader, CurrencyConverter $currencyConverter)
    {
        $this->reader = $reader;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * @param mixed $source
     * @param \DateTime $from
     * @param \DateTime $to
     * @return float
     */
    public function calculate($source, \DateTime $from, \DateTime $to): float
    {
        $taxRows = $this->reader->parseSource($source);

        /** @var TaxRow[] $taxRowValues */
        $taxRowValues = $taxRows->getValues();
        usort(
            $taxRowValues, function (TaxRow $taxRowA, TaxRow $taxRowB)
        {
            return $taxRowA->getDate() <=> $taxRowB->getDate();
        });

        $value = 0;

        foreach ($taxRowValues as $taxRow) {
            if ($taxRow->isFreeSell()) {
                $bankValue = $taxRow->getBankBaseValue() * $taxRow->getBankRate();

                $nbuValue = $this->currencyConverter->convertToUahBasedOnNbuRate(
                    $taxRow->getBankBaseValue(),
                    $taxRow->getBankCurrency(),
                    $taxRow->getDate()
                );

                $rowValue = $taxRow->getBankRate() - $taxRow->getNbuRate() >= 0 ? $bankValue - $nbuValue : 0;

                $formula = sprintf(
                    'Свободная продажа %f %s. Курс банка %f, курс НБУ %f. По курсу банка: %f UAH. По курсу НБУ: %f UAH. Прибыль: %f UAH',
                    $taxRow->getBankBaseValue(),
                    $taxRow->getBankCurrency(),
                    $taxRow->getBankRate(),
                    $taxRow->getNbuRate(),
                    $bankValue,
                    $nbuValue,
                    $rowValue
                );
            } elseif ($taxRow->isRequiredSell()) {
                $rowValue = $this->currencyConverter->convertToUahBasedOnNbuRate(
                    $taxRow->getBankBaseValue(),
                    $taxRow->getBankCurrency(),
                    $taxRow->getDate()
                );

                $formula = sprintf(
                    'Обязательная продажа %f %s по курсу НБУ %f. Прибыль: %f UAH',
                    $taxRow->getBankBaseValue(),
                    $taxRow->getBankCurrency(),
                    $taxRow->getNbuRate(),
                    $rowValue
                );
            } else {
                $rowValue = $this->currencyConverter->convertToUahBasedOnNbuRate(
                    $taxRow->getValue(),
                    $taxRow->getCurrency(),
                    $taxRow->getDate()
                );

                $formula = sprintf(
                    'На валютный счет %f %s по курсу НБУ %f. Прибыль: %f UAH',
                    $taxRow->getValue(),
                    $taxRow->getCurrency(),
                    $taxRow->getNbuRate(),
                    $rowValue
                );
            }

            echo implode(
                '|',
                [
                    $taxRow->getDate()->format('Y-m-d'),
                    $taxRow->getCurrency(),
//                    $taxRow->getSellDestination(),
                    $formula
                ]
            ) . PHP_EOL;

            $value += $rowValue;
        }

        return $value;
    }
}