<?php

namespace Spa\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('file')
            ->add('productCategory')
            ->add('productCategory','entity', array(
                'class' => 'SpaBackendBundle:ProductCategory',
                'property' => 'name', 'empty_value' => 'Selecione uma linha'))
            ->add('save', 'submit', array('label' => '<i class="icon-download-alt"></i> Salvar'))
            ->add('save_and_publish', 'submit', array('label' => '<i class="icon-ok"></i> Salvar e Publicar' ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Spa\BackendBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'spa_backendbundle_product';
    }
}
