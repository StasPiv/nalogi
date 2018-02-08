<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 08.02.18
 * Time: 11:32
 */

namespace AppBundle\TaxCalculator;


class TaxRow
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $currency = 'UAH';

    /**
     * @var float
     */
    private $value = 0;

    /**
     * @var string
     */
    private $sellDestination = '';

    /**
     * @var bool
     */
    private $freeSell = false;

    /**
     * @var bool
     */
    private $requiredSell = false;

    /**
     * @var float
     */
    private $bankRate = 1;

    /**
     * @var float
     */
    private $bankBaseValue = 0;

    /**
     * @var string
     */
    private $bankCurrency = 'USD';

    /**
     * @var float
     */
    private $nbuRate = 1;

    /**
     * TaxRow constructor.
     * @param \DateTime $date
     * @param string $currency
     * @param float $value
     * @param string $sellDestination
     * @param bool $freeSell
     */
    public function __construct(
        \DateTime $date,
        $currency,
        $value,
        $sellDestination,
        $freeSell
    ) {
        $this->date = $date;
        $this->currency = $currency;
        $this->value = $value;
        $this->sellDestination = $sellDestination;
        $this->freeSell = $freeSell;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return TaxRow
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return TaxRow
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return TaxRow
     */
    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getSellDestination(): string
    {
        return $this->sellDestination;
    }

    /**
     * @param string $sellDestination
     * @return TaxRow
     */
    public function setSellDestination(string $sellDestination): self
    {
        $this->sellDestination = $sellDestination;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFreeSell(): bool
    {
        return $this->freeSell;
    }

    /**
     * @param bool $requiredSell
     * @return TaxRow
     */
    public function setRequiredSell(bool $requiredSell): self
    {
        $this->requiredSell = $requiredSell;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequiredSell(): bool
    {
        return $this->requiredSell;
    }

    /**
     * @return float
     */
    public function getBankRate(): float
    {
        return $this->bankRate;
    }

    /**
     * @param float $bankRate
     * @return TaxRow
     */
    public function setBankRate(float $bankRate): self
    {
        $this->bankRate = $bankRate;

        return $this;
    }

    /**
     * @return float
     */
    public function getBankBaseValue(): float
    {
        return $this->bankBaseValue;
    }

    /**
     * @param float $bankBaseValue
     * @return TaxRow
     */
    public function setBankBaseValue(float $bankBaseValue): self
    {
        $this->bankBaseValue = $bankBaseValue;

        return $this;
    }

    /**
     * @return string
     */
    public function getBankCurrency(): string
    {
        return $this->bankCurrency;
    }

    /**
     * @param string $bankCurrency
     * @return TaxRow
     */
    public function setBankCurrency(string $bankCurrency): self
    {
        $this->bankCurrency = $bankCurrency;

        return $this;
    }

    /**
     * @return float
     */
    public function getNbuRate(): float
    {
        return $this->nbuRate;
    }

    /**
     * @param float $nbuRate
     * @return TaxRow
     */
    public function setNbuRate(float $nbuRate): self
    {
        $this->nbuRate = $nbuRate;

        return $this;
    }
}