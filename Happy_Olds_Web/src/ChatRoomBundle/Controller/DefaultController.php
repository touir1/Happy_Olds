<?php

namespace ChatRoomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@ChatRoom/Default/index.html.twig');
    }
}
