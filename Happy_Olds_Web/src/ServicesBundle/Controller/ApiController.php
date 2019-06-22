<?php
/**
 * Created by PhpStorm.
 * User: SadfiAmine
 * Date: 24/05/2019
 * Time: 01:45
 */

namespace ServicesBundle\Controller;


use HappyOldsMainBundle\Entity\User;
use ServicesBundle\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiController extends Controller
{
    public function allAction(){
        $em = $this->getDoctrine()->getManager();
        $services=$em->getRepository('ServicesBundle:Service')->findAll();

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
    public function findoneAction($id){
        $em = $this->getDoctrine()->getManager();
        $services=$em->getRepository('ServicesBundle:Service')->find($id);

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

    public function fawziaction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $service = new Service();
        $date= new \DateTime();
        $service->setDate($date);
        $service->setType($request->get('type'));
        $service->setDescription($request->get('description'));
        $user=$em->getRepository(User::class)->find($request->get('user'));
        $service->setUser($user);
        $em->persist($service);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($service);
        return new JsonResponse($formatted);
    }
}