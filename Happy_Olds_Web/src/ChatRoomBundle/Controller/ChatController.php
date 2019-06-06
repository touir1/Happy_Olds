<?php

namespace ChatRoomBundle\Controller;

use ChatRoomBundle\Entity\Groupe;
use ChatRoomBundle\Entity\Message;
use HappyOldsMainBundle\Entity\User;

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

        $groups = [];
        foreach($listeGroupes as $value)
        {
            $groups[] = $value->getId();
        }

        return $this->render( '@ChatRoom/Chat/index.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
                'user_image' => $this->getUser()->getWebPath(),
                'lastTimestamp' => $lastTimestamp,
                'currentUser' => $this->getUser()->getId(),
                'groupes' => $groups,
            ],
            'groupes' => $listeGroupes,
        ]);
    }

    private function usersList()
    {
        return $this->getDoctrine()->getRepository(User::class)
            ->findAll();
    }

    public function _usersListAction()
    {
        $users = $this->usersList();
        $result = [];

        foreach ($users as $user)
        {
            $result[] = [
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'image' => $user->getWebPath(),
                'id' => $user->getId(),
            ];
        }

        return $this->getJsonResponse($result);
    }
}
