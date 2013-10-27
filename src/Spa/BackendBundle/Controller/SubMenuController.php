<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Spa\BackendBundle\Entity\SubMenu;
use Spa\BackendBundle\Form\SubMenuType;

/**
 * SubMenu controller.
 *
 */
class SubMenuController extends Controller
{

    /**
     * Lists all SubMenu entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SpaBackendBundle:SubMenu')->findAll();

        return $this->render('SpaBackendBundle:SubMenu:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new SubMenu entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SubMenu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setSlug($entity->getName());
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('submenu_show', array('id' => $entity->getId())));
        }

        return $this->render('SpaBackendBundle:SubMenu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a SubMenu entity.
    *
    * @param SubMenu $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(SubMenu $entity)
    {
        $form = $this->createForm(new SubMenuType(), $entity, array(
            'action' => $this->generateUrl('submenu_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SubMenu entity.
     *
     */
    public function newAction()
    {
        $entity = new SubMenu();
        $form   = $this->createCreateForm($entity);

        return $this->render('SpaBackendBundle:SubMenu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SubMenu entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:SubMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubMenu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:SubMenu:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing SubMenu entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:SubMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubMenu entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:SubMenu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a SubMenu entity.
    *
    * @param SubMenu $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SubMenu $entity)
    {
        $form = $this->createForm(new SubMenuType(), $entity, array(
            'action' => $this->generateUrl('submenu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SubMenu entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:SubMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubMenu entity.');
        }
        $entity->setSlug($entity->getName());
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('submenu_edit', array('id' => $id)));
        }

        return $this->render('SpaBackendBundle:SubMenu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a SubMenu entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SpaBackendBundle:SubMenu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SubMenu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('submenu'));
    }

    /**
     * Creates a form to delete a SubMenu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('submenu_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
