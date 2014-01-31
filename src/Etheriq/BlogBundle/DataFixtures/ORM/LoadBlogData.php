<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 03.01.14
 * Time: 22:14
 */

namespace Etheriq\BlogBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Yaml\Yaml;
use Etheriq\BlogBundle\Entity\Blog;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadBlogData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 7;
    }

    public function load(ObjectManager $manager)
    {
        $blogs = Yaml::parse(file_get_contents(__DIR__."/data/dataBlog.yml"));
        $users = $this->getUsers();
        foreach ($blogs['blogs'] as $key => $item) {
            $blog = new Blog();
            $randomAuthorId = mt_rand(0, 1);
            $blog
                ->setAuthor($users[$randomAuthorId])
                ->setTitle($item['title'])
                ->setPathImage($item['pictureSrc'])
                ->setNameImage($item['pictureName'])
                ->setTextBlog($item['textBlog'])
                ->setRating($item['rating'])
                ->setNumberOfVoters($item['numOfVot'])
                ->setCategory($this->getReference($item['category']))
                ->setTags($this->getReferencesFromArray($item['tags']));

            $manager->persist($blog);
        }

        $manager->flush();
    }

    protected function getUsers()
    {
        $fosUserManager = $this->container->get('fos_user.user_manager');

        $user = $fosUserManager->findUserBy(array('id' => 1));
        $admin = $fosUserManager->findUserBy(array('id' => 2));

        $users = array();
        $users[] = $user;
        $users[] = $admin;

        return $users;
    }

    protected function getReferencesFromArray(array $array)
    {
        $outputReferences = new ArrayCollection();

        foreach ($array as $reference) {
            $outputReferences->add($this->getReference($reference));
        }

        return $outputReferences;
    }
}
