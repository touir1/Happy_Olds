<?php

namespace ChatRoomBundle\Controller;

use ChatRoomBundle\Entity\Groupe;
use Symfony\Component\HttpFoundation\Request;

class GroupeController extends UtilsController
{

    public function __construct()
    {
        $this->callbacks = [
            'members' => function($object){
                return $object->count();
            },
            'creator' => function($object){
                return $object->getId();
            }
        ];

        $this->routes = [
            'chat_room_group_consult',
            'chat_room_group_list',
            'chat_room_api_group_list',
            'chat_room_api_group_consult',
        ];

    }

    private function liste()
    {
        return $this->getDoctrine()
            ->getRepository(Groupe::class)
            ->findAllAccessible($this->getUser()->getId());
    }

    public function listeAction()
    {
        $liste = $this->liste();
        return $this->render( '@ChatRoom/Groupe/liste.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'liste' => $liste
        ]);
    }

    public function _listeAction()
    {
        $liste = $this->liste();

        return $this->getJsonResponse($liste,[]);
        //return $this->json($liste);
    }

    private function consult($id = null)
    {
        return $this->getDoctrine()->getRepository(Groupe::class)
            ->find($id);
    }

    public function consultAction(Request $request)
    {
        $id=$request->get('id');
        $groupe = $this->consult($id);

        return $this->render( '@ChatRoom/Groupe/consult.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'groupe' => $groupe
        ]);
    }


    public function _consultAction(Request $request)
    {
        $id=$request->get('id');
        $groupe = $this->consult($id);

        return $this->getJsonResponse($groupe,[]);
    }
}
