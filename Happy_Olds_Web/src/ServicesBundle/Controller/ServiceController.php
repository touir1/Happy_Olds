<?php

namespace ServicesBundle\Controller;

use HappyOldsMainBundle\Entity\Notification;
use HappyOldsMainBundle\Entity\User;
use ServicesBundle\Entity\CommentaireService;
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
    public function listAction(Request $request)
    {
       // $em = $this->getDoctrine()->getManager();

        //$services = $em->getRepository('ServicesBundle:Service')->findAll();
        $connected_user_role=$this->getUser()->getRole();
        if($connected_user_role=="ROLE_AGE"||$connected_user_role=="ROLE_JEUNE")

        {return $this->redirectToRoute('forbidden_403');}
        else {
            $em = $this->get('doctrine.orm.entity_manager');
            $query = $em->createQuery("Select s from ServicesBundle:Service s");
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 1)/*page number*/
            );


            return $this->render('@Services/service/delete.html.twig', array(
                'services' => $pagination
            ));
        }
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



        return $this->redirectToRoute('services_publier');
    }
    public function addComAction(Request $req){
        $commenatire=$req->get('commentaire');
        $id=$req->get('idservice');
        $service=$this->getDoctrine()->getRepository(Service::class)->find($id);
        $cs =new CommentaireService();
        $cs->setUser($this->getUser());
        $cs->setTexte($commenatire);
        $cs->setService($service);
        $em = $this->getDoctrine()->getManager();
        $em->persist($cs);
        $em->flush();
        $service->addCommentaire($cs);
        $em = $this->getDoctrine()->getManager();
        $em->persist($service);
        $em->flush();


        return $this->redirectToRoute('services_publier');
    }
    public function listcondidatAction(Request $req){
        $id=$req->get('id');
        $fromNotif=null;
        $fromNotif=$req->get('fromNotif');
        if($fromNotif!= null){
            $v=$req->get('v');
           $notif=$this->getDoctrine()->getRepository(Notification::class)->findByV($v);

            $notif->setSeen(true);
            $em=$this->getDoctrine()->getManager()->persist($notif);
            $em->flush();
            $service=$this->getDoctrine()->getRepository(Service::class)->find($id);

        }
        else{
            $service=$this->getDoctrine()->getRepository(Service::class)->find($id);

        }

       return $this->render('@Services/service/listCondidature.html.twig',array(
            'service' => $service
        ));
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

            return $this->redirectToRoute('services_publier');
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
    public function acceptcondidatAction(Request $request){

        $idservice=$request->get('idService');
        $iduser=$request->get('iduser');
        $service=$this->getDoctrine()->getRepository(Service::class)->find($idservice);
        $user=$this->getDoctrine()->getRepository(User::class)->find($iduser);
        $service->setUserAssocie($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($service);
        $em->flush();
        return $this->redirectToRoute('services_publier');
    }
    public function historyAction(Request $request){
        if($this->getUser()->getRole()=="ROLE_AGE"){
            $service=$this->getDoctrine()->getRepository(Service::class)->historiqueAge($this->getUser()->getId());

            return $this->render('@Services/service/history.html.twig',array(
                'services' => $service
            ));
        }
        else{
            $service=$this->getDoctrine()->getRepository(Service::class)->historiqueJeune($this->getUser()->getId());

            return $this->render('@Services/service/history.html.twig',array(
                'services' => $service
            ));

        }
    }

    public function evalAction(Request $request){
        $note=0;
        $idservice=$request->get('idService');
        $iduser=$request->get('iduser');
        $refNote=$request->get('id');
        if($refNote==2){
            $note=250;
        }
        elseif ($refNote==3){
            $note=500;
        }
        elseif ($refNote==4){
            $note=1000;
        }
        else{
            $note=0;
        }
        $service=$this->getDoctrine()->getRepository(Service::class)->find($idservice);
        $user=$this->getDoctrine()->getRepository(User::class)->find($iduser);
        $service->setValider("valider");
        $user->setScorefinal($user->getScorefinal()+ $note);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($service);
        $em->flush();
        return $this->redirectToRoute('services_publier');
    }
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
    public function DeleteAdmAction(Request $request){
    $id=$request->get('id');
        $service=$this->getDoctrine()->getRepository(Service::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($service);
        $em->flush();


        return $this->redirectToRoute('services_list');
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
