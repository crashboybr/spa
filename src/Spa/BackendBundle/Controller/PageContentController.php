<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Spa\BackendBundle\Entity\PageContent;
use Spa\BackendBundle\Form\PageContentType;

/**
 * PageContent controller.
 *
 */
class PageContentController extends Controller
{

    /**
     * Lists all PageContent entities.
     *
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:PageContent')->findOneBy(array('page' => $page));
        
        if (count($entity) > 0)
            return $this->editAction($entity->getId());
        else
            return $this->newAction($page);

        return $this->render('SpaBackendBundle:PageContent:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new PageContent entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new PageContent();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->editAction($entity->getId());

        }

        return $this->render('SpaBackendBundle:PageContent:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a PageContent entity.
    *
    * @param PageContent $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PageContent $entity)
    {
        $form = $this->createForm(new PageContentType(), $entity, array(
            'action' => $this->generateUrl('content_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PageContent entity.
     *
     */
    public function newAction($page)
    {
        $entity = new PageContent();
        $entity->setPage($page);
        $form   = $this->createCreateForm($entity);

        
        

        return $this->render('SpaBackendBundle:PageContent:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PageContent entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:PageContent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PageContent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:PageContent:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing PageContent entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:PageContent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PageContent entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:PageContent:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a PageContent entity.
    *
    * @param PageContent $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PageContent $entity)
    {
        $form = $this->createForm(new PageContentType(), $entity, array(
            'action' => $this->generateUrl('content_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PageContent entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:PageContent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PageContent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('content_edit', array('id' => $id)));
        }

        return $this->render('SpaBackendBundle:PageContent:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a PageContent entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SpaBackendBundle:PageContent')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PageContent entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('content'));
    }

    /**
     * Creates a form to delete a PageContent entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('content_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
