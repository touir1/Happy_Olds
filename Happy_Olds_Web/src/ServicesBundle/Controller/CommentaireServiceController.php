<?php

namespace ServicesBundle\Controller;

use ServicesBundle\Entity\CommentaireService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commentaireservice controller.
 *
 */
class CommentaireServiceController extends Controller
{
    /**
     * Lists all commentaireService entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentaireServices = $em->getRepository('ServicesBundle:CommentaireService')->findAll();

        return $this->render('@Services/commentaireservice/index.html.twig', array(
            'commentaireServices' => $commentaireServices,
        ));
    }

    /**
     * Creates a new commentaireService entity.
     *
     */
    public function newAction(Request $request)
    {
        $commentaireService = new Commentaireservice();
        $form = $this->createForm('ServicesBundle\Form\CommentaireServiceType', $commentaireService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaireService);
            $em->flush();

            return $this->redirectToRoute('services_commentaire_show', array('id' => $commentaireService->getId()));
        }

        return $this->render('@Services/commentaireservice/new.html.twig', array(
            'commentaireService' => $commentaireService,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commentaireService entity.
     *
     */
    public function showAction(CommentaireService $commentaireService)
    {
        $deleteForm = $this->createDeleteForm($commentaireService);

        return $this->render('@Services/commentaireservice/show.html.twig', array(
            'commentaireService' => $commentaireService,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentaireService entity.
     *
     */
    public function editAction(Request $request, CommentaireService $commentaireService)
    {
        $deleteForm = $this->createDeleteForm($commentaireService);
        $editForm = $this->createForm('ServicesBundle\Form\CommentaireServiceType', $commentaireService);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('services_commentaire_edit', array('id' => $commentaireService->getId()));
        }

        return $this->render('@Services/commentaireservice/edit.html.twig', array(
            'commentaireService' => $commentaireService,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commentaireService entity.
     *
     */
    public function deleteAction(Request $request, CommentaireService $commentaireService)
    {
        $form = $this->createDeleteForm($commentaireService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentaireService);
            $em->flush();
        }

        return $this->redirectToRoute('services_commentaire_index');
    }

    /**
     * Creates a form to delete a commentaireService entity.
     *
     * @param CommentaireService $commentaireService The commentaireService entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CommentaireService $commentaireService)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('services_commentaire_delete', array('id' => $commentaireService->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
