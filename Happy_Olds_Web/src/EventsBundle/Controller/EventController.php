<?php

namespace EventsBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use EventsBundle\Entity\Event;
use EventsBundle\Entity\Participer;
use EventsBundle\Entity\Rate;
use EventsBundle\Form\RateType;
use HappyOldsMainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{
    /**
     * Lists all event entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('EventsBundle:Event')->findAll();

        return $this->render('@Events/event/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Creates a new event entity.
     *
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('EventsBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $event->setIdUser($this->getUser());
            $event->upload();
            $event->setParticipant(0);
            $em->persist($event);
            $event->setNbrDispo($event->getNbrParticipant());
            $em->flush();

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('@Events/event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a event entity.
     *
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        $rate = new Rate();

        $form = $this->createForm(RateType::class,$rate);

        return $this->render('@Events/event/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
            'rating_form' => $form->createView()
        ));
    }

    public function voirAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('EventsBundle:Event')
            ->participedIn($this->getUser()->getId());


        return $this->render('@Events/event/voir.html.twig', array(
            'events' => $events,
        ));
    }
    public function rateAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        $rate = $this->getDoctrine()->getRepository(Rate::class)
            ->findOneBy(['user' => $this->getUser(),'event' => $event]);

        //var_dump($rate);
        //die();

        if(!isset($rate) || is_null($rate)){
            $rate = new Rate();
        }

        $form = $this->createForm(RateType::class,$rate);

        return $this->render('@Events/event/rate.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
            'rating_form' => $form->createView()
        ));
    }
    /**
     * Displays a form to edit an existing event entity.
     *
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('EventsBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_edit', array('id' => $event->getId()));
        }

        return $this->render('@Events/event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    public function afficheAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository(Event::class)
            ->myfindall($this->getUser()->getId());

        return $this->render('@Events/event/affiche.html.twig', array(
            'events' => $events,
        ));
    }
    public function participerAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()->getRepository(Event::class)
            ->find($id);
        $event->setNbrDispo($event->getNbrDispo()-1);
        $event->setParticipant($event->getParticipant() + 1);
        $em->persist($event);
        $Participer = new Participer();

        $Participer->setUser($this->getUser());
        $Participer->setEvent($event);
        $em->persist($Participer);
        $em->flush();

        return $this->redirectToRoute('event_show',array('id'=>$event->getId()));
    }
    public function annulerAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()->getRepository(Event::class)
            ->find($id);
        $event->setNbrDispo($event->getNbrDispo()+1);
        $event->setParticipant($event->getParticipant() - 1);
        $em->persist($event);
        $Participer = new Participer();

        $Participer->getUser($this->getUser());
        $Participer->getEvent($event);
       // $Participer->getId();
        $em->remove($Participer);
        $em->persist($Participer);
        $em->flush();

        return $this->redirectToRoute('event_show',array('id'=>$event->getId()));
    }

    public function venirAction()
    {
        $em = $this->getDoctrine()->getManager();

       // $events = $em->getRepository('EventsBundle:Event')->findAll();
        $events = $em->getRepository('EventsBundle:Event')
            ->participIn($this->getUser()->getId());

        return $this->render('@Events/event/venir.html.twig', array(
            'events' => $events,
        ));

    }

    public function show4Action(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        $rate = new Rate();

        $form = $this->createForm(RateType::class,$rate);

        return $this->render('@Events/event/show4.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
            'rating_form' => $form->createView()
        ));
    }

    public function delete3Action(Request $request){
        //etape 0 :
        $id=$request->get( 'id');
        $event=$this->getDoctrine()->getRepository( Event::class)->find($id);

        $em=$this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute( 'event_affiche');
    }



        /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
