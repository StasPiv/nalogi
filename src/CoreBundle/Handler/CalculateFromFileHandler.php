<?php

namespace CoreBundle\Handler;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use CoreBundle\Model\Handler\CalculateFromFileProcessorInterface;
use CoreBundle\Model\Request\CalculateFromFile\CalculateFromFileRequest;


/**
 * Class CalculateFromFileHandler
 */
class CalculateFromFileHandler implements ContainerAwareInterface, CalculateFromFileProcessorInterface
{
    use ContainerAwareTrait;


    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param ContainerInterface $container
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(ContainerInterface $container, EventDispatcherInterface $eventDispatcher)
    {
        $this->setContainer($container);
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param CalculateFromFileRequest $request
     * @return array
     */
    public function processPost(CalculateFromFileRequest $request)
    {
        $fileName = $request->getFile()->getPath()
            .DIRECTORY_SEPARATOR.$request->getFile()->getBasename();

        $output = '';
        $result = $this->container->get('tax_calculator')->calculate($fileName, $output);

        return [
            'output' => $output,
            'total' => number_format($result, 2, '.', ' '),
            'tax' => number_format($result * 0.05, 2, '.', ' ')
        ];
    }

}
