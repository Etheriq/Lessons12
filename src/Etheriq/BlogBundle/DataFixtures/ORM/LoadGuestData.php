<?php
/**
 * Created by PhpStorm.
 * File: loadGuestData.php
 * User: Yuriy Tarnavskiy
 * Date: 02.01.14
 * Time: 15:19
 */

namespace Etheriq\BlogBundle\DataFixtures;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Yaml\Yaml;
use Etheriq\BlogBundle\Entity\Guest;

class LoadGuestData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $dataArray = Yaml::parse(file_get_contents(__DIR__."/data/dataGuest.yml"));

        foreach ($dataArray['Guests'] as $dataGuest)
        {
            $guest = new Guest();

            $guest->setNameGuest($dataGuest['nameGuest']);
            $guest->setEmailGuest($dataGuest['emailGuest']);
            $guest->setBodyGuest($dataGuest['bodyGuest']);

            $manager->persist($guest);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

} 