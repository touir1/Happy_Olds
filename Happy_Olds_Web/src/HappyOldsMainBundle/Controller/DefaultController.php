<?php

namespace HappyOldsMainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@HappyOldsMain/Default/login.html.twig');
    }
    public function accueilAction()
    {
        return $this->render('@HappyOldsMain/Default/index.html.twig');
    }
}
