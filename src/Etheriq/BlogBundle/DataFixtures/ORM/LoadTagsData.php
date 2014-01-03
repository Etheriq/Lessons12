<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 03.01.14
 * Time: 21:46
 */

namespace Etheriq\BlogBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Etheriq\BlogBundle\Entity\Tags;

class LoadTagsData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 2;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getTagsArray() as $tagName) {
            $tag = new Tags();
            $tag->setTagName($tagName);
            $manager->persist($tag);
            //$this->addReference($tag);
        }

        $manager->flush();
    }

    protected function getTagsArray()
    {
        return array(
            "WEB",
            "HTML5",
            "CSS3",
            "PHP",
            "Linux",
            "Other",
            "Apache",
            "Doctrine",
            "Twig",
            "PHPStorm"
        );
    }
}