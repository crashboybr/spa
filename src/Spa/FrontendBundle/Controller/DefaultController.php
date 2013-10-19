<?php

namespace Spa\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Spa\BackendBundle\Entity\Unit;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
		$featured_video = $em->getRepository('SpaBackendBundle:Video')
            ->findOneBy(array('featured' => 1));
        
        $sliders = $em->getRepository('SpaBackendBundle:Slider')
            ->findAll(); 
        

        return $this->render('SpaFrontendBundle:Default:index.html.twig', array('featured_video' => $featured_video, 'sliders' => $sliders));
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

        Header('Access-Control-Allow-Origin: *');
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

    public function addUnitAction()
    {
        $row = 1;
        $handle = fopen ("/Users/bernardo/www/unidades.csv","r");
        $em = $this->getDoctrine()->getManager();
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count ($data);
            
            //var_dump($data);
            $unit = new Unit();
            $unit->setName(trim($data[0]));
            $unit->setEmail(trim($data[1]));
            $unit->setAddress(trim($data[2]));
            $unit->setCity(trim($data[3]));
            $unit->setState(trim($data[4]));
            if ($data[5] && $data[6])
                $unit->setPhone1("(" . trim($data[5]) . ") " . trim($data[6]));
            if ($data[7] && $data[8])
                $unit->setPhone2("(" . trim($data[7]) . ") " . trim($data[8]));

            $unit->setStatus(trim($data[9]) == "Inaugurada" ? true : false);

            $em->persist($unit);
            $em->flush();
        /*for ($c=0; $c < $num; $c++) {
                $unit = new Unit();
                $unit->setName($data[])
               echo $data[$c] . "<br />\n";
            }*/
        }
        fclose ($handle);
        exit;
    }
    public function viewMapAction()
    {
        Header('Access-Control-Allow-Origin: *');
        $em = $this->getDoctrine()->getManager();
        $units = $em->getRepository('SpaBackendBundle:Unit')
            //->findBy(array('status' => true))
            ->findAll();
   
        return $this->render('SpaFrontendBundle:Default:viewMap.html.twig', array('units' => $units));

    }
}
