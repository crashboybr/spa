<?php

namespace Spa\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VideoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url')
            ->add('description')
            ->add('type', 'choice', array(
                'choices' => array('youtube' => 'Youtube', 'vimeo' => 'Vimeo', 'r7' => 'R7', 'outros' => 'Outros', 'externo' => 'Página Externa'),
                'attr' => array('onchange' => 'showFile()'),
                'label' => 'Tipo de Video'
            ))
            ->add('file')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Spa\BackendBundle\Entity\Video'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'spa_backendbundle_video';
    }
}
