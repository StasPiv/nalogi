<?php

namespace ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use NorseDigital\Symfony\RestBundle\Controller\BaseController;
use NorseDigital\Symfony\RestBundle\Handler\ProcessorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use CoreBundle\Form\CalculateFromFile\CalculateFromFileType;
use FOS\RestBundle\Controller\Annotations;


/**
 * Class CalculateFromFileController
 *
 * @RouteResource ("CalculateFromFile")
 */
class CalculateFromFileController extends BaseController
{

    /**
     * @ApiDoc (
     *   resource = true,
     *   section = "CalculateFromFile",
     *   description = "Get CalculateFromFile",
     *   input = {
     *      "class" = "CoreBundle\Form\CalculateFromFile\CalculateFromFileType",
     *      "name" = "",
     *   },
     *   statusCodes = {
     *      "200" = "Ok",
     *      "204" = "CalculateFromFile not found",
     *      "400" = "Bad format",
     *      "403" = "Forbidden",
     *   },
     * )
     * @Annotations\Post("/calculate-from-file")
     *
     * @param Request $request
     * @return Response
     */
    public function postAction(Request $request): Response
    {
         return $this->process($request, CalculateFromFileType::class);
    }

    /**
     * @return ProcessorInterface
     */
    public function getProcessor(): ProcessorInterface
    {
        return $this->get('core.handler.calculate_from_file');
    }

}
