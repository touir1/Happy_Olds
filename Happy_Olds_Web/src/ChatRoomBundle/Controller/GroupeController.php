<?php

namespace ChatRoomBundle\Controller;

use ChatRoomBundle\Entity\DiscussionGroupe;
use ChatRoomBundle\Entity\Groupe;
use ChatRoomBundle\Entity\GroupeSujet;
use ChatRoomBundle\Entity\MembreGroupe;
use ChatRoomBundle\Entity\PublicationGroupe;
use ChatRoomBundle\Form\GroupeType;
use ChatRoomBundle\Form\PublicationGroupeType;
use ChatRoomBundle\Utils\GroupeTypes;
use ChatRoomBundle\Utils\JsonEntityMapping;
use HappyOldsMainBundle\Entity\User;
use ChatRoomBundle\Utils\ChatRoomRoutes;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GroupeController extends UtilsController
{

    public function __construct()
    {
        parent::__construct();
        // this is an object to remove params from json when serialized

        $this->callbacks = [
            'members' => function($object){
                $members = [];
                $mapping = function($member){
                    return [
                        "id" => $member->getId(),
                        "banned" => $member->getBanned(),
                        "authorized" => $member->getAuthorized(),
                        "user" => [
                            "id" => $member->getUser()->getId(),
                            "nom" => $member->getUser()->getNom(),
                            "prenom" => $member->getUser()->getPrenom(),
                            "username" => $member->getUser()->getUsername(),
                            "fullName" => $member->getUser()->getFullName(),
                        ],
                        "groupe" => [
                            "id" => $member->getGroupe()->getId(),
                        ],
                    ];
                };
                return array_map($mapping,$object->getValues());

            },
            'creator' => function($object){
                return [
                    "id" => $object->getId(),
                    "nom" => $object->getNom(),
                    "prenom" => $object->getPrenom(),
                    "username" => $object->getUsername(),
                    "fullName" => $object->getFullName(),
                ];
            },
            'publications' => function($object){
                //return $object->count();
                $mapping = function($el){
                    return JsonEntityMapping::Publication($el);
                };
                return array_map($mapping,$object->getValues());
            },
            'sujet' => function($object){
                return [
                    "id" => $object->getId(),
                    "label" => $object->getLabel(),
                ];
            },
            'discussion' => function($object){
                return [
                    "id" => $object->getId(),
                ];
            }

        ];

    }

    // get list of authorized groups
    private function listAccessible($titre,$type,$sujet)
    {
        return $this->getDoctrine()
            ->getRepository(Groupe::class)
            ->findAllAccessible($this->getUser()->getId(),$titre,$type,$sujet);
    }

    // liste view
    public function listAction(Request $request)
    {
        $titre = $request->get('titre');
        $type = $request->get('type');
        $sujet = $request->get('sujet');

        if(!isset($titre) || is_null($titre)) $titre = "";
        if(!isset($type) || is_null($type)) $type="all";
        if(!isset($sujet) || is_null($sujet)) $sujet="0";

        $types = GroupeTypes::getArray();
        $sujets = $this->getDoctrine()->getRepository(GroupeSujet::class)
            ->findAll();

        $liste = $this->listAccessible($titre,$type,$sujet);
        return $this->render( '@ChatRoom/Groupe/list.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'liste' => $liste,

            'types' => $types,
            'sujets' => $sujets,
            'titre' => $titre,
            'type' => $type,
            'sujet' => $sujet,
        ]);
    }

    // liste json
    public function _listAction(Request $request)
    {
        $titre = $request->get('titre');
        $type = $request->get('type');
        $sujet = $request->get('sujet');

        if(!isset($titre) || is_null($titre)) $titre = "";
        if(!isset($type) || is_null($type)) $type="all";
        if(!isset($sujet) || is_null($sujet)) $sujet="0";
        $liste = $this->listAccessible($titre,$type,$sujet);

        return $this->getJsonResponse($liste,[]);
        //return $this->json($liste);
    }

    // get list of authorized groups
    private function myListAccessible($titre,$type,$sujet)
    {
        return $this->getDoctrine()
            ->getRepository(Groupe::class)
            ->findAllMineAccessible($this->getUser()->getId(),$titre,$type,$sujet);
    }

    // liste view
    public function myListAction(Request $request)
    {
        $titre = $request->get('titre');
        $type = $request->get('type');
        $sujet = $request->get('sujet');

        if(!isset($titre) || is_null($titre)) $titre = "";
        if(!isset($type) || is_null($type)) $type="all";
        if(!isset($sujet) || is_null($sujet)) $sujet="0";

        $types = GroupeTypes::getArray();
        $sujets = $this->getDoctrine()->getRepository(GroupeSujet::class)
            ->findAll();

        $liste = $this->myListAccessible($titre,$type,$sujet);
        return $this->render( '@ChatRoom/Groupe/my_list.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'liste' => $liste,

            'types' => $types,
            'sujets' => $sujets,
            'titre' => $titre,
            'type' => $type,
            'sujet' => $sujet,
        ]);
    }

    // liste json
    public function _myListAction(Request $request)
    {
        $titre = $request->get('titre');
        $type = $request->get('type');
        $sujet = $request->get('sujet');

        if(!isset($titre) || is_null($titre)) $titre = "";
        if(!isset($type) || is_null($type)) $type="all";
        if(!isset($sujet) || is_null($sujet)) $sujet="0";
        $liste = $this->myListAccessible($titre,$type,$sujet);

        return $this->getJsonResponse($liste,[]);
        //return $this->json($liste);
    }

    // get list of authorized groups
    private function subscribedListAccessible($titre,$type,$sujet)
    {
        return $this->getDoctrine()
            ->getRepository(Groupe::class)
            ->findSubscribedAccessible($this->getUser()->getId(),$titre,$type,$sujet);
    }

    // liste view
    public function subscribedListAction(Request $request)
    {
        $titre = $request->get('titre');
        $type = $request->get('type');
        $sujet = $request->get('sujet');

        if(!isset($titre) || is_null($titre)) $titre = "";
        if(!isset($type) || is_null($type)) $type="all";
        if(!isset($sujet) || is_null($sujet)) $sujet="0";

        $types = GroupeTypes::getArray();
        $sujets = $this->getDoctrine()->getRepository(GroupeSujet::class)
            ->findAll();

        $liste = $this->subscribedListAccessible($titre,$type,$sujet);
        return $this->render( '@ChatRoom/Groupe/subscribed_list.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'liste' => $liste,

            'types' => $types,
            'sujets' => $sujets,
            'titre' => $titre,
            'type' => $type,
            'sujet' => $sujet,
        ]);
    }

    // liste json
    public function _subscribedListAction(Request $request)
    {
        $titre = $request->get('titre');
        $type = $request->get('type');
        $sujet = $request->get('sujet');

        if(!isset($titre) || is_null($titre)) $titre = "";
        if(!isset($type) || is_null($type)) $type="all";
        if(!isset($sujet) || is_null($sujet)) $sujet="0";
        $liste = $this->subscribedListAccessible($titre,$type,$sujet);

        return $this->getJsonResponse($liste,[]);
        //return $this->json($liste);
    }

    // get element
    private function consult($groupe_id = null)
    {
        return $this->getDoctrine()->getRepository(Groupe::class)
            ->consult($groupe_id,$this->getUser()->getId());
    }

    // consult view
    public function consultAction(Request $request)
    {
        $id=$request->get('id');
        $groupe = $this->consult($id);
        $join = $this->getDoctrine()->getRepository(Groupe::class)
            ->checkIfAuthorizedToJoin($id,$this->getUser()->getId());
        $invite = $this->getDoctrine()->getRepository(Groupe::class)
            ->checkIfAuthorizedToInvite($id,$this->getUser()->getId());
        $leave = $this->getDoctrine()->getRepository(Groupe::class)
            ->checkIfAuthorizedToLeave($id,$this->getUser()->getId());
        $publish = $this->getDoctrine()->getRepository(Groupe::class)
            ->checkIfAuthorizedToPublish($id,$this->getUser()->getId());
        $seePublications = $this->getDoctrine()->getRepository(Groupe::class)
            ->checkIfAuthorizedToSeePublications($id,$this->getUser()->getId());

        $form = $this->createForm(PublicationGroupeType::class, new PublicationGroupe());

        return $this->render( '@ChatRoom/Groupe/consult.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'form' => $form->createView(),
            'groupe' => $groupe,
            'join' => $join,
            'invite' => $invite,
            'leave' => $leave,
            'publish' => $publish,
            'seePublications' => $seePublications,
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
    private function add(Groupe $groupe)
    {
        $groupe->setCreator($this->getUser());
        $member = new MembreGroupe();
        $member->setUser($this->getUser());
        $member->setAuthorized(true);
        $member->setBanned(false);
        $member->setGroupe($groupe);
        $groupe->addMember($member);
        $groupe->setDiscussion(new DiscussionGroupe());

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

            return $this->redirectToRoute(ChatRoomRoutes::chat_room_group_consult, [
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
            return $this->redirectToRoute(ChatRoomRoutes::chat_room_group_consult,[
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

        return $this->redirectToRoute(ChatRoomRoutes::chat_room_group_list);
    }

    public function _deleteAction(Request $request)
    {
        $id = $request->get('id');
        $this->delete($id);

        return new JsonResponse([
            "status" => "ok"
        ],JsonResponse::HTTP_ACCEPTED,[]);
    }

    public function join($groupe_id = null, $user_id = null)
    {
        $groupeRepo = $this->getDoctrine()->getRepository(Groupe::class);

        $authorized = $groupeRepo->checkIfAuthorizedToJoin($groupe_id,$user_id);
        if($authorized)
        {
            $groupe = $groupeRepo->find($groupe_id);
            $user = $this->getDoctrine()->getRepository(User::class)
                ->find($user_id);
            $member = new MembreGroupe();
            $member->setGroupe($groupe);
            $member->setUser($user);
            $member->setBanned(false);
            if($groupe->getType() == GroupeTypes::PublicGroup) $member->setAuthorized(true);
            else $member->setAuthorized(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();
        }
    }

    public function joinAction(Request $request)
    {
        $id = $request->get('id');
        $this->join($id, $this->getUser()->getId());

        return $this->redirectToRoute(ChatRoomRoutes::chat_room_group_consult,[
            'id' => $id
        ]);
    }

    public function _joinAction(Request $request)
    {
        $id = $request->get('id');
        $this->join($id, $this->getUser()->getId());

        return new JsonResponse([
            "status" => "ok"
        ],JsonResponse::HTTP_ACCEPTED,[]);
    }

    public function leave($groupe_id = null, $user_id = null)
    {
        $groupeRepo = $this->getDoctrine()->getRepository(Groupe::class);

        $authorized = $groupeRepo->checkIfAuthorizedToLeave($groupe_id,$user_id);
        if($authorized)
        {
            $member = $this->getDoctrine()->getRepository(MembreGroupe::class)
                ->findMember($groupe_id,$user_id);

            $em = $this->getDoctrine()->getManager();
            $em->remove($member);
            $em->flush();
        }
    }

    public function leaveAction(Request $request)
    {
        $id = $request->get('id');
        $this->leave($id, $this->getUser()->getId());

        return $this->redirectToRoute(ChatRoomRoutes::chat_room_group_list);
    }

    public function _leaveAction(Request $request)
    {
        $id = $request->get('id');
        $this->leave($id, $this->getUser()->getId());

        return new JsonResponse([
            "status" => "ok"
        ],JsonResponse::HTTP_ACCEPTED,[]);
    }


}
