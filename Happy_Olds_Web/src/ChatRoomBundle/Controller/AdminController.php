<?php
/**
 * Created by PhpStorm.
 * User: touir
 * Date: 06/06/2019
 * Time: 20:31
 */

namespace ChatRoomBundle\Controller;


use ChatRoomBundle\Entity\CommentaireChat;
use ChatRoomBundle\Entity\Groupe;
use ChatRoomBundle\Entity\GroupeSujet;
use ChatRoomBundle\Entity\Message;
use ChatRoomBundle\Entity\PublicationGroupe;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends UtilsController
{
    public function indexAction()
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        return $this->render( '@ChatRoom/Admin/index.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
        ]);
    }

    public function messageGroupeConsultAction(Request $request)
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        $id = $request->get('id');

        $groupe = $this->getDoctrine()->getRepository(Groupe::class)
            ->find($id);

        $paginator = $this->get('knp_paginator');

        $filter = $request->get('filter','');

        $pagination = $paginator->paginate(
            $this->getMessageQuery($filter,$id),
            $request->get('page',1),
            10
        );

        return $this->render( '@ChatRoom/Admin/messageGroupe.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
            'pagination' => $pagination,
            'groupe' => $groupe,
            'filter' => $filter
        ]);
    }

    public function messagesAction(Request $request)
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        $paginator = $this->get('knp_paginator');

        $filter = $request->get('filter','');

        $pagination = $paginator->paginate(
            $this->getMessageQuery($filter),
            $request->get('page',1),
            10
        );

        return $this->render( '@ChatRoom/Admin/messages.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
            'pagination' => $pagination,
            'filter' => $filter
        ]);
    }

    public function publicationsAction(Request $request)
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        $paginator = $this->get('knp_paginator');

        $filter = $request->get('filter','');

        $pagination = $paginator->paginate(
            $this->getPublicationQuery($filter),
            $request->get('page',1),
            10
        );

        return $this->render( '@ChatRoom/Admin/publications.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
            'pagination' => $pagination,
            'filter' => $filter
        ]);
    }

    public function sujetsAction(Request $request)
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        $filter = $request->get('filter','');

        $sujets = $this->getSujetQuery($filter);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $sujets,
            $request->get('page',1),
            10
        );

        return $this->render( '@ChatRoom/Admin/sujets.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
            'pagination' => $pagination,
            'filter' => $filter
        ]);
    }

    public function updateSujetAction(Request $request)
    {
        $id = $request->get('id');
        $label = $request->get('label');

        $sujet = $this->getDoctrine()->getRepository(GroupeSujet::class)
            ->find($id);

        $sujet->setLabel($label);

        $em = $this->getDoctrine()->getManager();

        $em->persist($sujet);
        $em->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    public function commentsAction(Request $request)
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        $paginator = $this->get('knp_paginator');

        $filter = $request->get('filter','');

        $pagination = $paginator->paginate(
            $this->getCommentaireQuery($filter),
            $request->get('page',1),
            10
        );

        return $this->render( '@ChatRoom/Admin/commentaires.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
            'pagination' => $pagination,
            'filter' => $filter
        ]);
    }

    public function consultGroupAction(Request $request)
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        $id = $request->get('id');

        $groupe = $this->getDoctrine()->getRepository(Groupe::class)
            ->find($id);

        $paginator = $this->get('knp_paginator');

        $filter = $request->get('filter','');

        $pagination = $paginator->paginate(
            $this->getPublicationQuery($filter,$id),
            $request->get('page',1),
            10
        );

        return $this->render( '@ChatRoom/Admin/group.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
            'pagination' => $pagination,
            'groupe' => $groupe,
            'filter' => $filter
        ]);
    }



    public function consultPublicationAction(Request $request)
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        $id = $request->get('id');

        $publication = $this->getDoctrine()->getRepository(PublicationGroupe::class)
            ->find($id);

        $paginator = $this->get('knp_paginator');

        $filter = $request->get('filter','');

        $pagination = $paginator->paginate(
            $this->getCommentaireQuery($filter,$id),
            $request->get('page',1),
            10
        );

        return $this->render( '@ChatRoom/Admin/publication.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
            'pagination' => $pagination,
            'publication' => $publication,
            'filter' => $filter
        ]);
    }

    public function deleteGroupAction(Request $request)
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $groupe = $this->getDoctrine()->getRepository(Groupe::class)
            ->find($id);

        $em->remove($groupe);
        $em->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    public function deleteMessageAction(Request $request)
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $message = $this->getDoctrine()->getRepository(Message::class)
            ->find($id);

        $em->remove($message);
        $em->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    public function deletePublicationAction(Request $request)
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $publication = $this->getDoctrine()->getRepository(PublicationGroupe::class)
            ->find($id);

        $em->remove($publication);
        $em->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    public function deleteSujetAction(Request $request)
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $sujet = $this->getDoctrine()->getRepository(GroupeSujet::class)
            ->find($id);

        $em->remove($sujet);
        $em->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    public function groupsAction(Request $request)
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        $filter = $request->get('filter','');

        $groups = $this->getGroupQuery($filter);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $groups,
            $request->get('page',1),
            10
        );

        return $this->render( '@ChatRoom/Admin/groups.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
            'pagination' => $pagination,
            'filter' => $filter
        ]);
    }


    public function commentaireDeleteAction(Request $request)
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $commentaire = $this->getDoctrine()->getRepository(CommentaireChat::class)
            ->find($id);

        $em->remove($commentaire);
        $em->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    private function getPublicationQuery($filter,$group = 0)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT p FROM ChatRoomBundle:PublicationGroupe p WHERE p.description LIKE :filter "
            ."AND (:groupe = 0 OR p.groupe = :groupe)";
        return $em->createQuery($dql)
            ->setParameter(':filter',"%".$filter."%")
            ->setParameter(':groupe',$group);
    }

    private function getSujetQuery($filter)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT s FROM ChatRoomBundle:GroupeSujet s WHERE s.label LIKE :filter ";
        return $em->createQuery($dql)
            ->setParameter(':filter',"%".$filter."%");
    }

    private function getMessageQuery($filter,$group = 0)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT m FROM ChatRoomBundle:Message m "
            ."JOIN m.discussion d "
            ."JOIN d.groupe g "
            ."WHERE m.texte LIKE :filter "
            ."AND (:groupe = 0 OR g.id = :groupe)";
        return $em->createQuery($dql)
            ->setParameter(':filter',"%".$filter."%")
            ->setParameter(':groupe',$group);
    }

    private function getCommentaireQuery($filter,$publication=0)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT c FROM ChatRoomBundle:CommentaireChat c WHERE c.texte LIKE :filter "
            ."AND (:publication = 0 OR c.publication = :publication)";
        return $em->createQuery($dql)
            ->setParameter(':filter',"%".$filter."%")
            ->setParameter(':publication',$publication);
    }

    private function getGroupQuery($filter)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT g FROM ChatRoomBundle:Groupe g WHERE g.titre LIKE :filter";
        return $em->createQuery($dql)->setParameter(':filter',"%".$filter."%");
    }


    public function addSujetAction(Request $request)
    {
        $label = $request->get('label');

        $sujet = new GroupeSujet();
        $sujet->setLabel($label);

        $em = $this->getDoctrine()->getManager();

        $em->persist($sujet);
        $em->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

}