<?php

namespace AppBundle\Security;

use AppBundle\Form\LoginForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator{

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $em, RouterInterface $router, UserPasswordEncoderInterface $passwordEncoder){
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function getLoginUrl()    {
        return $this->router->generate('login');
    }

    public function getCredentials(Request $request)    {
        $isLoginSubmit = $request->getPathInfo() == "/login" && $request->isMethod('POST');
        if(!$isLoginSubmit) return ;

        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);
        $data = $form->getData();
        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)    {
        $username = $credentials['_username'];
        return $this->em->getRepository('AppBundle:User')
            ->findOneBy(['email' => $username]);
    }

    public function checkCredentials($credentials, UserInterface $user)    {
        $password = $credentials['_password'];
        dump('checkCredentials');
        dump($user);
        if($this->passwordEncoder->isPasswordValid($user, $password)){
            return true;
        }
        return false;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $response = new RedirectResponse($this->router->generate('admin'));
        return $response;
    }


}