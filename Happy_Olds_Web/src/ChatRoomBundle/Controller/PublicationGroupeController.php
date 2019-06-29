<?php

namespace ChatRoomBundle\Controller;


use ChatRoomBundle\Entity\Groupe;
use ChatRoomBundle\Entity\PublicationGroupe;
use ChatRoomBundle\Entity\PublicationPieceJointe;
use ChatRoomBundle\Form\PublicationGroupeType;
use ChatRoomBundle\Form\PublicationPieceJointeType;
use ChatRoomBundle\Utils\ChatRoomRoutes;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PublicationGroupeController extends UtilsController
{

    public static function getJsonDataMapping(){
        return [
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
                if (!isset($object) ||is_null($object)) return null;
                return [
                    "id" => $object->getId(),
                    "realName" => $object->getRealName(),
                    "webPath" => $object->getWebPath(),
                    "mimeType" => $object->getMimeType(),
                ];
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

    public function __construct()
    {
        parent::__construct();
        // this is an object to remove params from json when serialized
        $this->callbacks = self::getJsonDataMapping();

    }

    public function consult($publication_id = null)
    {
        return $this->getDoctrine()->getRepository(PublicationGroupe::class)
            ->findAccessible($publication_id, $this->getUser()->getId());
    }

    public function consultAction(Request $request)
    {
        $id_publication = $request->get('id');

        $publication = $this->consult($id_publication);

        return $this->render( '@ChatRoom/Groupe/PublicationGroupe/consult.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'publication' => $publication,
        ]);
    }

    public function _consultAction(Request $request)
    {
        $id_publication = $request->get('id');

        $publication = $this->consult($id_publication);

        return $this->getJsonResponse($publication,[]);
    }

    private function add(PublicationGroupe $publication)
    {
        $publication->setUser($this->getUser());
        $publication->setDatePublication(new \DateTime());

        if(!is_null($publication->getPieceJointe()) && !is_null($publication->getPieceJointe()->getFileOriginalName()))
        {
            $publication->getPieceJointe()->setRealName($publication->getPieceJointe()->getFileOriginalName());

        }
        else
        {
            $publication->setPieceJointe(null);
        }


        $em = $this->getDoctrine()->getManager();
        $em->persist($publication);



        if(!is_null($publication->getPieceJointe()) && !is_null($publication->getPieceJointe()->getFileOriginalName()))
        {
            $uploadableManager = $this->container->get('stof_doctrine_extensions.uploadable.manager');
            $uploadableManager->markEntityToUpload($publication->getPieceJointe(), $publication->getPieceJointe()->file);
        }

        $em->flush();
    }

    public function addAction(Request $request)
    {
        $groupe_id = $request->get('id');

        //var_dump($groupe_id);
        //die();

        $publication = new PublicationGroupe();
        $form = $this->createForm(PublicationGroupeType::class, $publication);
        $form->handleRequest($request);

        $groupe = $this->getDoctrine()->getRepository(Groupe::class)
            ->consult($groupe_id,$this->getUser()->getId());

        if ($form->isSubmitted() && $form->isValid())
        {

            $publication->setGroupe($groupe);

            $this->add($publication);

            return $this->redirectToRoute(ChatRoomRoutes::chat_room_group_consult, [
                'id' => $groupe->getId()
            ]);

        }

        return $this->redirectToRoute('forbidden_403');

        //var_dump($publication_text);
        //var_dump($piece_jointe);

    }

    public function _addAction(Request $request)
    {
        $groupe_id = $request->get('groupe');

        $publication = new PublicationGroupe();
        $publication->setDescription($request->get('description'));
        $publication->setUser($this->getUser());
        $publication->setDatePublication(new \DateTime());
        $groupe = $this->getDoctrine()->getRepository(Groupe::class)
            ->consult($groupe_id,$this->getUser()->getId());
        $publication->setGroupe($groupe);

        //$publication = $this->getObjectFromRequest($request,PublicationGroupe::class);
        //var_dump($publication);
        //die();

        /*
        $groupe = $this->getDoctrine()->getRepository(Groupe::class)
            ->consult($groupe_id,$this->getUser()->getId());
        */

        //if(isset($groupe) && !is_null($groupe) && isset($publication) && !is_null($publication))
        if(isset($publication) && !is_null($publication))
        {
            //$publication->setGroupe($groupe);
            $publication->setUser($this->getUser());

            $this->add($publication);

            return new JsonResponse([
                "status" => "ok"
            ],JsonResponse::HTTP_ACCEPTED,[]);
        }

        return new JsonResponse([
            "status" => "ko"
        ],JsonResponse::HTTP_BAD_REQUEST,[]);

    }

    private function delete($id_publication  = null)
    {
        $publication = $this->getDoctrine()->getRepository(PublicationGroupe::class)
            ->find($id_publication);

        $groupe_id = null;

        if(isset($publication) && !is_null($publication))
        {
            $groupe_id = $publication->getGroupe()->getId();

            if ($this->getUser()->getId() == $publication->getUser()->getId()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($publication);
                $em->flush();
            }
        }

        return $groupe_id;
    }

    public function deleteAction(Request $request)
    {
        $id_publication = $request->get('id');

        $id_groupe = $this->delete($id_publication);

        $index = $request->get('index');

        if(isset($index))
        {
            return $this->redirectToRoute(ChatRoomRoutes::chat_room_homepage);
        }

        return $this->redirectToRoute(ChatRoomRoutes::chat_room_group_consult,[
            'id' => $id_groupe
        ]);

    }

    public function _deleteAction(Request $request)
    {
        $id_publication = $request->get('id');

        $this->delete($id_publication);

        return new JsonResponse([
            "status" => "ok"
        ],JsonResponse::HTTP_ACCEPTED,[]);
    }

    private function update(PublicationGroupe $publication)
    {
        $publication->setDatePublication(new \DateTime());

        if(!is_null($publication->getPieceJointe()->getFileOriginalName()))
        {
            $publication->getPieceJointe()->setRealName($publication->getPieceJointe()->getFileOriginalName());
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($publication);
        $em->flush();

        $uploadableManager = $this->container->get('stof_doctrine_extensions.uploadable.manager');

        if(!is_null($publication->getPieceJointe()->getFileOriginalName()))
        {
            $uploadableManager->markEntityToUpload($publication->getPieceJointe(), $publication->getPieceJointe()->file);
        }


        $em->flush();
    }

    public function updateAction(Request $request)
    {
        $publication_id = $request->get('id');

        //var_dump($groupe_id);
        //die();

        $publication = $this->getDoctrine()->getRepository(PublicationGroupe::class)
            ->find($publication_id);
        $form = $this->createForm(PublicationGroupeType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->update($publication);

            return $this->redirectToRoute(ChatRoomRoutes::chat_room_publication_consult, [
                'id' => $publication->getId()
            ]);

        }

        return $this->render( '@ChatRoom/Groupe/PublicationGroupe/update.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
            'form' => $form->createView(),
            'publication' => $publication,
        ]);

        //var_dump($publication_text);
        //var_dump($piece_jointe);

    }

    public function _updateAction(Request $request)
    {
        $publication = $this->getObjectFromRequest($request,PublicationGroupe::class);

        if(isset($groupe) && !is_null($groupe) && isset($publication) && !is_null($groupe))
        {

            $this->add($publication);

            return new JsonResponse([
                "status" => "ok"
            ],JsonResponse::HTTP_ACCEPTED,[]);
        }

        return new JsonResponse([
            "status" => "ko"
        ],JsonResponse::HTTP_BAD_REQUEST,[]);

    }

}
