<?php

namespace ServicesBundle\Controller;

use ServicesBundle\Entity\Postuler;
use ServicesBundle\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Service controller.
 *
 */
class ServiceController extends Controller
{
    /**
     * Lists all service entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('ServicesBundle:Service')->findAll();

        return $this->render('@Services/service/index.html.twig', array(
            'services' => $services
        ));
    }
    public function publierAction()
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('ServicesBundle:Service')->findAll();

        return $this->render('@Services/service/publier.html.twig', array(
            'services' => $services,'user'=>$this->getUser()
        ));
    }
    public function postulerAction(Request $req){
        $id=$req->get('id');

        $service=$this->getDoctrine()->getRepository(Service::class)->find($id);
        $postuler= new Postuler();
        $postuler->setUser($this->getUser());
        $postuler->setService($service);
        $em = $this->getDoctrine()->getManager();
        $em->persist($postuler);
        $em->flush();
       $service->addPostuler($postuler);
        $em = $this->getDoctrine()->getManager();
        $em->persist($service);
        $em->flush();
        foreach ($service->getPostuler()->toArray() as $dept){
            print ((string)$dept->getId());
        }



        //return $this->redirectToRoute('services_publier');
    }

    /**
     * Creates a new service entity.
     *
     */
    public function newAction(Request $request)
    {
        $service = new Service();
        $form = $this->createForm('ServicesBundle\Form\ServiceType', $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('services_show', array('id' => $service->getId()));
        }

        return $this->render('@Services/service/new.html.twig', array(
            'service' => $service,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a service entity.
     *
     */
    public function showAction(Service $service)
    {
        $deleteForm = $this->createDeleteForm($service);

        return $this->render('@Services/service/show.html.twig', array(
            'service' => $service,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing service entity.
     *
     */
    public function editAction(Request $request, Service $service)
    {
        $deleteForm = $this->createDeleteForm($service);
        $editForm = $this->createForm('ServicesBundle\Form\ServiceType', $service);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('services_publier', array('id' => $service->getId()));
        }

        return $this->render('@Services/service/edit.html.twig', array(
            'service' => $service,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a service entity.
     *
     */
    public function deleteAction(Request $request)
    {   $id=$request->get('id');
        $service=$this->getDoctrine()->getRepository(Service::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($service);
        $em->flush();


        return $this->redirectToRoute('services_publier');
    }

    /**
     * Creates a form to delete a service entity.
     *
     * @param Service $service The service entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Service $service)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('services_delete', array('id' => $service->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
