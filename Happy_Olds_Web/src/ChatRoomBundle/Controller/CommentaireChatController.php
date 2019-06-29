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
        parent::__construct();
        // this is an object to remove params from json when serialized
        $this->callbacks = [
            'publication' => function($obj){
                return [
                    'id' => $obj->getId()
                ];
            },
            'user' => function($object){
                return [
                    "id" => $object->getId(),
                    "nom" => $object->getNom(),
                    "prenom" => $object->getPrenom(),
                    "username" => $object->getUsername(),
                    "fullName" => $object->getFullName(),
                ];
            },
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
                    "status" => "ok",
                    "id" => $commentaire->getId(),
                ],JsonResponse::HTTP_CREATED,[]);
            }
        }
    }

    private function remove($commentaire_id)
    {
        $commentaire = $this->getDoctrine()->getRepository(CommentaireChat::class)
            ->find($commentaire_id);

        $id_publication = $commentaire->getPublication()->getId();

        if(isset($commentaire) && !is_null($commentaire))
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentaire);
            $em->flush();
        }

        return $id_publication;
    }

    public function _removeAction(Request $request)
    {
        $id = $request->get('id');
        $this->remove($id);

        return new JsonResponse([
            "status" => "ok"
        ],JsonResponse::HTTP_CREATED,[]);
    }

    public function removeAction(Request $request)
    {
        $id = $request->get('id');
        $id_publication = $this->remove($id);

        return $this->redirectToRoute(ChatRoomRoutes::chat_room_publication_consult, [
            'id' => $id_publication
        ]);
    }

    private function listComments($publicationId){
        return $this->getDoctrine()->getRepository(CommentaireChat::class)
            ->findAllComments($publicationId);
    }

    public function _listCommentsAction(Request $request){
        $index = $request->get('index');
        $pageSize = $request->get('pageSize');
        $publicationId = $request->get('publicationId');

        if(!isset($index) || is_null($index)) $index = 1;
        if(!isset($pageSize) || is_null($pageSize)) $pageSize = 10;

        $liste = $this->listComments($publicationId);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $liste,
            $request->get('page',$index),
            $pageSize
        );

        return $this->getJsonResponse($pagination,[]);
        //return $this->json($liste);
    }
}
