<?php

namespace Spa\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Spa\BackendBundle\Entity\Unit;
use Spa\BackendBundle\Entity\Post;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $session = $this->getRequest()->getSession();
        $user = null;
        $user_id = $session->get('user_id');
        $user_salt = $session->get('user_salt');
        
        if ($user_salt)
        {
            $user = $em->getRepository('SpaBackendBundle:User')
            ->findOneBy(array('salt' => $user_salt));
            //var_dump($user);exit;
        }
    	
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
            ->findBy(array(), array('position' => 'ASC')); 


        $repo = $this->getDoctrine()->getRepository('SpaBackendBundle:SimpleBanner');

        $query = $em->createQuery(
            'SELECT p
            FROM SpaBackendBundle:SimpleBanner p
            ORDER BY p.createdAt DESC'
        )->setMaxResults(1);

        $bannersimples = $query->getSingleResult();

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
            'bannerdireita' => $bannerdireita,
            'user' => $user,
            'user_id' => $user_id
        ));
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

 

    public function showBannerAction($page)
    {
        
        $em = $this->getDoctrine()->getManager();
        $banners = $em->getRepository('SpaBackendBundle:PageBanner')
            ->findBy(array('page' => $page), array('position' => 'ASC'));
        $arr_banner = array();
        foreach ($banners as $banner)
        {
             
            if ($banner->getBanner()->getType() == 'Galeria')
            {
                $galeria = $em->getRepository('SpaBackendBundle:Banner')
                ->findBy(array('type' => 'Galeria'), array('createdAt' => 'ASC'));
                //var_dump($galeria);exit;
                $arr_banner[$banner->getPosition()] = $galeria;
            }
            else
                $arr_banner[$banner->getPosition()] = $banner;


        }
        
         //\Doctrine\Common\Util\Debug::Dump($arr_banner[3]);exit; 
        /*    echo "<pre>";
        foreach ($banners as $banner)
        {
            if ($banner->getBanner()->getType() == 'Simples')
            {
                \Doctrine\Common\Util\Debug::Dump($banner->getBanner());exit;     
            }
        }*/
            
           
         return $this->render('SpaFrontendBundle:Default:showBanners.html.twig', array('banners' => $arr_banner));
    }

    public function bannerRightAction($page)
    {
        var_dump($page);exit;
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

        $content = $em->getRepository('SpaBackendBundle:PageContent')
            ->findOneBy(array('page' => 'servicos'));      

            
         return $this->render('SpaFrontendBundle:Default:services.html.twig', array('services' => $services, 'content' => $content));
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


    public function productAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('SpaBackendBundle:Product')
            ->findAll();
   
        return $this->render('SpaFrontendBundle:Default:products.html.twig', array('products' => $products));
    }

   public function viewProductAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('SpaBackendBundle:Product')
            ->findAll();  

        $product = $em->getRepository('SpaBackendBundle:Product')
            ->findOneBy(array('slug' => $slug));  

        if (!$product) {
            throw $this->createNotFoundException('Produto não encontrado!');
        }    

        return $this->render('SpaFrontendBundle:Default:viewProduct.html.twig', array('products' => $products, 'product' => $product));       
    }

    public function promotionAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $fixed_promotions = $em->getRepository('SpaBackendBundle:Promotion')
            ->findBy(array('fixed' => true));    
        $sazonal_promotion = $em->getRepository('SpaBackendBundle:Promotion')
            ->findOneBy(
                array('fixed' => false),
                array('createdAt' => 'DESC')
            );    
            
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

    public function franqueadoAction()
    {
        $units = null;
        return $this->render('SpaFrontendBundle:Default:viewMap.html.twig', array('units' => $units));
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

        return $this->render('SpaFrontendBundle:Default:login.html.twig', array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            ));
    }



    public function renderMenuAction()
    {
        $em = $this->getDoctrine()->getManager();


        $menus = $em->getRepository('SpaBackendBundle:Menu')
            ->findAll(); 
        /*echo "<pre>";
        foreach ($menus as $menu)
        {
            \Doctrine\Common\Util\Debug::dump($menu->getSubMenus());
        }
        exit;*/
        return $this->render('SpaFrontendBundle::menu.html.twig', array(
                'menus' => $menus,
            ));
    }

    public function sendMailAction()
    {
        $request = $this->getRequest();
        $dados['nome'] = $request->request->get('nome');
        $dados['email'] = $request->request->get('email');
        $dados['re_email'] = $request->request->get('re_email');
        $dados['email_alternativo'] = $request->request->get('email_alternativo');
        $dados['telefone_fixo_ddd'] = $request->request->get('telefone_fixo_ddd');
        $dados['telefone_fixo'] = $request->request->get('telefone_fixo');
        $dados['celular_1_ddd'] = $request->request->get('celular_1_ddd');
        $dados['celular_1'] = $request->request->get('celular_1');
        $dados['celular_2_ddd'] = $request->request->get('celular_2_ddd');
        $dados['celular_2'] = $request->request->get('celular_2');
        $dados['estado'] = $request->request->get('estado');
        $dados['cidade'] = $request->request->get('cidade');
        $dados['investimento_pretendido'] = $request->request->get('investimento_pretendido');
        $dados['inicio_franquia'] = $request->request->get('inicio_franquia');
        $dados['observacoes'] = $request->request->get('observacoes');

      
        $message = \Swift_Message::newInstance()
        ->setSubject('Contato Franquia')
        ->setFrom($dados['email'])
        ->setTo('bernardo.d.alves@gmail.com')
        ->setBody(
            $this->renderView(
                'SpaFrontendBundle:Default:email.txt.twig',
                array('dados' => $dados)
            )
        )
        ;
        $this->get('mailer')->send($message);
        
        return $this->redirect($this->generateUrl('spa_frontend_sejafranqueado', array('obrigado' => true)));
        //return $this->render('SpaFrontendBundle:Default:sejafranqueado.html.twig', array('obrigado' => true));
    }

    public function sendMailFaleConoscoAction()
    {
        $request = $this->getRequest();
        $dados['nome'] = $request->request->get('nome');
        $dados['sobrenome'] = $request->request->get('sobrenome');
        $dados['email'] = $request->request->get('email');
        $dados['assunto'] = $request->request->get('assunto');
        $dados['telefone'] = $request->request->get('telefone');
        $dados['celular'] = $request->request->get('celular');
        $dados['mensagem'] = $request->request->get('mensagem');
        $dados['anexo'] = $request->files->get('anexo');

        if (!$dados['nome'] || !$dados['sobrenome'] || !$dados['email'])
            return $this->redirect($this->generateUrl('spa_frontend_faleconosco'));
        
        $message = \Swift_Message::newInstance()
        ->setSubject('Contato Fale Conosco')
        ->setFrom($dados['email'])
        ->setTo('bernardo.d.alves@gmail.com')
        ->setBody(
            $this->renderView(
                'SpaFrontendBundle:Default:emailfaleconosco.txt.twig',
                array('dados' => $dados)
            )
        );
        if ($dados['anexo'])
        {
            $file = $dados['anexo'];
           
            $file->move('/tmp/', $file->getClientOriginalName());

            $message->attach(\Swift_Attachment::fromPath('/tmp/' . $file->getClientOriginalName()));
        }
       
        
        $this->get('mailer')->send($message);
        
        return $this->redirect($this->generateUrl('spa_frontend_faleconosco', array('obrigado' => true)));
        //return $this->render('SpaFrontendBundle:Default:sejafranqueado.html.twig', array('obrigado' => true));
    }

    public function sejaFranqueadoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $obrigado = false;
        $request = $this->getRequest();
        if ($request->query->get('obrigado'))
            $obrigado = true;
        
        $pagecontent  = $em->getRepository('SpaBackendBundle:PageContent')
            ->findOneBy(array('page' => 'seja-um-franqueado')); 

        return $this->render('SpaFrontendBundle:Default:sejafranqueado.html.twig', array('obrigado' => $obrigado, 'pagecontent' => $pagecontent));
    }

    public function institucionalAction()
    {
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('SpaBackendBundle:PageContent')
            ->findOneBy(array('page' => 'institucional'));  
        return $this->render('SpaFrontendBundle:Default:institucional.html.twig', array('content' => $content));
    }

    public function faleConoscoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $obrigado = false;
        $request = $this->getRequest();
        if ($request->query->get('obrigado'))
            $obrigado = true;
        $pagecontent  = $em->getRepository('SpaBackendBundle:PageContent')
            ->findOneBy(array('page' => 'faleconosco')); 
        return $this->render('SpaFrontendBundle:Default:faleconosco.html.twig', array('obrigado' => $obrigado, 'pagecontent' => $pagecontent));
    }

    public function menuAction($slug)
    {
        switch ($slug)
        {
            case "promocoes":
                return $this->promotionAction();

            case "unidades":
                return $this->unitAction();

            case "servicos":
                return $this->servicesAction();

            case "produtos":
                return $this->productAction();

            case "noticias":
                return $this->newsAction();

            case "seja-um-franqueado":
                return $this->sejaFranqueadoAction();

            case "institucional":
                return $this->institucionalAction();

            case "faleconosco":
                return $this->faleConoscoAction();

            case "mudarsenha":
                return $this->changePassAction();

            default:
                throw new NotFoundHttpException("Page not found");

        }
        
    }

    public function subMenuAction($slug, $subslug)
    {
        switch ($slug)
        {
            case "promocoes":
                return $this->viewPromotionAction($subslug);

            case "unidades":
                return $this->unitAction();

            case "servicos":
                return $this->viewServiceAction($subslug);

            case "produtos":
                return $this->viewProductAction($subslug);

            case "noticias":
                return $this->newsAction();

            case "seja-um-franqueado":
                return $this->sejaFranqueadoAction();

             case "primeiroacesso":
                return $this->firstAccessAction($subslug);

            default:
                throw new NotFoundHttpException("Page not found");

        }
        
    }

    public function firstAccessAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('SpaBackendBundle:User')->findOneBy(array('salt' => $slug));
        if (!$user)
            throw new NotFoundHttpException("Page not found");

        $session = $this->getRequest()->getSession();

        $session->set('user_salt', $user->getSalt());
        //$name = $session->get('user');
        //var_dump($name);exit;
        return $this->indexAction();
        
    }   

    public function changePassAction()
    {
        $session = $this->getRequest()->getSession();
        $request = $this->getRequest();

        $em = $this->getDoctrine()->getManager();
        $user = null;
        $user_salt = $session->get('user_salt');
        if ($user_salt)
        {
            $user = $em->getRepository('SpaBackendBundle:User')
            ->findOneBy(array('salt' => $user_salt));
            
        }
        if ($request->request->get('_pass') == '' || $request->request->get('_pass2') == '') $return = -10;
        else
        {
            if ($user)
            {    
                $pass1 = $request->request->get('_pass');
                $pass2 = $request->request->get('_pass2');


                if ($pass1 == $pass2)
                {
                    
                    $user->setPassword($pass1);
                    $user->setSalt(null);

                    $em->persist($user);
                    $em->flush();

                    $session->set('user_salt', null);
                    $session->set('user_id', $user->getId());

                    $return = 1;
                }
                else
                    $return = 0;
            }
            else $return = -1;
        }
        $response = new JsonResponse();

        $response->setData(array(
            'return' => $return
        ));
        return $response;






    }
   
}
