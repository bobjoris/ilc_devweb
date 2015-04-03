<?php 

namespace Ilc\Bundle\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ilc\Bundle\ShopBundle\Entity\Category;
 
class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
    {
        $arrCat = ['Automatique', 'Chronographe', 'Quartz' ];

        foreach ($arrCat as $name) {
            $category = new Category();
            $category->setName($name); 
            $manager->persist($category);
        }
        
        $manager->flush();
    }
 
    public function getOrder()
    {
        return 3; 
    }
}