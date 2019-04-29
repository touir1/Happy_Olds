<?php
/**
 * Created by PhpStorm.
 * User: touir
 * Date: 29/04/2019
 * Time: 15:14
 */

namespace ChatRoomBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UtilsController extends Controller
{
    protected $callbacks;
    protected $routes;

    protected function getJsonResponse($object, $context = [])
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCallbacks($this->callbacks);
        $serializer = new Serializer([
            new DateTimeNormalizer(),
            new ArrayDenormalizer(),
            $normalizer,
        ], [new JsonEncoder()]);

        return new JsonResponse($serializer->serialize($object,'json',$context),200,[],true);
    }

    protected function getListOfUrls($routes = [])
    {
        $result = [];
        foreach ($routes as $route){
            $result[$route] = $this->generateUrl($route);
        }
        return $result;
    }

    protected function getRoutesAsUrls()
    {
        return $this->getListOfUrls($this->routes);
    }
}