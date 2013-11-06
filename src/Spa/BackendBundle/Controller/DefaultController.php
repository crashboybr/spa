<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Spa\BackendBundle\Entity\PageBanner;
use Spa\BackendBundle\Entity\Banner;

class DefaultController extends Controller
{
    public function indexAction()
    {
         return $this->forward('SpaBackendBundle:Slider:index');
        //return $this->render('SpaBackendBundle:Default:index.html.twig');
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

        return $this->render('SpaBackendBundle:Default:login.html.twig', array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            ));
    }

    public function pageBannerAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $banners = $em->getRepository('SpaBackendBundle:Banner')
            ->findAll();
           
        foreach ($banners as $banner)
        {
            if ($banner->getType() == 'Galeria')
                $arr_banner['galeria'] = $banner;
            else
                $arr_banner['simples'][] = $banner;


        }
        
        //var_dump($arr_banner);exit;
        $pagebanners = $em->getRepository('SpaBackendBundle:PageBanner')
            ->findBy(array('page' => $page));


        return $this->render('SpaBackendBundle:Default:pagebanner.html.twig', 
            array('banners' => $arr_banner, 
                'pagebanners' => $pagebanners,
                'page' => $page
            )
        );

    }

    public function addPageBannerAction(Banner $banner, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $pagebanner = $em->getRepository('SpaBackendBundle:PageBanner')
            ->findBy(array('page' => $page, 'banner' => $banner));

        if (!$pagebanner)
        {
            $pagebanner = new PageBanner();
            $pagebanner->setBanner($banner);
            $pagebanner->setHided(false);
            $pagebanner->setPage($page);

            
            
            $query = "SELECT MAX(position) as position FROM PageBanner where page = '$page'";
            $stmt = $em->getConnection()->prepare($query);
            $stmt->execute();
            $position = $stmt->fetch();
            $position = $position['position'];
            
            $pagebanner->setPosition($position + 1);

            $em->persist($pagebanner);
            $em->flush();
        }

        
        echo "<pre>";
        \Doctrine\Common\Util\Debug::dump($pagebanner);
        //print_r($pagebanner);
        exit;//var_dump($banner_id, $page);exit;
    }

}
