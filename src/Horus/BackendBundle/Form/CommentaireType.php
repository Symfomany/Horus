<?php

namespace Horus\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CommentaireType
 * @package Horus\BackendBundle\Form
 */
class CommentaireType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('content', 'textarea', array('label' => 'Contenu du commentaire','attr' => array('placeholder' => 'Contenu du commentaire','class' => 'form-control','cols' => 50, 'rows' => 10)))
                ->add('visible', 'choice', array(
                'label' => 'Etat',
                'choices' => array(0 => 'Invisible', 1 => 'En cours de relecture', 2 => 'Visible'),
                'required' => true,
                'expanded' => true));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){

        $resolver->setDefaults(array(
            'data_class' => 'Horus\BackendBundle\Entity\Commentaire',
            'csrf_protection' => false
        ));
    }
}
