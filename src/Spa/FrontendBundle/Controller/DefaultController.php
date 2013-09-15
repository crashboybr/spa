<?php

namespace Spa\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SpaFrontendBundle:Default:index.html.twig');
    }
}
