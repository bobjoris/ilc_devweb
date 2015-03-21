<?php

namespace Ilc\Bundle\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ilc\Bundle\ShopBundle\Entity\ClientOrderLine;
use Ilc\Bundle\ShopBundle\Entity\Product;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        $arrProducts = $this->getDoctrine()->getRepository('IlcShopBundle:Product')->findAll();
        $arrCategories = $this->getDoctrine()->getRepository('IlcShopBundle:Category')->findAll();
        return array(
            'products' => $arrProducts,
            'categories' => $arrCategories,
            );
    }

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
     * @Route("checkout/", name="checkout")
     * @Template()
     */
    public function checkoutAction()
    {
    	return array();
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
