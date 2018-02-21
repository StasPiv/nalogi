<?php

namespace CoreBundle\Model\Request\CalculateFromFile;

use NorseDigital\Symfony\RestBundle\Request\AbstractRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Class CalculateFromFileRequest
 */
class CalculateFromFileRequest extends AbstractRequest
{
    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @return UploadedFile
     */
    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     * @return CalculateFromFileRequest
     */
    public function setFile(UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }
}
