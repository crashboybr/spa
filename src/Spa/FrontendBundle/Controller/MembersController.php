<?php

namespace Spa\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Spa\BackendBundle\Entity\Unit;
use Spa\BackendBundle\Entity\Post;
use Symfony\Component\Security\Core\SecurityContext;

class MembersController extends Controller
{
    public function indexAction()
    {
    	
        return $this->render('SpaFrontendBundle:Members:index.html.twig');
    }
    

   
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('SpaFrontendBundle:Members:login.html.twig', array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            ));
    }
}
