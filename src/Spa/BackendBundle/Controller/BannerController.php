<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Spa\BackendBundle\Entity\Banner;
use Spa\BackendBundle\Form\BannerType;

/**
 * Banner controller.
 *
 */
class BannerController extends Controller
{

    /**
     * Lists all Banner entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SpaBackendBundle:Banner')->findAll();

        return $this->render('SpaBackendBundle:Banner:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Banner entity.
     *
     */
    public function createAction(Request $request)
    {
        

        
        
        $banner = $request->request->get('spa_backendbundle_banner');

        if ($banner['type'] == 'Galeria')
        {
            $files = $request->files->get('spa_backendbundle_banner');
            $em = $this->getDoctrine()->getManager();
            foreach ($files['file'] as $file)
            {
                $entity = new Banner();
                $entity->setTitle($banner['title']);
                $entity->setType($banner['type']);        
                $entity->setFile($file);
                $entity->setUrl('/');
            
               
                $em->persist($entity);
                $em->flush();
                

            }
            return $this->redirect($this->generateUrl('banners' ));
            
        }
        else
        {
            
            $entity = new Banner();
            $form = $this->createCreateForm($entity);
            
            
            $form->handleRequest($request);


            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('banners'));
            }
        }

        return $this->render('SpaBackendBundle:Banner:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Banner entity.
    *
    * @param Banner $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Banner $entity)
    {
        $form = $this->createForm(new BannerType(), $entity, array(
            'action' => $this->generateUrl('banners_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Banner entity.
     *
     */
    public function newAction()
    {
        $entity = new Banner();
        $form   = $this->createCreateForm($entity);

        return $this->render('SpaBackendBundle:Banner:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Banner entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:Banner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:Banner:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Banner entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:Banner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:Banner:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Banner entity.
    *
    * @param Banner $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Banner $entity)
    {
        $form = $this->createForm(new BannerType(), $entity, array(
            'action' => $this->generateUrl('banners_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Banner entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:Banner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('banners_edit', array('id' => $id)));
        }

        return $this->render('SpaBackendBundle:Banner:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Banner entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SpaBackendBundle:Banner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Banner entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('banners'));
    }

    /**
     * Creates a form to delete a Banner entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('banners_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
