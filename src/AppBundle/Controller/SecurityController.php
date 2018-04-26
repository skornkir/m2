<?php

//https://dreamguys.co.in/smarthr/orange/index.html
namespace AppBundle\Controller;

use AppBundle\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)    {
        $errors = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginForm::class,[
           '_username' => $lastUsername,
        ]);
        return $this->render('@App/SecurityController/login.html.twig', array(
            'form' => $form->createView(),
            'error' => $errors,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(){

    }

}
