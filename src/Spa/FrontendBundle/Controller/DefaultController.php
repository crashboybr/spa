<?php

namespace Spa\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Spa\BackendBundle\Entity\Unit;
use Spa\BackendBundle\Entity\Post;


class DefaultController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
		//$featured_video = $em->getRepository('SpaBackendBundle:Video')
         //   ->findOneBy(array('featured' => 1));

        $query = $em->createQuery(
            'SELECT p
            FROM SpaBackendBundle:Video p
            ORDER BY p.createdAt DESC'
        )->setMaxResults(1);

        $featured_video = $query->getSingleResult();
        

        //parse_str( parse_url( $featured_video->getUrl(), PHP_URL_QUERY ), $youtube_id );

        //$youtube_id = $youtube_id['v'];
        
        $sliders = $em->getRepository('SpaBackendBundle:Slider')
            ->findAll(); 

        $repo = $this->getDoctrine()->getRepository('SpaBackendBundle:SimpleBanner');

        $bannersimples = $repo->createQueryBuilder('p')
        ->getQuery()->getSingleResult();

        $query = $em->createQuery(
            'SELECT p
            FROM SpaBackendBundle:DoubleBanner p
            ORDER BY p.createdAt DESC'
        )->setMaxResults(2);

        $bannersduplo = $query->getResult();
        

        $repo = $this->getDoctrine()->getRepository('SpaBackendBundle:RightBanner');
        $bannerdireita = $repo->createQueryBuilder('p')
        ->getQuery()->getSingleResult();

        
        return $this->render('SpaFrontendBundle:Default:index.html.twig', array(
            'featured_video' => $featured_video,
            //'youtube_id' => $youtube_id,
            'sliders' => $sliders, 
            'bannersimples' => $bannersimples, 
            'bannersduplo' => $bannersduplo,
            'bannerdireita' => $bannerdireita
        ));
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
        
        $bannersunity = $em->getRepository('SpaBackendBundle:BannerUnity')
            ->findAll();    

        $query = $em->createQuery(
            'SELECT p
            FROM SpaBackendBundle:RightBanner p
            ORDER BY p.createdAt DESC'
        )->setMaxResults(2);

        $bannersdireita = $query->getResult(); 

        return $this->render('SpaFrontendBundle:Default:unit.html.twig', array(
            'units' => $units, 
            'bannersunity' => $bannersunity,
            'bannersdireita' => $bannersdireita
            ));
    }

    public function findUnitAction($uf, $city)
    {

        Header('Access-Control-Allow-Origin: *');
        $response = new JsonResponse();

        $em = $this->getDoctrine()->getManager();
        if (!$city)
            $units = $em->getRepository('SpaBackendBundle:Unit')->findBy(array('state' => $uf));
        else
            $units = $em->getRepository('SpaBackendBundle:Unit')->findBy(array('state' => $uf, 'city' => $city));
        
        $json_unit = array();
        foreach ($units as $unit)
        {
            $json_unit[$unit->getCity()][$unit->getName()]['address'] = $unit->getAddress();
            $json_unit[$unit->getCity()][$unit->getName()]['email'] = $unit->getEmail();
            $json_unit[$unit->getCity()][$unit->getName()]['phone1'] = $unit->getPhone1();
            $json_unit[$unit->getCity()][$unit->getName()]['phone2'] = $unit->getPhone2();
            $json_unit[$unit->getCity()][$unit->getName()]['status'] = $unit->getStatus();

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

    public function newsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('SpaBackendBundle:Post')
            ->findAll();

        return $this->render('SpaFrontendBundle:Default:news.html.twig', array('posts' => $posts));
    
    }

    public function viewPostAction(Post $post)
    {
        $createdAt = $post->getCreatedAt();
        //var_dump($createdAt);exit;
        $dia = date('d');
        $mes = date('m');
        $ano = date('Y');
        $semana = date('w');
         
         
        // configuração mes
         
        switch ($mes){
         
        case 1: $mes = "JANEIRO"; break;
        case 2: $mes = "FEVEREIRO"; break;
        case 3: $mes = "MARÇO"; break;
        case 4: $mes = "ABRIL"; break;
        case 5: $mes = "MAIO"; break;
        case 6: $mes = "JUNHO"; break;
        case 7: $mes = "JULHO"; break;
        case 8: $mes = "AGOSTO"; break;
        case 9: $mes = "SETEMBRO"; break;
        case 10: $mes = "OUTUBRO"; break;
        case 11: $mes = "NOVEMBRO"; break;
        case 12: $mes = "DEZEMBRO"; break;
         
        }
        
        
        return $this->render('SpaFrontendBundle:Default:viewNews.html.twig', array('post' => $post));
    
    }

    public function bannerUnityAction()
    {
        $em = $this->getDoctrine()->getManager();
        $bannersunity = $em->getRepository('SpaBackendBundle:BannerUnity')
            ->findAll();    
         return $this->render('SpaFrontendBundle:Default:bannerUnity.html.twig', array('bannersunity' => $bannersunity));
    }

    public function bannerRightAction()
    {
        $repo = $this->getDoctrine()->getRepository('SpaBackendBundle:RightBanner');
        $bannerdireita = $repo->createQueryBuilder('p')
        ->getQuery()->getSingleResult();   
         return $this->render('SpaFrontendBundle:Default:bannerRight.html.twig', array('bannerdireita' => $bannerdireita));
    }

    public function bannerFindUnityAction()
    {
          
         return $this->render('SpaFrontendBundle:Default:bannerFindUnity.html.twig');
    }

    public function servicesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository('SpaBackendBundle:Service')
            ->findAll();    

            
         return $this->render('SpaFrontendBundle:Default:services.html.twig', array('services' => $services));
    }

    public function viewServiceAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository('SpaBackendBundle:Service')
            ->findAll();  

        $service = $em->getRepository('SpaBackendBundle:Service')
            ->findOneBy(array('slug' => $slug));  

        if (!$service) {
            throw $this->createNotFoundException('Serviço não encontrado!');
        }    

        return $this->render('SpaFrontendBundle:Default:viewService.html.twig', array('service' => $service, 'services' => $services));       
    }

    public function promotionAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $fixed_promotions = $em->getRepository('SpaBackendBundle:Promotion')
            ->findBy(array('fixed' => true));    
        $sazonal_promotion = $em->getRepository('SpaBackendBundle:Promotion')
            ->findOneBy(array('fixed' => false));    
            
         return $this->render('SpaFrontendBundle:Default:promotion.html.twig', array('sazonal_promotion' => $sazonal_promotion, 'fixed_promotions' => $fixed_promotions));
    }

    public function viewPromotionAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $fixed_promotions = $em->getRepository('SpaBackendBundle:Promotion')
            ->findBy(array('fixed' => true));  

        $promotion = $em->getRepository('SpaBackendBundle:Promotion')
            ->findOneBy(array('slug' => $slug));  

        if (!$promotion) {
            throw $this->createNotFoundException('Promoção não encontrada!');
        }    

        return $this->render('SpaFrontendBundle:Default:viewPromotion.html.twig', array('promotion' => $promotion, 'fixed_promotions' => $fixed_promotions));       
    }


    public function toAscii($str, $replace=array(), $delimiter='-') {
     if( !empty($replace) ) {
      $str = str_replace((array)$replace, ' ', $str);
     }

     $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
     $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
     $clean = strtolower(trim($clean, '-'));
     $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

     return $clean;
    }
    }
