<?php

namespace Spa\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
		$featured_video = $em->getRepository('SpaBackendBundle:Video')
            ->findOneBy(array('featured' => 1));
        
        return $this->render('SpaFrontendBundle:Default:index.html.twig', array('featured_video' => $featured_video));
    }
    public function productAction()
    {
    	$em = $this->getDoctrine()->getManager();
		$products = $em->getRepository('SpaBackendBundle:Product')
            ->findAll();
   
    	return $this->render('SpaFrontendBundle:Default:product.html.twig', array('products' => $products));
    }
}
