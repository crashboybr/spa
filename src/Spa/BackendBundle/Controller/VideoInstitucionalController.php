<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Spa\BackendBundle\Entity\VideoInstitucional;
use Spa\BackendBundle\Form\VideoInstitucionalType;

/**
 * VideoInstitucional controller.
 *
 */
class VideoInstitucionalController extends Controller
{

    /**
     * Lists all VideoInstitucional entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('SpaBackendBundle:VideoInstitucional')->findAll();

        $entity = $em->getRepository('SpaBackendBundle:VideoInstitucional')->findOneBy(array());
       
        if ($entity)
            return $this->editAction($entity->getId());
        else
            return $this->newAction();

        //return $this->render('SpaBackendBundle:VideoInstitucional:index.html.twig', array(
         //   'entities' => $entities,
        //));
    }
    /**
     * Creates a new VideoInstitucional entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new VideoInstitucional();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('videoinstitucional'));
        }

        return $this->render('SpaBackendBundle:VideoInstitucional:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a VideoInstitucional entity.
    *
    * @param VideoInstitucional $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(VideoInstitucional $entity)
    {
        $form = $this->createForm(new VideoInstitucionalType(), $entity, array(
            'action' => $this->generateUrl('videoinstitucional_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new VideoInstitucional entity.
     *
     */
    public function newAction()
    {
        $entity = new VideoInstitucional();
        $form   = $this->createCreateForm($entity);

        return $this->render('SpaBackendBundle:VideoInstitucional:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a VideoInstitucional entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:VideoInstitucional')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VideoInstitucional entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:VideoInstitucional:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing VideoInstitucional entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:VideoInstitucional')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VideoInstitucional entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:VideoInstitucional:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a VideoInstitucional entity.
    *
    * @param VideoInstitucional $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(VideoInstitucional $entity)
    {
        $form = $this->createForm(new VideoInstitucionalType(), $entity, array(
            'action' => $this->generateUrl('videoinstitucional_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing VideoInstitucional entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:VideoInstitucional')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VideoInstitucional entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('videoinstitucional'));
        }

        return $this->render('SpaBackendBundle:VideoInstitucional:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a VideoInstitucional entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SpaBackendBundle:VideoInstitucional')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find VideoInstitucional entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('videoinstitucional'));
    }

    /**
     * Creates a form to delete a VideoInstitucional entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('videoinstitucional_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
