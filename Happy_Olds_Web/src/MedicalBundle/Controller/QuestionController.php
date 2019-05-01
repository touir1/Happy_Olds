<?php

namespace MedicalBundle\Controller;

use MedicalBundle\Entity\Question;
use MedicalBundle\Entity\Reponse;
use MedicalBundle\Form\QuestionType;
use MedicalBundle\Form\ReponseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends Controller
{
        public function affichageAction(Request $request){
        $titre=$request->get('titre');
        if (isset($titre) && !empty($titre)){
            $question=$this->getDoctrine()
                ->getRepository(Question::class)
                ->MyfindAll($titre);
            return $this->render( '@Medical/Question/affichage.html.twig',array(
                'tab'=>$question));
        }
        $rp = $this->getDoctrine()
            ->getRepository(Question::class);
        $questions=$rp->findAll();

        return $this->render('@Medical/Question/affichage.html.twig',array(
            'rp' =>$rp,
            'tab'=>$questions));
    }

         public function supprimerAction(Request $req){
        //etape 0: recap de l'objet à modifier (on a recup par id)
        $id=$req->get('id');
        $question=$this->getDoctrine()->getRepository(Question::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($question);
        $em->flush();
        return $this->redirectToRoute('medical_affichage');

    }

     public function modifierAction(Request $req){
        //etape 0: recap de l'objet à modifier (on a recup par id)
        $id=$req->get('id');
        $question=$this->getDoctrine()->getRepository(Question::class)->find($id);
        //1.a :la préparation du formulaire
        $form =$this->createForm(QuestionType::class,$question);
        //2.a recup des données deja modifié
        $form=$form->handleRequest($req);
        if ($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('medical_affichage');
        }
        return $this->render('@Medical/Question/ajouter.html.twig',array(
            'form'=>$form->createView()
        ));
    }

        public function ajouterAction(Request $request){
        //1.a-création d'un objet vide
        $question=new Question();
        //1.b-préparer notre form
        $form=$this->createForm(QuestionType::class,$question);
        //2.a recuperer les données
        $form=$form->handleRequest($request);
        if ($form->isValid()){
            //2.b insertion dans la BD
            $em=$this->getDoctrine()->getManager();
            $question->upload();
            $em->persist($question);
            $em->flush();
            return $this->redirectToRoute('medical_affichage');
        }
        //1.c-affichage du form
        return $this->render( '@Medical/Question/ajouter.html.twig',array(
            'form'=>$form->createView()));
    }

        public function afficheAction(Request $req){
    //etape 0: recap de l'objet à modifier (on a recup par id)
    $id=$req->get('id');
    $rp = $this->getDoctrine()->getRepository(Question::class);
    $question=$rp->find($id);
    $em=$this->getDoctrine()->getManager();
    $em->flush();
    //1.a-création d'un objet vide
    $reponse=new Reponse();
    //1.b-préparer notre form
    $form=$this->createForm(ReponseType::class,$reponse);
    //2.a recuperer les données
    $form=$form->handleRequest($req);
    if ($form->isValid()){
        //2.b insertion dans la BD

        $reponse->setQuestion($question);
        $em->persist($reponse);
        $em->flush();
        return $this->redirectToRoute('medical_affiche',array(
            'id' => $id
        ));
    }

    return $this->render( '@Medical/Question/affiche.html.twig',array(
        'tab'=>$question ,

        'form'=>$form->createView()
    ));
}

    public function historiqueAction(){
            $user=$this->getUser();
        $questions=$this->getDoctrine()
            ->getRepository(Question::class)->findAll($user);
        return $this->render( '@Medical/Question/historique.html.twig',array(
            'tab'=>$questions
        ));
    }



}
