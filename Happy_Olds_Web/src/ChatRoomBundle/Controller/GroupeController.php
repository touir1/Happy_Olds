<?php

namespace ChatRoomBundle\Controller;

use ChatRoomBundle\Entity\Groupe;
use ChatRoomBundle\Entity\MembreGroupe;
use ChatRoomBundle\Form\GroupeType;
use ChatRoomBundle\Utils\GroupeTypes;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GroupeController extends UtilsController
{

    public function __construct()
    {
        // this is an object to remove params from json when serialized
        $this->callbacks = [
            'members' => function($object){
                return $object->count();
            },
            'creator' => function($object){
                return $object->getId();
            },
            'publications' => function($object){
                return $object->count();
            }
        ];

        // this is sent to the view so that we can use the routes if we need them
        $this->routes = [
            'chat_room_group_consult',
            'chat_room_group_list',
            'chat_room_group_add',
            'chat_room_group_update',
            'chat_room_api_group_list',
            'chat_room_api_group_consult',
            'chat_room_api_group_add',
            'chat_room_api_group_update',
        ];

    }

    // get list of authorized groups
    private function listAccessible()
    {
        return $this->getDoctrine()
            ->getRepository(Groupe::class)
            ->findAllAccessible($this->getUser()->getId());
    }

    // liste view
    public function listAction()
    {
        $liste = $this->listAccessible();
        return $this->render( '@ChatRoom/Groupe/list.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'liste' => $liste
        ]);
    }

    // liste json
    public function _listAction()
    {
        $liste = $this->listAccessible();

        return $this->getJsonResponse($liste,[]);
        //return $this->json($liste);
    }

    // get element
    private function consult($groupe_id = null)
    {
        return $this->getDoctrine()->getRepository(Groupe::class)
            ->find($groupe_id);
    }

    // consult view
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

    // consult json
    public function _consultAction(Request $request)
    {
        $id=$request->get('id');
        $groupe = $this->consult($id);

        return $this->getJsonResponse($groupe,[]);
    }

    // add
    public function add($groupe)
    {
        $groupe->setCreator($this->getUser());
        $member = new MembreGroupe();
        $member->setUser($this->getUser());
        $member->setAuthorized(true);
        $member->setBanned(false);
        $member->setGroupe($groupe);
        $groupe->addMember($member);

        $em = $this->getDoctrine()->getManager();
        $em->persist($groupe);
        $em->flush();
    }

    // add view
    public function addAction(Request $request)
    {

        $groupe = new Groupe();
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->add($groupe);

            return $this->redirectToRoute('chat_room_group_consult', [
                'id' => $groupe->getId()
            ]);
        }

        return $this->render( '@ChatRoom/Groupe/add.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }

    // add json
    public function _addAction(Request $request)
    {
        $groupe = $this->getObjectFromRequest($request,Groupe::class);

        $this->add($groupe);

        return new JsonResponse([
            "status" => "ok"
        ],JsonResponse::HTTP_CREATED,[]);
    }

    // update
    private function update($groupe)
    {
        $oldGroupe = $this->consult($groupe->getId());
        if(!isset($oldGroupe) || is_null($oldGroupe)) return;

        $old_creator = $oldGroupe->getCreator()->getId();

        if($old_creator != $this->getUser()->getId()) return;
        if($groupe->getCreator()->getId() != $old_creator) return;

        $doctrineManager = $this->getDoctrine()->getManager();
        $doctrineManager->persist($groupe);
        $doctrineManager->flush();
    }

    // update view
    public function updateAction(Request $request)
    {
        $id = $request->get('id');
        $groupe = $this->consult($id);

        $form = $this->createForm(GroupeType::class, $groupe);
        $form = $form->handleRequest($request);

        if($form->isValid())
        {
            $this->update($groupe);
            return $this->redirectToRoute('chat_room_group_consult',[
                'id'=>$groupe->getId()
            ]);
        }
        return $this->render('@ChatRoom/Groupe/update.html.twig',array(
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'groupe' => $groupe,
            'form' => $form->createView()
        ));
    }

    // update api
    public function _updateAction(Request $request)
    {
        $groupe = $this->getObjectFromRequest($request,Groupe::class);
        $this->update($groupe);

        return new JsonResponse([
            "status" => "ok"
        ],JsonResponse::HTTP_ACCEPTED,[]);

    }

    private function delete($groupe_id = null)
    {
        $groupe = $this->getDoctrine()
            ->getRepository(Groupe::class)
            ->find($groupe_id);

        if($groupe->getCreator()->getId() != $this->getUser()->getId()) return;

        $doctrineManager = $this->getDoctrine()->getManager();

        $doctrineManager->remove($groupe);

        $doctrineManager->flush();
    }

    public function deleteAction(Request $request)
    {
        $id = $request->get('id');
        $this->delete($id);

        return $this->redirectToRoute('chat_room_group_list');
    }

    public function _deleteAction(Request $request)
    {
        $id = $request->get('id');
        $this->delete($id);

        return new JsonResponse([
            "status" => "ok"
        ],JsonResponse::HTTP_ACCEPTED,[]);
    }
}
