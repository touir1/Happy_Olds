<?php
/**
 * Created by PhpStorm.
 * User: touir
 * Date: 06/06/2019
 * Time: 20:31
 */

namespace ChatRoomBundle\Controller;


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

    public function messagesAction()
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        return $this->render( '@ChatRoom/Admin/messages.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
        ]);
    }

    public function publicationsAction()
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        return $this->render( '@ChatRoom/Admin/publications.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
        ]);
    }

    public function sujetsAction()
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        return $this->render( '@ChatRoom/Admin/sujets.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
        ]);
    }

    public function commentsAction()
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        return $this->render( '@ChatRoom/Admin/commentaires.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
        ]);
    }

    public function groupsAction()
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        return $this->render( '@ChatRoom/Admin/groups.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls(),
            ],
        ]);
    }

}