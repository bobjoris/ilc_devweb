<?php

namespace Ilc\Bundle\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ilc\Bundle\ShopBundle\Entity\ClientOrderLine;
use Ilc\Bundle\ShopBundle\Entity\Product;

class ProductController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Route("/category/{category}", name="index_category")
     * @Route("/category/{category}/sort/{sort}", name="index_category_sort")
     * @Template()
     */
    public function indexAction($category = null, $sort = null)
    {
        $category = ($category == null) ? 0 : $category;
        $sort = ($sort == null) ? 'name' : $sort;

        $arrProducts = $this->getDoctrine()->getRepository('IlcShopBundle:Product')->findProductsByCategory($category, $sort);
        $arrCategories = $this->getDoctrine()->getRepository('IlcShopBundle:Category')->findAll();

        return array(
            'products' => $arrProducts,
            'categories' => $arrCategories,
            'selectedCategory' => $category,
            'selectedSort' => $sort,
        );
    }
}
