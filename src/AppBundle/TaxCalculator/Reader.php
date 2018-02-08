<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 08.02.18
 * Time: 11:16
 */

namespace AppBundle\TaxCalculator;

use Doctrine\Common\Collections\Collection;

interface Reader
{
    /**
     * @param mixed $source
     * @return Collection|TaxRow[]
     */
    function parseSource($source): Collection;
}