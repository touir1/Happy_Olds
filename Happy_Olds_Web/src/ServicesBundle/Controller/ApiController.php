<?php
/**
 * Created by PhpStorm.
 * User: SadfiAmine
 * Date: 24/05/2019
 * Time: 01:45
 */

namespace ServicesBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiController extends Controller
{
    public function allAction(){
        $em = $this->getDoctrine()->getManager();
        $services=$em->getRepository('ServicesBundle:Service')->find('3');

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer=new Serializer($normalizers);

        $formatted=$serializer->normalize($services);

        return new JsonResponse($formatted);
    }
}