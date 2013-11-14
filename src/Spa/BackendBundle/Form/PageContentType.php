<?php

namespace Spa\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageContentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page','hidden')
            ->add('content', 'ckeditor', array('config_name' => 'my_config'))
            ->add('form')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Spa\BackendBundle\Entity\PageContent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'spa_backendbundle_pagecontent';
    }
}
