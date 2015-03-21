<?php 

namespace Ilc\Bundle\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ilc\Bundle\ShopBundle\Entity\Group;
 
class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
    {
    	$group = new Group();
        $group->setName('Membre');
        $group->setRole('ROLE_USER');

        $manager->persist($group);

        $manager->flush();
    }
 
    public function getOrder()
    {
        return 1; 
    }
}