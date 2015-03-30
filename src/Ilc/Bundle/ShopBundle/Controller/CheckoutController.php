<?php

namespace Ilc\Bundle\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
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
    public function checkoutAction(Request $request)
    {
        $session = $this->get('session');

        if($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
            return $this->redirect($this->generateUrl('checkout_billing_address'));

        
        if($request->isMethod('POST')) {
            $check = $request->get('typeCheckout');
            if($check == 0){
                $session->set('guest', 'true');
                return $this->redirect($this->generateUrl('checkout_billing_address'));
            }
            else if($check == 1){
                $session->set('guest', 'false');
                return $this->redirect($this->generateUrl('signup'));
            }

        }
    	return array();
    }


    
    /**
     * @Route("/billing_address", name="checkout_billing_address")
     * @Template()
     */
    public function billingAddressAction(Request $request) {
        $session = $this->get('session');
        $objAddress = new Address();
        $form = $this->createForm(new AddressType(false), $objAddress);
        
        $form->add('Next', 'submit', array(
            'attr' => array(
                'class' => 'btn',
            ),
        ));
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $user = $this->getUser();
                $objAddress->setClient($user);
            }

            $em->persist($objAddress);
            $em->flush();
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
        $form = $this->createForm(new AddressType(true), $objAddress);
        
         $form->add('Next', 'submit', array(
            'attr' => array(
                'class' => 'btn',
            ),
        ));
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            if($form->get('usePrev')->getData()) {
                $objAddress = $session->get('billingAddress');
            } 
            else {
                if($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) 
                {
                    $user = $this->getUser();
                    $objAddress->setClient($user);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($objAddress);
                $em->flush();  
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
        $session = $this->get('session');
        return array(
            'billing' => $session->get('billingAddress'),
            'shipping' => $session->get('shippingAddress'), 
            );
    }
}