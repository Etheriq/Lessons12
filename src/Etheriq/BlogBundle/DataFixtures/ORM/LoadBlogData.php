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

class LoadBlogData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 4;
    }

    public function load(ObjectManager $manager)
    {
        $blogs = Yaml::parse(file_get_contents(__DIR__."/data/dataBlog.yml"));

        foreach ($blogs['blogs'] as $key => $item) {
            $blog = new Blog();

            $blog
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

    protected function getReferencesFromArray(array $array)
    {
        $outputReferences = new ArrayCollection();

        foreach ($array as $reference) {
            $outputReferences->add($this->getReference($reference));
        }

        return $outputReferences;
    }

}
