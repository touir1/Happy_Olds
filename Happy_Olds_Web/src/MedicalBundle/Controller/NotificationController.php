<?php

namespace MedicalBundle\Controller;

use MedicalBundle\Entity\NotificationMedical;
use MedicalBundle\MedicalBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationController extends Controller
{
  public function displayAction(){
      $notification=$this->getDoctrine()->getManager()->getRepository(NotificationMedical::class)->findAll();
      return $this->render('@Medical/Question/notification.html.twig',
          array('notifications'=>$notification));
  }
}
