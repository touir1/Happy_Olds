<?php

namespace HappyOldsMainBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use HappyOldsMainBundle\Entity\User;
use HappyOldsMainBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


class DefaultController extends Controller
{

    public function mainPageAction(Request $request)
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }
        return $this->render('@HappyOldsMain/Default/accueil.html.twig');
    }

    public function indexAction(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        return $this->render('@HappyOldsMain/Default/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    public function registerAction(Request $request)
    {
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = new User();
        $user->setEnabled(true);

        $form = $this->createForm(UserType::class, $user);

        $event = new GetResponseUserEvent($user, $request);

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                try{
                    $userManager->updateUser($user);
                }
                catch (\Exception $exception){
                    if(strpos($exception->getMessage(),'Integrity constraint violation')){
                        return $this->render('@HappyOldsMain/Default/register.html.twig', [
                            'form' => $form->createView(),
                            'error' => 'Compte existe déjà'
                        ]);
                    }
                }


                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('happy_olds_main_homepage');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }


        return $this->render('@HappyOldsMain/Default/register.html.twig', [
            'form' => $form->createView(),
            'error' => null
        ]);
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
