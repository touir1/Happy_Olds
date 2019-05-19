<?php

namespace ChatRoomBundle\Controller;

class DefaultController extends UtilsController
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

    public function indexAction()
    {
        return $this->render('@ChatRoom/Default/index.html.twig',[
            'data' => [
                'routes' => $this->getRoutesAsUrls()
            ],
        ]);
    }
}
