<?php

namespace ChatRoomBundle\Controller;

use ChatRoomBundle\Entity\Groupe;
use ChatRoomBundle\Entity\Message;

class ChatController extends UtilsController
{

    private function listGroupsAccessible()
    {
        return $this->getDoctrine()->getRepository(Groupe::class)
            ->findAllSubscribedAccessible($this->getUser()->getId());
    }

    public function indexAction()
    {
        $listeGroupes = $this->listGroupsAccessible();
        $lastTimestamp = $this->getDoctrine()->getRepository(Message::class)
            ->getLastTimestamp();

        return $this->render( '@ChatRoom/Chat/index.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
                'user_image' => $this->getUser()->getWebPath(),
                'lastTimestamp' => $lastTimestamp,
                'currentUser' => $this->getUser()->getId(),
            ],
            'groupes' => $listeGroupes,
        ]);
    }
}
