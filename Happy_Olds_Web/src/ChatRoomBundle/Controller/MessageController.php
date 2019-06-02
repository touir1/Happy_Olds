<?php

namespace ChatRoomBundle\Controller;

use ChatRoomBundle\Entity\Groupe;
use ChatRoomBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends UtilsController
{
    public function __construct()
    {
        parent::__construct();
        // this is an object to remove params from json when serialized
        $this->callbacks = [
            'user' => function($object){
                return [
                    "id" => $object->getId(),
                    "nom" => $object->getNom(),
                    "prenom" => $object->getPrenom(),
                    "image" => $object->getWebPath(),
                ];
            },
            'discussion' => function($object){
                return [
                    "groupe_id" => $object->getGroupe()->getId(),
                    "groupe_titre" => $object->getGroupe()->getTitre(),
                ];
            },
        ];
    }


    private function getLastTimestamp()
    {
        return $this->getDoctrine()->getRepository(Message::class)
            ->getLastTimestamp();
    }

    public function _getLastTimestampAction()
    {
        $response = ['timestamp' => $this->getLastTimestamp()];
        return $this->getJsonResponse($response);
    }

    private function allMessages()
    {
        return $this->getDoctrine()->getRepository(Message::class)
            ->allMessages($this->getUser()->getId());
    }

    public function _allMessagesAction()
    {
        return $this->getJsonResponse(
            $this->allMessages()
        );
    }

    private function allMessagesByGroupe($groupe_id)
    {
        return $this->getDoctrine()->getRepository(Message::class)
            ->allMessagesByGroupe($this->getUser()->getId(),$groupe_id);
    }


    public function _allMessagesByGroupeAction(Request $request)
    {
        $groupe_id = $request->get('groupe');

        return $this->getJsonResponse(
            $this->allMessagesByGroupe($groupe_id)
        );
    }


    private function newMessages($timestamp)
    {
        return $this->getDoctrine()->getRepository(Message::class)
            ->newMessages($this->getUser()->getId(),$timestamp);
    }

    public function _newMessagesAction(Request $request)
    {
        $timestamp = $request->get('timestamp');

        return $this->getJsonResponse(
            $this->newMessages($timestamp)
        );
    }

    private function newMessagesByGroupe($groupe_id,$timestamp)
    {
        return $this->getDoctrine()->getRepository(Message::class)
            ->newMessagesByGroupe($this->getUser()->getId(),$groupe_id,$timestamp);
    }

    public function _newMessagesByGroupeAction(Request $request)
    {
        $groupe_id = $request->get('groupe');
        $timestamp = $request->get('timestamp');

        return $this->getJsonResponse(
            $this->newMessagesByGroupe($groupe_id,$timestamp)
        );
    }

    private function send($texte, $groupe_id)
    {
        $groupe = $this->getDoctrine()->getRepository(Groupe::class)
            ->find($groupe_id);

        $message = new Message();
        $message->setTexte($texte);
        $message->setDiscussion($groupe->getDiscussion());
        $message->setUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();
    }

    public function _sendAction(Request $request)
    {
        $texte = $request->get('texte');
        $groupe_id = $request->get('groupe');

        $this->send($texte,$groupe_id);

        return new JsonResponse([
            "status" => "ok"
        ],JsonResponse::HTTP_CREATED,[]);
    }

}
