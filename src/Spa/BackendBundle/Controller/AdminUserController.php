<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Spa\BackendBundle\Entity\AdminUser;
use Spa\BackendBundle\Form\AdminUserType;

/**
 * AdminUser controller.
 *
 */
class AdminUserController extends Controller
{

    /**
     * Lists all AdminUser entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SpaBackendBundle:AdminUser')->findAll();

        return $this->render('SpaBackendBundle:AdminUser:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new AdminUser entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new AdminUser();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admins_show', array('id' => $entity->getId())));
        }

        return $this->render('SpaBackendBundle:AdminUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a AdminUser entity.
    *
    * @param AdminUser $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(AdminUser $entity)
    {
        $form = $this->createForm(new AdminUserType(), $entity, array(
            'action' => $this->generateUrl('admins_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AdminUser entity.
     *
     */
    public function newAction()
    {
        $entity = new AdminUser();
        $form   = $this->createCreateForm($entity);

        return $this->render('SpaBackendBundle:AdminUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AdminUser entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:AdminUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdminUser entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:AdminUser:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing AdminUser entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:AdminUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdminUser entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:AdminUser:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a AdminUser entity.
    *
    * @param AdminUser $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AdminUser $entity)
    {
        $form = $this->createForm(new AdminUserType(), $entity, array(
            'action' => $this->generateUrl('admins_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AdminUser entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:AdminUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdminUser entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admins_edit', array('id' => $id)));
        }

        return $this->render('SpaBackendBundle:AdminUser:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a AdminUser entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SpaBackendBundle:AdminUser')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AdminUser entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admins'));
    }

    /**
     * Creates a form to delete a AdminUser entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admins_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
