<?php

namespace HappyOldsMainBundle\Controller;

use DateTime;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use HappyOldsMainBundle\Entity\Notification;
use HappyOldsMainBundle\Entity\User;
use HappyOldsMainBundle\Form\UserType;
use HappyOldsMainBundle\Utils\JobTypes;
use HappyOldsMainBundle\Utils\RoleTypes;
use MedicalBundle\Entity\NotificationMedical;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;


class DefaultController extends Controller
{

    public function mainPageAction(Request $request)
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }
        if( $this->isGranted('IS_AUTHENTICATED_FULLY') ){
            if($this->isGranted('ROLE_ADMIN')){
                return $this->redirectToRoute('happy_olds_main_admin');
            }
            else
            {
                return $this->redirectToRoute('happy_olds_main_homepage');
            }
        }
        else{
            return $this->render('@HappyOldsMain/Default/accueil.html.twig');
        }
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

    public function _registerAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');

        $post = $request->request;

        $email = $post->get('email');
        $username = $post->get('user');
        $password = $post->get('password');

        $nom = $post->get('nom');
        $prenom = $post->get('prenom');
        $date_naissance = DateTime::createFromFormat("Y-m-d",$post->get('date_naissance'));
        $job = $post->get('job');
        $role = $post->get('role');


        $email_exist = $userManager->findUserByEmail($email);
        $username_exist = $userManager->findUserByUsername($username);

        if($email_exist || $username_exist){
            $response = new JsonResponse();
            $response->setData("Username/Email ".$username."/".$email." existent déjà");
            return $response;
        }

        $user = $userManager->createUser();
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setDateNaissance($date_naissance);
        $user->setJob($job);
        $user->setRole($role);
        $user->setUsername($username);
        $user->setEmail($email);

        if(!$this->validateUserData($user)){
            $response = new JsonResponse();
            $response->setData("Données/format incorrectes");
            return $response;
        }

        $user->setLocked(false);
        $user->setEnabled(true);
        $user->setPlainPassword($password);
        $userManager->updateUser($user, true);

        $response = new JsonResponse();
        $response->setData("User: ".$user->getUsername()." ajouté");
        return $response;
    }

    public function _loginAction(Request $request)
    {
        $_username = $request->get("username");
        $_password = $request->get("password");

        // Retrieve the security encoder of symfony
        $factory = $this->get('security.encoder_factory');

        /// Start retrieve user
        // Let's retrieve the user by its username:
        // If you are using FOSUserBundle:
        $user_manager = $this->get('fos_user.user_manager');
        $user = $user_manager->findUserByUsername($_username);
        // Or by yourself
        $user = $this->getDoctrine()->getManager()->getRepository("HappyOldsMainBundle:User")
            ->findOneBy(array('username' => $_username));
        /// End Retrieve user

        // Check if the user exists !
        if(!$user){
            return new Response(
                'Username doesnt exists',
                Response::HTTP_UNAUTHORIZED,
                array('Content-type' => 'application/json')
            );
        }

        /// Start verification
        $encoder = $factory->getEncoder($user);
        $salt = $user->getSalt();

        if(!$encoder->isPasswordValid($user->getPassword(), $_password, $salt)) {
            return new Response(
                'Username or Password not valid.',
                Response::HTTP_UNAUTHORIZED,
                array('Content-type' => 'application/json')
            );
        }
        /// End Verification

        // The password matches ! then proceed to set the user in session

        //Handle getting or creating the user entity likely with a posted form
        // The third parameter "main" can change according to the name of your firewall in security.yml
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);

        // If the firewall name is not main, then the set value would be instead:
        // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
        $this->get('session')->set('_security_main', serialize($token));

        // Fire the login event manually
        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

        /*
         * Now the user is authenticated !!!!
         * Do what you need to do now, like render a view, redirect to route etc.
         */

        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);

    }

    private function validateUserData(User $user)
    {
        if(!in_array($user->getJob(),JobTypes::getArray())){
            return false;
        }
        if(!in_array($user->getRole(),RoleTypes::getArray())){
            return false;
        }
        if(is_null($user->getNom())){} return false;
        if(is_null($user->getPrenom())) return false;
        if(is_null($user->getDateNaissance())) return false;

        return true;
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

    public function error403Action()
    {
        return $this->render('@HappyOldsMain/UtilityPages/403.html.twig');
    }
    public function getnotificationAction(){
        $notification=$this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        return $this->render('@HappyOldsMain/default/notif.html.twig',
            array('notifications'=>$notification));


    }
}
