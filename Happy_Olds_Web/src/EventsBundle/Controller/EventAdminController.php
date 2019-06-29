<?php

namespace EventsBundle\Controller;

use EventsBundle\Entity\Event;
use EventsBundle\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventAdminController extends Controller
{

    public function affiche2Action (){
        $event=$this->getDoctrine()
            ->getRepository(  Event::class)
            ->findAll();
        return $this->render ('@Events/admin/affiche.html.twig' , array('liste'=>$event));
    }

    public function Action(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        $rate = new Rate();

        $form = $this->createForm(RateType::class,$rate);

        return $this->render('@Events/admin/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
            'rating_form' => $form->createView()
        ));
    }

    public function delete2Action(Request $request){
        //etape 0 :
        $id=$request->get( 'id');
        $event=$this->getDoctrine()->getRepository( Event::class)->find($id);

        $em=$this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute( 'event_affiche2');
    }


    public function show2Action (Request $request){
        //etape 0 :
        $ref=$request->get( 'id');
        $event=$this->getDoctrine()->getRepository( Event::class)->find($ref);

        //etape 1.a

        $form=$this->createForm( EventType::class,$event);
// etape 2.a
        $form=$form->handleRequest($request);
        if ($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute( 'event_affiche');
        }
        // etape 1.b
        return $this->render( '@Events/admin/show.html.twig', array(
            'event' => $event,
            'form'=>$form->createView()));

    }
}
