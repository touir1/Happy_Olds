<?php

namespace MedicalBundle\Controller;

use MedicalBundle\Entity\Reponse;
use MedicalBundle\Form\ReponseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReponseController extends Controller
{
    public function deleteAction(Request $req){
        //etape 0: recap de l'objet à modifier (on a recup par id)
        $id=$req->get('id');
        $reponse=$this->getDoctrine()->getRepository(Reponse::class)->find($id);
        $idQuestion = $reponse->getQuestion()->getId();
        $em=$this->getDoctrine()->getManager();
        $em->remove($reponse);
        $em->flush();
        return $this->redirectToRoute('medical_detail',[
            'id' => $idQuestion
            ]);

    }

    public function updateAction(Request $req){
        //etape 0: recap de l'objet à modifier (on a recup par id)
        $id=$req->get('id');
        $reponse=$this->getDoctrine()->getRepository(Reponse::class)->find($id);
        //1.a :la préparation du formulaire
        $form =$this->createForm(ReponseType::class,$reponse);
        //2.a recup des données deja modifié
        $form=$form->handleRequest($req);
        if ($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('medical_detail');
        }
        return $this->render('@Medical/Question/reponse.html.twig',array(
            'form'=>$form->createView(),
            'question' => $reponse->getQuestion()
        ));
    }
}
