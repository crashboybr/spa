<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Spa\BackendBundle\Entity\DoubleBanner;
use Spa\BackendBundle\Form\DoubleBannerType;

/**
 * DoubleBanner controller.
 *
 */
class DoubleBannerController extends Controller
{

    /**
     * Lists all DoubleBanner entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SpaBackendBundle:DoubleBanner')->findAll();

        return $this->render('SpaBackendBundle:DoubleBanner:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new DoubleBanner entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DoubleBanner();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bannerduplo_show', array('id' => $entity->getId())));
        }

        return $this->render('SpaBackendBundle:DoubleBanner:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a DoubleBanner entity.
    *
    * @param DoubleBanner $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(DoubleBanner $entity)
    {
        $form = $this->createForm(new DoubleBannerType(), $entity, array(
            'action' => $this->generateUrl('bannerduplo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DoubleBanner entity.
     *
     */
    public function newAction()
    {
        $entity = new DoubleBanner();
        $form   = $this->createCreateForm($entity);

        return $this->render('SpaBackendBundle:DoubleBanner:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DoubleBanner entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:DoubleBanner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DoubleBanner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:DoubleBanner:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing DoubleBanner entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:DoubleBanner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DoubleBanner entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:DoubleBanner:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DoubleBanner entity.
    *
    * @param DoubleBanner $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DoubleBanner $entity)
    {
        $form = $this->createForm(new DoubleBannerType(), $entity, array(
            'action' => $this->generateUrl('bannerduplo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DoubleBanner entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:DoubleBanner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DoubleBanner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('bannerduplo_edit', array('id' => $id)));
        }

        return $this->render('SpaBackendBundle:DoubleBanner:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DoubleBanner entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SpaBackendBundle:DoubleBanner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DoubleBanner entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bannerduplo'));
    }

    /**
     * Creates a form to delete a DoubleBanner entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bannerduplo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
