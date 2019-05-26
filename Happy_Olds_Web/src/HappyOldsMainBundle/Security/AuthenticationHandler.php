<?php
/**
 * Created by PhpStorm.
 * User: touir
 * Date: 26/05/2019
 * Time: 15:07
 */

namespace HappyOldsMainBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    protected $router;
    protected $session;
    protected $authorizationChecker;

    public function __construct( RouterInterface $router, Session $session, AuthorizationChecker $authorizationChecker)
    {
        $this->router  = $router;
        $this->session = $session;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onAuthenticationFailure( Request $request, AuthenticationException $exception )
    {
        $response = new Response( json_encode( array( 'success' => false, 'message' => $exception->getMessage() ) ) );
        $response->headers->set( 'Content-Type', 'application/json' );

        return $response;
    }

    public function onAuthenticationSuccess( Request $request, TokenInterface $token )
    {
        $response = new Response( json_encode( array( 'success' => true ) ) );
        $response->headers->set( 'Content-Type', 'application/json' );

        return $response;


    }
}