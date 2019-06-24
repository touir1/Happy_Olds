<?php

namespace MedicalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class apiController extends Controller
{

    public function allAction(){
        $em = $this->getDoctrine()->getManager();
        $questions=$em->getRepository('MedicalBundle:Question')->findAll();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer=new Serializer($normalizers);

        $formatted=$serializer->normalize($questions);

        return new JsonResponse($formatted);
    }
    public function findoneAction($id){
        $em = $this->getDoctrine()->getManager();
        $questions=$em->getRepository('MediacalBundle:Question')->find($id);

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer=new Serializer($normalizers);

        $formatted=$serializer->normalize($questions);

        return new JsonResponse($formatted);
    }
}
