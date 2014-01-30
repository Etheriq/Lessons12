<?php
/**
 * Created by PhpStorm.
 * File: LoadUsers.php
 * User: Yuriy Tarnavskiy
 * Date: 30.01.14
 * Time: 12:43
 */

namespace Etheriq\BlogBundle\DataFixtures;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Etheriq\AdminBlogBundle\Entity\User;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers   extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function getOrder()
    {
        return 6;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $fosUserManager = $this->container->get('fos_user.user_manager');

        $user = new User();
        $user->setUsername('User');
        $user->addRole('ROLE_USER');
        $user->setPlainPassword('user');
        $user->setEmail('user@tt.tt');
        $user->setEnabled(true);
        $fosUserManager->updateUser($user);
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('Admin');
        $admin->addRole('ROLE_SUPER_USER');
        $admin->setPlainPassword('admin');
        $admin->setEmail('admin@tt.tt');
        $admin->setEnabled(true);
        $fosUserManager->updateUser($admin);
        $manager->persist($admin);

        $manager->flush();
    }
}