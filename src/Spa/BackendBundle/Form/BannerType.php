<?php

namespace Spa\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BannerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('type', 'choice', array(
                'choices' => array('Simples' => 'Simples', 'Galeria' => 'Galeria'),
                'attr' => array('onchange' => 'changeType()'),
                'label' => 'Tipo'
            ))
            ->add('title', 'text', array('label' => 'Título'))
            ->add('file', 'file', array('label' => 'Imagem'))
            ->add('url', 'text', array('label' => 'Link'))

            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Spa\BackendBundle\Entity\Banner'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'spa_backendbundle_banner';
    }
}
