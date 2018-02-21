<?php

namespace CoreBundle\Model\Handler;

use NorseDigital\Symfony\RestBundle\Handler\ProcessorInterface;
use CoreBundle\Model\Request\CalculateFromFile\CalculateFromFileRequest;


/**
 * Interface CalculateFromFileProcessorInterface
 */
interface CalculateFromFileProcessorInterface extends ProcessorInterface
{

    /**
     * @param CalculateFromFileRequest $request
     * @return void
     */
    public function processPost(CalculateFromFileRequest $request);

}
