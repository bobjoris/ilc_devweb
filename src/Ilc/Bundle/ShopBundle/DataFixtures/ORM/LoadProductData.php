<?php 

namespace Ilc\Bundle\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ilc\Bundle\ShopBundle\Entity\Product;
use Ilc\Bundle\ShopBundle\Entity\Category;
 
class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
    {

        $arrNames = [
        'MontBlanc Heritage Spirit date',
        'MontBlanc Bohème Date',
        'MontBlanc Chronographe Timewalker',
        'Omega Speedmaster Moonwatch',
        'Flik Flak Magical Unicorn',
        'Omega De Ville Hour Vision',
        ];
        $arrCategories = [
        1,
        3,
        2,
        2,
        3,
        1,
        ];
        $arrPrice  = [
        2170,
        1505,
        5400,
        4800,
        37,
        4900,
        ];
        $arrImage = [
        'http://www.montblanc.com/content/dam/mtb/products/watches/111/622/111622/191408-ecom-retina-01.png.adapt.1500.1500.png',
        'http://www.montblanc.com/content/dam/mtb/products/watches/111/206/111206/191341-ecom-retina-01.png.adapt.1500.1500.png',
        'http://www.montblanc.com/content/dam/mtb/products/watches/111/197/111197/195922-ecom-retina-01.png.adapt.1500.1500.png',
        'http://www.lepage.fr/media/catalog/product/cache/2/image/9df78eab33525d08d6e5fb8d27136e95/3/1/31133423001002.jpg',
        'http://api2.swatch.com/flikflak/images/product/ZFBNP033/fa000/ZFBNP033_fa000_sr8.jpg',
        'http://www.lepage.fr/media/catalog/product/cache/2/image/9df78eab33525d08d6e5fb8d27136e95/5/7/5792-6170-4-omega-omega-de-ville-co-axial-cadran-blanc-bracelet-cuir-noir-43113412102001.jpg',
        ];

        for($i = 0; $i < count($arrNames); $i++) {
            $category = $manager->getRepository('IlcShopBundle:Category')->find($arrCategories[$i]);
            $product = new Product();
            $product->setName($arrNames[$i]); 
            $product->setCategory($category);
            $product->setPrice($arrPrice[$i]);
            $product->setImage($arrImage[$i]);
            $manager->persist($product);
        }

        $manager->flush();
    }
 
    public function getOrder()
    {
        return 4; 
    }
}