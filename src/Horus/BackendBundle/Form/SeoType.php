<?php

namespace Horus\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SeoType
 * @package Horus\BackendBundle\Form
 */
class SeoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', 'text', array('required' => false,'attr' => array('placeholder' => 'Titre')))
                ->add('keywords', 'textarea', array('required' => false,'attr' => array('class' => 'form-control','cols' => 100, 'rows' => 6, 'placeholder' => 'Mot-Clefs')))
                ->add('description', 'textarea', array('required' => false,'attr' => array('class' => 'form-control','cols' => 100, 'rows' => 6,'placeholder' => 'Description')));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'referencement';
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){

        $resolver->setDefaults(array(
            'data_class' => 'Horus\BackendBundle\Entity\Seo',
            'csrf_protection' => false
        ));
    }
}
