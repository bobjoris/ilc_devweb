<?php

namespace Ilc\Bundle\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ilc\Bundle\ShopBundle\Entity\ClientOrderLine;
use Ilc\Bundle\ShopBundle\Entity\Product;

class CartController extends Controller
{
	/**
     * @Route("cart/", name="cart")
     * @Template()
     */
    public function cartAction()
    {
        $session = $this->get('session');

        $cart = $session->get('cart');

        if($cart == null) {
            $cart = array();
        }

    	return array(
            'cart' => $cart,
            );
    }


     /**
     * @Route("add_cart/", name="add_cart")
     */
    public function addToCartAction(Request $request) {
        $session = $this->get('session');

        $cart = $session->get('cart');

        if($cart == null) {
            $cart = array();
        }

        if($request->isMethod('POST')) {
            $id = $request->get('id');
            
            $product = $this->getDoctrine()->getRepository('IlcShopBundle:Product')->find($id);
            $index = 0; $qty = 0;
            foreach ($cart as $line) {
                if($line->getProduct()->getId() == $id) {
                    $qty = $line->getQuantity();
                    break;
                }

                $index++;
            }

            if($qty > 0) {
                unset($cart[$index]);
                $cart = array_values($cart);
            }

            $line = new ClientOrderLine();
            $line->setProduct($product);
            $line->setQuantity(++$qty);

            $cart[] = $line;

            $session->set('cart', $cart);
        } 

        
        $response = array(
            'code' => 0,
            'message' => 'ok',
        );
        
        return new Response(json_encode($response));
    }

    /**
     * @Route("detele_item_cart/", name="delete_item_cart")
     */
    public function removeItemCartAction() {
    	$session = $this->get('session');
    	$cart = $session->get('cart');
    	$request = $this->get('request');
        

        if($cart == null) {
           	$response = array(
           		'code' => -1,
           		'message' => 'panier vide',
           	);

           	return new Response(json_encode($response));
        }
        else {
        	if($request->isMethod('POST')) {
        		$id = $request->get('id');

        		$index = 0; $isFound = false;
	            foreach ($cart as $line) {
	                if($line->getProduct()->getId() == $id) {
	                    $isFound = true;
	                    break;
	                }

	                $index++;
	            }

	            if($isFound) {
	                unset($cart[$index]);
	                $cart = array_values($cart);
	            }
        		
                $session->set('cart', $cart);

                $response = array(
           			'code' => 0,
           			'message' => 'ok',
           		);

           		return new Response(json_encode($response));
            }

            $response = array(
       			'code' => -1,
       			'message' => 'pas de parametre',
           	);

           	return new Response(json_encode($response));
        }
    }


    /**
     * @Route("update_item_cart/", name="update_item_cart")
     */
    public function updateItemCartAction() {
    	$session = $this->get('session');
    	$cart = $session->get('cart');
    	$request = $this->get('request');

    	if($cart == null) {
           	$response = array(
           		'code' => -1,
           		'message' => 'panier vide',
           	);

           	return new Response(json_encode($response));
        }
        else {
        	if($request->isMethod('POST')) {
        		$id = $request->get('id');
        		$qty = $request->get('qty');

        		$total = 0;
	            foreach ($cart as $line) {
	                if($line->getProduct()->getId() == $id) {
	                    $line->setQuantity($qty);
	                    $total = $qty * $line->getProduct()->getPrice();
	                    break;
	                }
	            }
        		
                $session->set('cart', $cart);

                $response = array(
           			'code' => 0,
           			'message' => 'ok',
           			'total' => $total,
           		);

           		return new Response(json_encode($response));
            }

            $response = array(
       			'code' => -1,
       			'message' => 'pas de parametre',
           	);

           	return new Response(json_encode($response));
    	}
    }


    /**
     * @Route("refresh_item_cart/", name="refresh_item_cart")
     */
    public function refreshItemCartAction() {
        $session = $this->get('session');
        $cart = $session->get('cart');

        $quantity = self::countItemCart($cart);

        $response = array(
            'quantity' => $quantity,
        );

        return new Response(json_encode($response));
    }

    /**
     * @Route("header_info/", name="header_info")
     * @Template()
     */
    public function headerInfoAction()
    {
        $session = $this->get('session');
        $cart = $session->get('cart');
        $quantity = self::countItemCart($cart);
      return array(
        'quantity' => $quantity,
        );
    }


    private function countItemCart($cart) {
        $quantity = 0;

        if($cart != null) {
            foreach ($cart as $line) {
                $quantity += $line->getQuantity();
            }
        }

        return $quantity;
    }
}