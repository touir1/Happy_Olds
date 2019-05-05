<?php
/**
 * Created by PhpStorm.
 * User: touir
 * Date: 01/05/2019
 * Time: 16:03
 */

namespace ChatRoomBundle\Controller;


use ChatRoomBundle\Entity\Groupe;
use ChatRoomBundle\Entity\MembreGroupe;
use HappyOldsMainBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class MembreGroupeController extends UtilsController
{
    public function __construct()
    {
        // this is an object to remove params from json when serialized

        $this->callbacks = [
            'user' => function($object){
                return $object->getId();
            },
            'groupe' => function($object){
                return $object->getId();
            },

        ];

        // this is sent to the view so that we can use the routes if we need them
        $this->routes = [
            'chat_room_member_invite',
            'chat_room_member_list_invite',
            'chat_room_member_list_members',
            'chat_room_api_member_invite',
            'chat_room_member_delete',
            'chat_room_member_bann',
            'chat_room_api_member_list_invite',
            'chat_room_api_member_list_members',
            'chat_room_api_member_delete',
            'chat_room_member_bann',
        ];

    }

    private function invite($groupe_id = null,$user_inviting_id = null, $user_invited_id = null)
    {
        if(is_null($groupe_id) || is_null($user_invited_id) ||is_null($user_inviting_id)) return;
        if($user_inviting_id == $user_invited_id) return;

        $groupeRepo = $this->getDoctrine()->getRepository(Groupe::class);

        $authorized = $groupeRepo->checkIfAuthorizedToInvite($groupe_id,$user_inviting_id);
        if($authorized)
        {
            $groupe = $groupeRepo->find($groupe_id);
            $user = $this->getDoctrine()->getRepository(User::class)
                ->find($user_invited_id);
            $member = new MembreGroupe();
            $member->setGroupe($groupe);
            $member->setUser($user);
            $member->setBanned(false);
            $member->setAuthorized(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();
        }
    }

    public function inviteAction(Request $request)
    {
        $group_id = $request->get('group_id');
        $member_id = $request->get('member_id');
        $this->invite($group_id,$this->getUser()->getId(),$member_id);

        return $this->redirectToRoute('chat_room_group_consult',[
            'id' => $group_id
        ]);
    }

    public function _inviteAction(Request $request)
    {
        $group_id = $request->get('group_id');
        $member_id = $request->get('member_id');
        $this->invite($group_id,$this->getUser()->getId(),$member_id);

        return new JsonResponse([
            "status" => "ok"
        ],JsonResponse::HTTP_ACCEPTED,[]);
    }

    private function listInvite($groupe_id = null,$user_inviting_id = null, $username = "", $nom = "", $prenom = "", $offset = 0, $maxResults = 100)
    {
        $groupeRepo = $this->getDoctrine()->getRepository(Groupe::class);

        $authorized = $groupeRepo->checkIfAuthorizedToInvite($groupe_id,$user_inviting_id);
        if($authorized)
        {
            return $this->getDoctrine()->getRepository(MembreGroupe::class)
                ->getListOfUsersToInvite($groupe_id,$username,$nom,$prenom,$offset, $maxResults);
        }
    }

    public function listInviteAction(Request $request)
    {
        $groupe_id = $request->get("groupe_id");
        $nom = $request->get("nom");
        $prenom = $request->get("prenom");
        $username = $request->get("username");

        $groupe = $this->getDoctrine()->getRepository(Groupe::class)
            ->find($groupe_id);

        if(!isset($nom)) $nom = "";
        if(!isset($prenom)) $prenom = "";
        if(!isset($username)) $username = "";

        $list = $this->listInvite($groupe_id,$this->getUser()->getId(),$username,$nom,$prenom,0, 10);

        return $this->render('@ChatRoom/Groupe/MembreGroupe/list_invite.html.twig',array(
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'groupe' => $groupe,
            'liste' => $list,
            'nom' =>$nom,
            'prenom' => $prenom,
            'username' => $username,
        ));
    }

    public function _listInviteAction(Request $request)
    {
        $groupe_id = $request->get("group_id");
        $nom = $request->get("nom");
        $prenom = $request->get("prenom");
        $username = $request->get("username");

        if(!isset($nom)) $nom = "";
        if(!isset($prenom)) $prenom = "";
        if(!isset($username)) $username = "";

        $list = $this->listInvite($groupe_id,$this->getUser()->getId(),$username,$nom,$prenom,0, 10);

        return $this->getJsonResponse($list);
    }

    private function listMembers($groupe_id = null, $username = "", $nom = "", $prenom = "", $offset = 0, $maxResults = 100)
    {
        return $this->getDoctrine()->getRepository(MembreGroupe::class)
            ->getListGroupMembers($groupe_id,$this->getUser()->getId(),$username,$nom,$prenom,$offset, $maxResults);
    }

    public function listMembersAction(Request $request)
    {
        $groupe_id = $request->get("group_id");
        $nom = $request->get("nom");
        $prenom = $request->get("prenom");
        $username = $request->get("username");

        if(!isset($nom)) $nom = "";
        if(!isset($prenom)) $prenom = "";
        if(!isset($username)) $username = "";

        $list = $this->listMembers($groupe_id,$username,$nom,$prenom,0, 10);

        $groupe = $this->getDoctrine()->getRepository(Groupe::class)
            ->find($groupe_id);

        return $this->render('@ChatRoom/Groupe/MembreGroupe/list_members.html.twig',array(
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'groupe' => $groupe,
            'liste' => $list,
            'nom' =>$nom,
            'prenom' => $prenom,
            'username' => $username,
        ));

    }

    public function _listMembersAction(Request $request)
    {
        $groupe_id = $request->get("group_id");
        $nom = $request->get("nom");
        $prenom = $request->get("prenom");
        $username = $request->get("username");

        if(!isset($nom)) $nom = "";
        if(!isset($prenom)) $prenom = "";
        if(!isset($username)) $username = "";

        $list = $this->listMembers($groupe_id,$username,$nom,$prenom,0, 10);

        return $this->getJsonResponse($list);
    }

    private function delete($groupe_id, $user_id)
    {

    }

    public function deleteAction(Request $request)
    {

    }

    public function _deleteAction(Request $request)
    {

    }

    private function bann($groupe_id, $user_id)
    {

    }

    public function bannAction(Request $request)
    {

    }

    public function _bannAction(Request $request)
    {

    }


}