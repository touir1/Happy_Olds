<?php

namespace ChatRoomBundle\Controller;

use ChatRoomBundle\Entity\CommentaireChat;
use ChatRoomBundle\Entity\PublicationGroupe;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommentaireChatController extends UtilsController
{

    public function __construct()
    {
        // this is an object to remove params from json when serialized
        $this->callbacks = [

        ];

        // this is sent to the view so that we can use the routes if we need them
        $this->routes = [
            'chat_room_api_comment_add'
        ];

    }

    private function add(CommentaireChat $commentaire)
    {
        $commentaire->setUser($this->getUser());
        $commentaire->setDateCommentaire(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($commentaire);
        $em->flush();
    }

    public function _addAction(Request $request)
    {
        $texte = $request->get('commentaire');
        $publication_id = $request->get('publication');

        //var_dump($texte);
        //var_dump($publication_id);
        //die();

        if(isset($texte) && !is_null($texte) && isset($publication_id) && !is_null($publication_id))
        {
            $publication = $this->getDoctrine()->getRepository(PublicationGroupe::class)
                ->find($publication_id);

            if(isset($publication) && !is_null($publication))
            {
                $commentaire = new CommentaireChat();
                $commentaire->setTexte($texte);
                $commentaire->setPublication($publication);

                $this->add($commentaire);

                return new JsonResponse([
                    "status" => "ok"
                ],JsonResponse::HTTP_CREATED,[]);
            }
        }
    }
}
