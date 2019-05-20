<?php

namespace ChatRoomBundle\Controller;


use ChatRoomBundle\Entity\Groupe;
use ChatRoomBundle\Entity\PublicationGroupe;
use ChatRoomBundle\Entity\PublicationPieceJointe;
use ChatRoomBundle\Form\PublicationGroupeType;
use ChatRoomBundle\Form\PublicationPieceJointeType;
use Symfony\Component\HttpFoundation\Request;

class PublicationGroupeController extends UtilsController
{

    public function __construct()
    {
        // this is an object to remove params from json when serialized
        $this->callbacks = [

        ];

        // this is sent to the view so that we can use the routes if we need them
        $this->routes = [

        ];

    }

    private function add(PublicationGroupe $publication)
    {
        $publication->setUser($this->getUser());
        $publication->setDatePublication(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($publication);

        $uploadableManager = $this->container->get('stof_doctrine_extensions.uploadable.manager');

        $uploadableManager->markEntityToUpload($publication->getPieceJointe(), $publication->getPieceJointe()->file);


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

            return $this->redirectToRoute('chat_room_group_consult', [
                'id' => $groupe->getId()
            ]);

        }

        return $this->redirectToRoute('forbidden_403');

        //var_dump($publication_text);
        //var_dump($piece_jointe);

    }

    public function _addAction(Request $request)
    {

    }
}
