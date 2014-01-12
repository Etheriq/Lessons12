<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 12.01.14
 * Time: 18:57
 */

namespace Etheriq\BlogBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Yaml\Yaml;
use Etheriq\BlogBundle\Entity\TagsCloud;

class LoadDataToTagsCloud extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 5;
    }

    public function load(ObjectManager $manager)
    {
        $dataArray = Yaml::parse(file_get_contents(__DIR__."/data/dataTagCloud.yml"));

        foreach ($dataArray['TagCloud'] as $dataTagCloud) {
            $tagsCloud = new TagsCloud();
            $tagsCloud->setTagCloudName($dataTagCloud['nameTag']);
            $tagsCloud->setTagCloudCount($dataTagCloud['countArticles']);
            $tagsCloud->setTagSlug($dataTagCloud['tagSlug']);

            $manager->persist($tagsCloud);
        }
        $manager->flush();
    }
}
