<?php

namespace MedicalBundle\Controller;

use MedicalBundle\Entity\Sujet;
use MedicalBundle\Form\SujetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SujetController extends Controller
{
    public function newAction(Request $request){
        //1.a-création d'un objet vide
        $sujet=new Sujet();
        //1.b-préparer notre form
        $form=$this->createForm(SujetType::class,$sujet);
        //2.a recuperer les données
        $form=$form->handleRequest($request);
        if ($form->isValid()){
            //2.b insertion dans la BD
            $em=$this->getDoctrine()->getManager();

            $em->persist($sujet);
            $em->flush();
            return $this->redirectToRoute('sujet_show');
        }
        //1.c-affichage du form
        return $this->render( '@Medical/Sujet/new.html.twig',array(
            'form'=>$form->createView()));
    }

    public function deleteAction(Request $req)
    {
        //etape 0: recap de l'objet à modifier (on a recup par id)
        $id = $req->get('id');
        $sujet = $this->getDoctrine()->getRepository(Sujet::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($sujet);
        $em->flush();
        return $this->redirectToRoute('sujet_show');
    }

    public function updateAction(Request $req){
        //etape 0: recap de l'objet à modifier (on a recup par id)
        $id=$req->get('id');
        $sujet=$this->getDoctrine()->getRepository(Sujet::class)->find($id);
        //1.a :la préparation du formulaire
        $form =$this->createForm(SujetType::class,$sujet);
        //2.a recup des données deja modifié
        $form=$form->handleRequest($req);
        if ($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($sujet);
            $em->flush();
            return $this->redirectToRoute('sujet_show');
        }
        return $this->render('@Medical/Sujet/new.html.twig',array(
            'form'=>$form->createView(),
        ));
    }


    public function showAction(Request $request){

        $em = $this->get('doctrine.orm.entity_manager');
        $query=$em->createQuery("Select s from MedicalBundle:Sujet s");
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)/*page number*/

        );
        return $this->render('@Medical/Sujet/show.html.twig',array(
            'sujets'=>$pagination));
    }



}
