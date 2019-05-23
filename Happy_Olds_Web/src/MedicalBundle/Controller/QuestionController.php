<?php

namespace MedicalBundle\Controller;

use MedicalBundle\Entity\Question;
use MedicalBundle\Entity\Reponse;
use MedicalBundle\Form\QuestionType;
use MedicalBundle\Form\ReponseType;
use SBC\NotificationsBundle\Model\NotifiableInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

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
            $question->upload();
            $em->persist($question);
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
        $question->setUser($this->getUser());
        $question->setDateQ(new \DateTime('now'));
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
        $reponse->setUser($this->getUser());
        $em->persist($reponse);
        $em->flush();
        return $this->redirectToRoute('medical_affichage',array(
            'id' => $id
        ));
    }

    return $this->render( '@Medical/Question/affiche.html.twig',array(
        'tab'=>$question ,

        'form'=>$form->createView()
    ));
}

    public function historiqueAction(Request $request)
    {
        $titre=$request->get('titre');
        $user = $this->getUser();
        if (isset($titre) && !empty($titre)){
            $question=$this->getDoctrine()
                ->getRepository(Question::class)
                ->MyfindAll($titre);
            return $this->render( '@Medical/Question/historique.html.twig',array(
                'tab'=>$question));
        }
        $rp = $this->getDoctrine()
            ->getRepository(Question::class);
        $questions=$rp->recherche($user);

        return $this->render('@Medical/Question/historique.html.twig',array(
            'rp' =>$rp,
            'tab'=>$questions));
    }

    public function detailAction(Request $req){
        $id=$req->get('id');
        $question=$this->getDoctrine()->getRepository(Question::class)->find($id);
        $list=$this->getDoctrine()
            ->getRepository(Question::class)
            ->listereponse($id);
        return $this->render( '@Medical/Question/detail.html.twig',array(
            'tab'=>$list,
            'question' =>$question));
    }


    public function listAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $query=$em->createQuery("Select q from MedicalBundle:Question q");
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)/*page number*/

        );

        return $this->render('@Medical/Question/delete.html.twig', array(
            'questions' => $pagination
        ));
    }

    public function DeleteAdmAction(Request $request){
        $id=$request->get('id');
        $question=$this->getDoctrine()->getRepository(Question::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($question);
        $em->flush();


        return $this->redirectToRoute('Question_list');
    }

}
