<?php

namespace HappyOldsMainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HappyOldsMainBundle:Default:index.html.twig');
    }
}
