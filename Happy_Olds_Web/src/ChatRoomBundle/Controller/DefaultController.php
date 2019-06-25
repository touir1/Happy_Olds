<?php

namespace ChatRoomBundle\Controller;

use ChatRoomBundle\Entity\PublicationGroupe;
use ChatRoomBundle\Utils\ChatRoomRoutes;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends UtilsController
{
    public function __construct()
    {
        parent::__construct();
        // this is an object to remove params from json when serialized
        $this->callbacks = [
            'groupe' => function($object){
                return [
                    "id" => $object->getId(),
                    "titre" => $object->getTitre(),
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
            'pieceJointe' => function($object){
                if(!is_null($object)){
                    return [
                        "id" => $object->getId(),
                        "realName" => $object->getRealName(),
                        "webPath" => $object->getWebPath(),
                        "mimeType" => $object->getMimeType(),
                    ];
                }
                else{
                    return null;
                }

            },
            'commentaires' => function($o){
                $mapping = function($el){
                    return [
                        "id" => $el->getId(),
                        "texte" => $el->getTexte(),
                        "dateCommentaire" => $el->getDateCommentaire(),
                    ];
                };
                return array_map($mapping,$o->getValues());
            }
        ];

    }

    public function indexAction()
    {
        $publications = $this->getDoctrine()->getRepository(PublicationGroupe::class)
            ->findAllSubscribed($this->getUser()->getId());

        return $this->render('@ChatRoom/Default/index.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'publications' => $publications,
        ]);
    }

    public function _indexAction(Request $request)
    {
        $index = $request->get('index');
        $pageSize = $request->get('page_size');

        if(!isset($index) || is_null($index)) $index = 1;
        if(!isset($pageSize) || is_null($pageSize)) $pageSize = 10;


        $publications = $this->getDoctrine()->getRepository(PublicationGroupe::class)
            ->findAllSubscribed($this->getUser()->getId());

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $publications,
            $request->get('page',$index),
            $pageSize
        );

        return $this->getJsonResponse($pagination,[]);
    }

    public function _indexGroupeAction(Request $request)
    {
        $index = $request->get('index');
        $pageSize = $request->get('page_size');
        $groupe = $request->get('groupe');

        if(!isset($index) || is_null($index)) $index = 1;
        if(!isset($pageSize) || is_null($pageSize)) $pageSize = 10;


        $publications = $this->getDoctrine()->getRepository(PublicationGroupe::class)
            ->findByGroupAccessible($groupe,$this->getUser()->getId());

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $publications,
            $request->get('page',$index),
            $pageSize
        );

        return $this->getJsonResponse($pagination,[]);
    }
}
