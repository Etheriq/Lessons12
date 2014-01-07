<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 03.01.14
 * Time: 21:58
 */

namespace Etheriq\BlogBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Etheriq\BlogBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 3;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getCategoryArray() as $categoryName) {
            $category = new Category();
            $category->setCategoryName($categoryName);
            $manager->persist($category);
            $this->addReference($categoryName, $category);
        }

        $manager->flush();
    }

    protected function getCategoryArray()
    {
        return array(
            "Symfony",
            "CMS",
            "Joomla",
            "Drupal",
            "Yii",
            "Bluz",
            "Zend",
            "WordPress",
            "HTML",
        );
    }

} 