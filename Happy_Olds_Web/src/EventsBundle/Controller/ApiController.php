<?php
/**
 * Created by PhpStorm.
 * User: Romdhani
 * Date: 26/06/2019
 * Time: 11:35 PM
 */

namespace EventsBundle\Controller;


use EventsBundle\Entity\Event;
use HappyOldsMainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiController extends Controller
{
public function allAction(){
    $em = $this->getDoctrine()->getManager();
    $events = $em->getRepository('EventsBundle:Event')->findAll();
    $normalizer = new ObjectNormalizer();
    $normalizer->setCircularReferenceLimit(1);
    $normalizer->setCircularReferenceHandler(function ($object){
        return $object->getId();
    });
     $normalizers =  array($normalizer);
    $serializer=new Serializer($normalizers);

    $formatted=$serializer->normalize($events);

    return new JsonResponse($formatted);
}

    public function addAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $event = new Event();
        $event->setTitre($request->get('titre'));
        $event->setNbrParticipant($request->get('nbrParticipant'));
        $event->setNbrDispo($event->getNbrParticipant());
        $event->setParticipant(0);
        $event->setLieu($request->get('privilege'));
        $event->setVille($request->get('ville'));
        $datedeb = new \DateTime();
        $datedeb->setDate($request->get('deb_year'),$request->get('deb_month'),$request->get('deb_day'));
        $datedeb->setTime($request->get('deb_hours'),$request->get('deb_minutes'),$request->get('deb_seconds'));
        $event->setDateDebut($datedeb);
        $datefin = new \DateTime();
        $datefin->setDate($request->get('fin_year'),$request->get('fin_month'),$request->get('fin_day'));
        $datefin->setTime($request->get('fin_hours'),$request->get('fin_minutes'),$request->get('fin_seconds'));
        $event->setDateFin($datefin);
        $event->setDescription($request->get('description'));
        $user=$em->getRepository(User::class)->find($request->get('user'));
        $event->setIdUser($user);
        $em->persist($event);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($event);
        return new JsonResponse($formatted);
    }

}