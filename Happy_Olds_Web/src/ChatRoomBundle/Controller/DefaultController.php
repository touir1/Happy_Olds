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
}
