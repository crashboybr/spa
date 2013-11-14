<?php

namespace Spa\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content', 'ckeditor', array('config_name' => 'my_config'))
            ->add('file')
            ->add('tags')
            ->add('related1','entity', array(
                'class' => 'SpaBackendBundle:Post',
                'property' => 'title', 'empty_value' => 'Selecione uma notícia'))
            ->add('related2','entity', array(
                'class' => 'SpaBackendBundle:Post',
                'property' => 'title', 'empty_value' => 'Selecione uma notícia'))
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
            'data_class' => 'Spa\BackendBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'spa_backendbundle_post';
    }
}
