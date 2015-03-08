<?php

namespace Ilc\Bundle\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("cart/", name="cart")
     * @Template()
     */
    public function cartAction()
    {
    	return array();
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
      return array();
    }
}
