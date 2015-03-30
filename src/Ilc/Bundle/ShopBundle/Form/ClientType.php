<?php

namespace Ilc\Bundle\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ClientType extends AbstractType {
    
    private $isShipping;
    
    public function __construct($shipping = false) {
        $this->isShipping = $shipping;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);

        $builder->add('email', 'text', array(
                        'label' => 'Email'
                   ))
                ->add('password', 'password', array(
                    'label' => 'Password'
                ))
                ->add('firstname', 'text', array(
                    'label' => 'Firstname'
                ))
                ->add('lastname', 'text', array(
                    'label' => 'Lastname'
                ))
                ->add('phone', 'text', array(
                    'label' => 'Phone',
                    'required' => false,
                ));          
    }
    
    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data-class' => 'Ilc\Bundle\ShopBundle\Entity\Client',
        ));
    }
    
    public function getName() {
        return 'ilc_bundle_shopbundle_clienttype';
    }

}