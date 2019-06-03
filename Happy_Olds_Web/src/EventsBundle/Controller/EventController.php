<?php

namespace EventsBundle\Controller;

use EventsBundle\Entity\Event;
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
            $em->persist($event);
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

        $events = $em->getRepository('EventsBundle:Event')->findAll();

        return $this->render('@Events/event/voir.html.twig', array(
            'events' => $events,
        ));
    }
    public function rateAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        $rate = new Rate();

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

    public function venirAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('EventsBundle:Event')->findAll();

        return $this->render('@Events/event/venir.html.twig', array(
            'events' => $events,
        ));
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