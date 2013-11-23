<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Spa\BackendBundle\Entity\Service;
use Spa\BackendBundle\Form\ServiceType;
use Spa\BackendBundle\Entity\Submenu;

/**
 * Service controller.
 *
 */
class ServiceController extends Controller
{

    /**
     * Lists all Service entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SpaBackendBundle:Service')->findBy(array(), array('position' => 'ASC'));

        return $this->render('SpaBackendBundle:Service:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Service entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Service();
        $form = $this->createCreateForm($entity);
        
        $form->handleRequest($request);


        if ($form->isValid()) {
            $entity->setSlug($entity->getName());
            $em = $this->getDoctrine()->getManager();

            $query = 'SELECT MAX(position) as position FROM Service';
            $stmt = $em->getConnection()->prepare($query);
            $stmt->execute();
            $position = $stmt->fetch();
            $position = $position['position'];


            
            $entity->setPosition($position + 1);

            if ($form->get('save_and_publish')->isClicked())
                $entity->setHided(false);
            else
                $entity->setHided(true);

            $em->persist($entity);
            $em->flush();

            $menu = $em->getRepository('SpaBackendBundle:Menu')
            ->find(3);

            $submenu = new Submenu();
            $submenu->setName($entity->getName());
            $submenu->setSlug($entity->getSlug());

            $submenu->setMenu($menu);

            $query = 'SELECT MAX(position) as position FROM Submenu';
            $stmt = $em->getConnection()->prepare($query);
            $stmt->execute();
            $position = $stmt->fetch();
            $position = $position['position'];
            
            $submenu->setPosition($position + 1);

            $em->persist($submenu);
            $em->flush();

            return $this->redirect($this->generateUrl('servicos'));
        }

        return $this->render('SpaBackendBundle:Service:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Service entity.
    *
    * @param Service $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Service $entity)
    {
        $form = $this->createForm(new ServiceType(), $entity, array(
            'action' => $this->generateUrl('servicos_create'),
            'method' => 'POST',
        ));

        

        return $form;
    }

    /**
     * Displays a form to create a new Service entity.
     *
     */
    public function newAction()
    {
        $entity = new Service();
        $form   = $this->createCreateForm($entity);

        return $this->render('SpaBackendBundle:Service:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Service entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:Service:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Service entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:Service:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Service entity.
    *
    * @param Service $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Service $entity)
    {
        $form = $this->createForm(new ServiceType(), $entity, array(
            'action' => $this->generateUrl('servicos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Service entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }
        $entity->setSlug($entity->getName());

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($editForm->get('save_and_publish')->isClicked())
                $entity->setHided(false);
            else
                $entity->setHided(true);
            $em->flush();

            return $this->redirect($this->generateUrl('servicos'));
        }

        return $this->render('SpaBackendBundle:Service:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Service entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SpaBackendBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }

        $em->remove($entity);
        $em->flush();
        

        return $this->redirect($this->generateUrl('servicos'));
    }

    /**
     * Creates a form to delete a Service entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('servicos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
