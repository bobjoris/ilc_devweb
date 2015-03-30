<?php

namespace Ilc\Bundle\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressType extends AbstractType {
    
    private $isShipping;
    
    public function __construct($shipping = false) {
        $this->isShipping = $shipping;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        if($this->isShipping){
            $builder->add('usePrev', 'checkbox', array(
                'label' => 'Use previous information',
                'required'=> false,
                'attr' => ['class' =>'use_prev'],
            ));
        }
                    $builder->add('firstname', 'text', array(
                        'label' => 'Firstname'
                   ))
                ->add('lastname', 'text', array(
                    'label' => 'Lastname'
                ))
                ->add('street', 'text', array(
                    'label' => 'Street'
                ))
                ->add('postalCode', 'text', array(
                    'label' => 'Postal code'
                ))
                ->add('city', 'text', array(
                    'label' => 'City'
                ));          
    }
    
    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data-class' => 'Ilc\Bundle\ShopBundle\Entity\Address',
        ));
    }
    
    public function getName() {
        return 'ilc_bundle_shopbundle_addresstype';
    }

}