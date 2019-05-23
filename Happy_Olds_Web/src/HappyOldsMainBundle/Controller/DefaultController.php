<?php

namespace HappyOldsMainBundle\Controller;

use DateTime;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use HappyOldsMainBundle\Entity\User;
use HappyOldsMainBundle\Form\UserType;
use HappyOldsMainBundle\Utils\JobTypes;
use HappyOldsMainBundle\Utils\RoleTypes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function modifierAction(Request $req){
        //etape 0: recap de l'objet à modifier (on a recup par id)
        $id=$req->get('id');
        $question=$this->getDoctrine()->getRepository(Question::class)->find($id);
        //1.a :la préparation du formulaire
        $form =$this->createForm(QuestionType::class,$question);
        //2.a recup des données deja modifié
        $form=$form->handleRequest($req);
        if ($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('medical_affichage');
        }
        return $this->render('@Medical/Question/ajouter.html.twig',array(
            'form'=>$form->createView()
        ));
    }
   public function profilAction(Request $req){
    //etape 0: recap de l'objet à modifier (on a recup par id)

       //$id=$this->getUser()->getId();
    $id=$req->get('id');
    $user=$this->getDoctrine()->getRepository(User::class)->find($id);
    //1.a :la préparation du formulaire

    $form =$this->createFormBuilder($user)
        ->add('nom')
        ->add('prenom')
        ->add('date_naissance', DateType::class, array(
            'widget' => 'single_text',

            // prevents rendering it as type="date", to avoid HTML5 date pickers
            'html5' => false,

            // adds a class that can be selected in JavaScript
            'attr' => ['class' => 'js-datepicker'],
        ))
        ->add('job',ChoiceType::class, array(
            'label' => 'Travail',
            'choices' => array(
                'Medecin' => JobTypes::Medecin,
                'Ingénieur' => JobTypes::Ingenieur,
                'Autre' => JobTypes::Autre
            ),
            'required' => true,
            'multiple' => false,
            'data' => 'autre',
        ))
        ->add('ville',ChoiceType::class, array(
            'label' => 'Ville',
            'choices' => array(
                'Tunis' => 'Tunis',
                'Ariana' => 'Ariana',
                'Ben Arous' => 'Ben Arous',
                'Béja' => 'Béja',
                'Bizerte' => 'Bizerte',
                'Gabes' => 'Gabes',
                'Jandouba' => 'Jandouba',
                'Gafsa' => 'Gafsa',
                'Kairouan' => 'Kairouan',
                'kasserine' => 'kasserine',
                'Kebili' => 'Kebili',
                'La manouba' => 'La manouba',
                'le kef' => 'le kef',
                'Mahdia' => 'Mahdia',
                'Médenine' => 'Médenine',
                'Monastir' => 'Monastir',
                'Nabeul' => 'Nabeul',
                'Sfax' => 'Sfax',
                'Sidi Bouzid' => 'Sidi Bouzid',
                'Siliana' => 'Siliana',
                'Sousse' => 'Sousse',
                'Tataouine' => 'Tataouine',
                'Tozeur' => 'Tozeur',
                'Zaghouan' => 'Zaghouan',
            ),
            'required' => true,
            'multiple' => false,
            'data' => 'Tunis',
        ))
        ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
        ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
        ->add('plainPassword', RepeatedType::class, array(
            'type' => PasswordType::class,
            'options' => array(
                'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'autocomplete' => 'new-password',
                ),
            ),
            'first_options' => array('label' => 'form.password'),
            'second_options' => array('label' => 'form.password_confirmation'),
            'invalid_message' => 'fos_user.password.mismatch',
        ))

        ->add('role', ChoiceType::class, array(
            'label' => 'Type',
            'choices' => array(
                'Jeune' => RoleTypes::Jeune,
                'Agé' => RoleTypes::Age
            ),
            'required' => true,
            'multiple' => false,
            'data' => RoleTypes::Jeune,
        )) ->add('file')
        ->add('Valider',SubmitType::class)->getForm();

    //2.a recup des données deja modifié
    $form=$form->handleRequest($req);
    if ($form->isValid()){
        $em=$this->getDoctrine()->getManager();
        $user->upload();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('happy_olds_main_homepage');
    }
    return $this->render('@HappyOldsMain/Default/profil.html.twig',array(
        'form'=>$form->createView()
    ));
}
}
