<?php

namespace Ilc\Bundle\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ilc\Bundle\ShopBundle\Entity\Address;
use Ilc\Bundle\ShopBundle\Form\AddressType;
/**
 * @Route("/checkout")
 */
class CheckoutController extends Controller
{
    /**
     * @Route("/", name="checkout")
     * @Template()
     */
    public function checkoutAction()
    {
    	return array();
    }
    
    /**
     * @Route("/billing_address", name="checkout_billing_address")
     * @Template()
     */
    public function billingAddressAction(Request $request) {
        $session = $this->get('session');
        $objAddress = new Address();
        $form = $this->createForm(new AddressType(false, $objAddress));
        
        $form->add('Suivant', 'submit', array(
            'attr' => array(
                'class' => 'btn',
            ),
        ));
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $session->set('billingAddress', $objAddress);
            return $this->redirect($this->generateUrl('checkout_shipping_address'));
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/shipping_address", name="checkout_shipping_address")
     * @Template()
     */
    public function shippingAddressAction(Request $request) {
        $session = $this->get('session');
        $objAddress = new Address();
        $form = $this->createForm(new AddressType(true, $objAddress));
        
         $form->add('Suivant', 'submit', array(
            'attr' => array(
                'class' => 'btn',
            ),
        ));
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            if($form->get('use_prev')->getData()) {
                $objAddress = $session->get('billingAddress');
            } 
           
            $session->set('shippingAddress', $objAddress);
            
            return $this->redirect($this->generateUrl('checkout_end'));
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/end", name="checkout_end")
     * @Template()
     */
    public function endAction() {
        return array();
    }
}