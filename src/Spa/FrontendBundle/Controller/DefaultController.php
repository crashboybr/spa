<?php

namespace Spa\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


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

    public function unitAction()
    {
        $em = $this->getDoctrine()->getManager();
        $units = $em->getRepository('SpaBackendBundle:Unit')
            //->findBy(array('status' => true))
            ->findAll();
   
        return $this->render('SpaFrontendBundle:Default:unit.html.twig', array('units' => $units));
    }

    public function findUnitAction($uf, $city)
    {


        $response = new JsonResponse();

        $em = $this->getDoctrine()->getManager();
        if (!$city)
            $units = $em->getRepository('SpaBackendBundle:Unit')->findBy(array('status' => true, 'state' => $uf));
        else
            $units = $em->getRepository('SpaBackendBundle:Unit')->findBy(array('status' => true, 'state' => $uf, 'city' => $city));
        
        $json_unit = array();
        foreach ($units as $unit)
        {
            $json_unit[$unit->getCity()][$unit->getName()]['address'] = $unit->getAddress();
            $json_unit[$unit->getCity()][$unit->getName()]['email'] = $unit->getEmail();
            $json_unit[$unit->getCity()][$unit->getName()]['phone1'] = $unit->getPhone1();
            $json_unit[$unit->getCity()][$unit->getName()]['phone2'] = $unit->getPhone2();

        }
        $response->setData(array(
            'units' => $json_unit
        ));
        return $response;

    }
}
