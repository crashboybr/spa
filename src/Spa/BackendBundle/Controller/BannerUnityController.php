<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Spa\BackendBundle\Entity\BannerUnity;
use Spa\BackendBundle\Form\BannerUnityType;

/**
 * BannerUnity controller.
 *
 */
class BannerUnityController extends Controller
{

    /**
     * Lists all BannerUnity entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SpaBackendBundle:BannerUnity')->findAll();

        return $this->render('SpaBackendBundle:BannerUnity:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new BannerUnity entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new BannerUnity();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bannerunidades_show', array('id' => $entity->getId())));
        }

        return $this->render('SpaBackendBundle:BannerUnity:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a BannerUnity entity.
    *
    * @param BannerUnity $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(BannerUnity $entity)
    {
        $form = $this->createForm(new BannerUnityType(), $entity, array(
            'action' => $this->generateUrl('bannerunidades_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new BannerUnity entity.
     *
     */
    public function newAction()
    {
        $entity = new BannerUnity();
        $form   = $this->createCreateForm($entity);

        return $this->render('SpaBackendBundle:BannerUnity:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BannerUnity entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:BannerUnity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BannerUnity entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:BannerUnity:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing BannerUnity entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:BannerUnity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BannerUnity entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:BannerUnity:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a BannerUnity entity.
    *
    * @param BannerUnity $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(BannerUnity $entity)
    {
        $form = $this->createForm(new BannerUnityType(), $entity, array(
            'action' => $this->generateUrl('bannerunidades_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing BannerUnity entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:BannerUnity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BannerUnity entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('bannerunidades_edit', array('id' => $id)));
        }

        return $this->render('SpaBackendBundle:BannerUnity:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a BannerUnity entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SpaBackendBundle:BannerUnity')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BannerUnity entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bannerunidades'));
    }

    /**
     * Creates a form to delete a BannerUnity entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bannerunidades_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
