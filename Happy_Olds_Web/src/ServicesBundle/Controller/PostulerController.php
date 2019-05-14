<?php

namespace ServicesBundle\Controller;

use ServicesBundle\Entity\Postuler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Postuler controller.
 *
 */
class PostulerController extends Controller
{
    /**
     * Lists all postuler entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $postulers = $em->getRepository('ServicesBundle:Postuler')->findAll();

        return $this->render('@Services/postuler/index.html.twig', array(
            'postulers' => $postulers,
        ));
    }

    /**
     * Creates a new postuler entity.
     *
     */
    public function newAction(Request $request)
    {
        $postuler = new Postuler();
        $form = $this->createForm('ServicesBundle\Form\PostulerType', $postuler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postuler);
            $em->flush();

            return $this->redirectToRoute('services_postuler_show', array('id' => $postuler->getId()));
        }

        return $this->render('@Services/postuler/new.html.twig', array(
            'postuler' => $postuler,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a postuler entity.
     *
     */
    public function showAction(Postuler $postuler)
    {
        $deleteForm = $this->createDeleteForm($postuler);

        return $this->render('@Services/postuler/show.html.twig', array(
            'postuler' => $postuler,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing postuler entity.
     *
     */
    public function editAction(Request $request, Postuler $postuler)
    {
        $deleteForm = $this->createDeleteForm($postuler);
        $editForm = $this->createForm('ServicesBundle\Form\PostulerType', $postuler);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('services_postuler_edit', array('id' => $postuler->getId()));
        }

        return $this->render('@Services/postuler/edit.html.twig', array(
            'postuler' => $postuler,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a postuler entity.
     *
     */
    public function deleteAction(Request $request)
    {
            $id=$request->get('id');
             $postuler=$this->getDoctrine()->getRepository(Postuler::class)->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($postuler);
            $em->flush();


        return $this->redirectToRoute('services_condidat',array('id'=>$request->get('idService')));
    }


    /**
     * Creates a form to delete a postuler entity.
     *
     * @param Postuler $postuler The postuler entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Postuler $postuler)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('services_postuler_delete', array('id' => $postuler->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
