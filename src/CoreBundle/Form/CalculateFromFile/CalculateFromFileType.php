<?php

namespace CoreBundle\Form\CalculateFromFile;

use CoreBundle\Model\Request\CalculateFromFile\CalculateFromFileRequest;
use NorseDigital\Symfony\RestBundle\Form\AbstractFormType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Class CalculateFromFileType
 */
class CalculateFromFileType extends AbstractFormType
{
    const DATA_CLASS = CalculateFromFileRequest::class;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('file', FileType::class, [
            'by_reference' => false
        ]);
    }
}
