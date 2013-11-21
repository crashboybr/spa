<?php

namespace Spa\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Spa\BackendBundle\Entity\Promotion;
use Spa\BackendBundle\Form\PromotionType;

/**
 * Promotion controller.
 *
 */
class PromotionController extends Controller
{

    /**
     * Lists all Promotion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SpaBackendBundle:Promotion')->findBy(array(), array('position' => 'ASC'));
        return $this->render('SpaBackendBundle:Promotion:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Promotion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Promotion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setSlug($entity->getName());
            $em = $this->getDoctrine()->getManager();

            $query = 'SELECT MAX(position) as position FROM Promotion';
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

            return $this->redirect($this->generateUrl('promocao'));
        }

        return $this->render('SpaBackendBundle:Promotion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Promotion entity.
    *
    * @param Promotion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Promotion $entity)
    {
        
        $form = $this->createForm(new PromotionType(), $entity, array(
            'action' => $this->generateUrl('promocao_create'),
            'method' => 'POST',
        ));

        

        return $form;
    }

    /**
     * Displays a form to create a new Promotion entity.
     *
     */
    public function newAction()
    {
        $entity = new Promotion();

        $form   = $this->createCreateForm($entity);

        return $this->render('SpaBackendBundle:Promotion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Promotion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:Promotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:Promotion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Promotion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:Promotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SpaBackendBundle:Promotion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Promotion entity.
    *
    * @param Promotion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Promotion $entity)
    {
        $form = $this->createForm(new PromotionType(), $entity, array(
            'action' => $this->generateUrl('promocao_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Promotion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SpaBackendBundle:Promotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
        }
        $entity->setSlug($entity->getName());
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('promocao'));
        }

        return $this->render('SpaBackendBundle:Promotion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Promotion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SpaBackendBundle:Promotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
        }

        $em->remove($entity);
        $em->flush();
        

        return $this->redirect($this->generateUrl('promocao'));
    }

    /**
     * Creates a form to delete a Promotion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('promocao_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
