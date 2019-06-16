<?php

namespace ChatRoomBundle\Controller;

use ChatRoomBundle\Entity\PublicationGroupe;
use ChatRoomBundle\Utils\ChatRoomRoutes;

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

    public function _indexAction()
    {
        $publications = $this->getDoctrine()->getRepository(PublicationGroupe::class)
            ->findAllSubscribed($this->getUser()->getId());

        return $this->getJsonResponse($publications,[]);
    }
}
