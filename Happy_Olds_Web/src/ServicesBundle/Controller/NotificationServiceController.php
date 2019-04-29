<?php

namespace ServicesBundle\Controller;

use ServicesBundle\Entity\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Notificationservice controller.
 *
 */
class NotificationServiceController extends Controller
{
    /**
     * Lists all notificationService entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notificationServices = $em->getRepository('ServicesBundle:NotificationService')->findAll();

        return $this->render('@Services/notificationservice/index.html.twig', array(
            'notificationServices' => $notificationServices,
        ));
    }

    /**
     * Creates a new notificationService entity.
     *
     */
    public function newAction(Request $request)
    {
        $notificationService = new Notificationservice();
        $form = $this->createForm('ServicesBundle\Form\NotificationServiceType', $notificationService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notificationService);
            $em->flush();

            return $this->redirectToRoute('services_notification_show', array('id' => $notificationService->getId()));
        }

        return $this->render('@Services/notificationservice/new.html.twig', array(
            'notificationService' => $notificationService,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a notificationService entity.
     *
     */
    public function showAction(NotificationService $notificationService)
    {
        $deleteForm = $this->createDeleteForm($notificationService);

        return $this->render('@Services/notificationservice/show.html.twig', array(
            'notificationService' => $notificationService,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing notificationService entity.
     *
     */
    public function editAction(Request $request, NotificationService $notificationService)
    {
        $deleteForm = $this->createDeleteForm($notificationService);
        $editForm = $this->createForm('ServicesBundle\Form\NotificationServiceType', $notificationService);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('services_notification_edit', array('id' => $notificationService->getId()));
        }

        return $this->render('@Services/notificationservice/edit.html.twig', array(
            'notificationService' => $notificationService,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a notificationService entity.
     *
     */
    public function deleteAction(Request $request, NotificationService $notificationService)
    {
        $form = $this->createDeleteForm($notificationService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notificationService);
            $em->flush();
        }

        return $this->redirectToRoute('services_notification_index');
    }

    /**
     * Creates a form to delete a notificationService entity.
     *
     * @param NotificationService $notificationService The notificationService entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NotificationService $notificationService)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('services_notification_delete', array('id' => $notificationService->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
