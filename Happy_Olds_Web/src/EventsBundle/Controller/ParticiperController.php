<?php

namespace EventsBundle\Controller;

use EventsBundle\Entity\Participer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ParticiperController extends Controller
{

    public function participerAction(Request $request){
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $question=$em->getRepository(participer::class)
            ->find($id);
        $nbr=$question->getNbParticipants();
        $question->setParticipants($nbr+1);
        $em->flush();

        //ajout d'une reponse

        return $this->render('@Events/event/feciliter.html.twig', array('question'=>$question));
    }
}
