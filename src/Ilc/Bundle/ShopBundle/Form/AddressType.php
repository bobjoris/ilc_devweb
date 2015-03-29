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
            $builder->add('use_prev', 'checkbox', array(
                'label' => 'Réutiliser les informations précédents',
                'required'=> false,
                'attr' => ['class' =>'use_prev'],
            ));
        }
                    $builder->add('firstname', 'text', array(
                        'label' => 'Prénom'
                   ))
                ->add('lastname', 'text', array(
                    'label' => 'Nom'
                ))
                ->add('street', 'text', array(
                    'label' => 'N° et rue'
                ))
                ->add('postalCode', 'text', array(
                    'label' => 'Code postal'
                ))
                ->add('city', 'text', array(
                    'label' => 'Ville'
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