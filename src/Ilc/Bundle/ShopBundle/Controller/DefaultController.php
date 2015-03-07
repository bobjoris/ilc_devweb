<?php

namespace Ilc\Bundle\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("cart/")
     * @Template()
     */
    public function cartAction()
    {
    	return array();
    }

    /**
     * @Route("checkout/")
     * @Template()
     */
    public function checkoutAction()
    {
    	return array();
    }
}
