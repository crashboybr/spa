<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Spa\BackendBundle\Entity\SimpleBanner;
use Spa\BackendBundle\Form\SimpleBannerType;

/**
 * SimpleBanner controller.
 *
 */
class SimpleBannerController extends Controller
{

    /**
     * Lists all SimpleBanner entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SpaBackendBundle:SimpleBanner')->findAll();

        return $this->render('SpaBackendBundle:SimpleBanner:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new SimpleBanner entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SimpleBanner();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bannersimples_show', array('id' => $entity->getId())));
        }

        return $this->render('SpaBackendBundle:SimpleBanner:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a SimpleBanner entity.
    *
    * @param SimpleBanner $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(SimpleBanner $entity)
    {
        $form = $this->createForm(new SimpleBannerType(), $entity, array(
            'action' => $this->generateUrl('bannersimples_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SimpleBanner entity.
     *
     */
    public function newAction()
    {
        $entity = new SimpleBanner();
        $form   = $this->createCreateForm($entity);

        return $this->render('SpaBackendBundle:SimpleBanner:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SimpleBanner entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:SimpleBanner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SimpleBanner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:SimpleBanner:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing SimpleBanner entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:SimpleBanner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SimpleBanner entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:SimpleBanner:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a SimpleBanner entity.
    *
    * @param SimpleBanner $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SimpleBanner $entity)
    {
        $form = $this->createForm(new SimpleBannerType(), $entity, array(
            'action' => $this->generateUrl('bannersimples_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SimpleBanner entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:SimpleBanner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SimpleBanner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('bannersimples_edit', array('id' => $id)));
        }

        return $this->render('SpaBackendBundle:SimpleBanner:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a SimpleBanner entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SpaBackendBundle:SimpleBanner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SimpleBanner entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bannersimples'));
    }

    /**
     * Creates a form to delete a SimpleBanner entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bannersimples_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
