<?php

namespace EventsBundle\Controller;

use blackknight467\StarRatingBundle\Form\RatingType;
use EventsBundle\Entity\Event;
use EventsBundle\Entity\Rate;
use EventsBundle\Form\RateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RateController extends Controller
{

    public function ajoutAction(Request $request )
    {
        $id = $request->get('id');
        $event = $this->getDoctrine()->getRepository(Event::class)
            ->find($id);
        $rate = $this->getDoctrine()->getRepository(Rate::class)
            ->findOneBy(['user' => $this->getUser(),'event' => $event]);

        //var_dump($rate);
        //die();

        if(!isset($rate) || is_null($rate)){
            $rate = new Rate();
        }
        //$rate = new Rate();
        $form=$this->createForm( RateType::class,$rate);
        $form=$form->handleRequest($request);
        if ($form->isValid()){
            $rate->setUser($this->getUser());

            $rate->setEvent($event);
            $em=$this->getDoctrine()->getManager();
            $em->persist($rate);
            $em->flush();
            return $this->redirectToRoute('event_voir');
        }
        return $this->render('@Events/event/voir.html.twig');
    }
}
