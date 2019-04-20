<?php

namespace HappyOldsMainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@HappyOldsMain/Default/login.html.twig');
    }
    public function registerAction()
    {
        return $this->render('@HappyOldsMain/Default/register.html.twig');
    }
    public function accueilAction()
    {
        return $this->render('@HappyOldsMain/Default/index.html.twig');
    }
    public function accueiljeuneAction()
    {
        return $this->render('@HappyOldsMain/Default/indexjeune.html.twig');
    }
    public function accueiladminAction()
    {
        return $this->render('@HappyOldsMain/Default/indexadmin.html.twig');
    }
}
