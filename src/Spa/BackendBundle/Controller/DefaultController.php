<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Spa\BackendBundle\Entity\PageBanner;
use Spa\BackendBundle\Entity\Banner;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
            ->findBy(array('page' => $page), array('position' => 'ASC'));


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

    public function delPageBannerAction(Banner $banner, $page)
    {
        //var_dump($page);
        $em = $this->getDoctrine()->getManager();
        $pagebanner = $em->getRepository('SpaBackendBundle:PageBanner')
            ->findOneBy(array('page' => $page, 'banner' => $banner));

        if (!$pagebanner) {
            throw $this->createNotFoundException('Unable to find PageBanner entity.');
        }

        $em->remove($pagebanner);
        $em->flush();

            //var_dump($pagebanner);exit;
        //echo "<pre>";
        //\Doctrine\Common\Util\Debug::dump($pagebanner);exit;

        $request = $this->getRequest();
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
        
    }

    public function positionPageBannerAction($id, $position, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:PageBanner')->findOneBy(array('id' => $id, 'page' => $page));
        $entity->setPosition($position);
        
        $em->persist($entity);
        $em->flush();
        exit;
        return 1;
    }

    public function sendPasswordAction($email)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('SpaBackendBundle:User')
            ->findOneBy(array('username' => $email));
        if (!$user)
            throw $this->createNotFoundException('Usuário não encontrado!');
        $dados['salt'] = $user->getSalt();

        $message = \Swift_Message::newInstance()
        ->setSubject('Spa das Sobrancelhas - Nova Senha')
        ->setFrom($email)
        ->setTo($email)
        ->setBody(
            $this->renderView(
                'SpaBackendBundle:Default:sendPassword.txt.twig',
                array('dados' => $dados)
            )
        )
        ;
        $this->get('mailer')->send($message);
        exit;

    }

    public function hideAction($id, $hide, $entity)
    {
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:' . $entity)->find($id);
        $entity->setHided($hide);
        $em->persist($entity);
        $em->flush();

        $request = $this->getRequest();
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }

    public function changePositionAction($id, $position, $entity)
    {
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:' . $entity)->find($id);
        $entity->setPosition($position);
        $em->persist($entity);
        $em->flush();
        exit;
        return 1;
    }

}
