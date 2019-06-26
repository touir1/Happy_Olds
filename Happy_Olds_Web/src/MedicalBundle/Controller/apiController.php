<?php

namespace MedicalBundle\Controller;

use MedicalBundle\Entity\Question;
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
        $questions=$em->getRepository('MedicalBundle:Question')->find($id);

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

    public function addaction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $question = new Question();
        $date= new \DateTime();
        $question->setDateQ($date);
        $question->setSujet($request->get('sujet'));
        $question->setTitre($request->get('titre'));
        $question->setText($request->get('text'));
        $user=$em->getRepository(User::class)->find($request->get('user'));
        $question->setUser($user);
        $em->persist($question);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($question);
        return new JsonResponse($formatted);
    }
}
