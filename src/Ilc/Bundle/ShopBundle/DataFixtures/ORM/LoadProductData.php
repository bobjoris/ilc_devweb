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
        $category = $manager->getRepository('IlcShopBundle:Category')->find(1);

        $product = new Product();
        $product->setName('Slip Kangourou'); 
        $product->setCategory($category);
        $product->setPrice(20);
        $product->setImage('http://placekitten.com/g/281/289');
        $manager->persist($product);

        $product = new Product();
        $product->setName('Slip Kiwi'); 
        $product->setCategory($category);
        $product->setPrice(10.3);
        $product->setImage('http://placekitten.com/g/281/289');
        $manager->persist($product);

        $product = new Product();
        $product->setName('Slip Chat'); 
        $product->setCategory($category);
        $product->setPrice(20.5);
        $product->setImage('http://placekitten.com/g/281/289');
        $manager->persist($product);

        $product = new Product();
        $product->setName('Slip Crocodile'); 
        $product->setCategory($category);
        $product->setPrice(2000.00);
        $product->setImage('http://placekitten.com/g/281/289');
        $manager->persist($product);
        $manager->flush();
    }
 
    public function getOrder()
    {
        return 4; 
    }
}