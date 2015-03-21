<?php 

namespace Ilc\Bundle\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ilc\Bundle\ShopBundle\Entity\Group;
use Ilc\Bundle\ShopBundle\Entity\Client;

 
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
       /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


	public function load(ObjectManager $manager)
    {
        
        $user = new Client();

        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        $manager->persist($user);


        $user->setUsername('test@test.fr');
        $user->setSalt(md5(uniqid()));
        $user->setPassword($encoder->encodePassword('test', $user->getSalt()));
        
        $group = $manager->getRepository('IlcShopBundle:Group')->findOneBy(array('role' => 'ROLE_USER'));
        $user->addGroup($group);


        $manager->persist($user);

        $manager->flush();

    }
 
    public function getOrder()
    {
        return 2; 
    }
}