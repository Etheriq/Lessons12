<?php
/**
 * Created by PhpStorm.
 * File: AboutMeControllerTest.php
 * User: Yuriy Tarnavskiy
 * Date: 08.01.14
 * Time: 14:23
 */

namespace Etheriq\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AboutMeControllerTest extends WebTestCase
{
    public function testShowAboutMePage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/en/about');

//        $this->assertTrue($crawler->filter('html:contains("ABOUT")')->count() > 0);
//        $this->assertTrue($crawler->filter('html:contains("ABOUT")')->count() > 0);
        $this->assertGreaterThan(0, $crawler->filter('html:contains("ABOUT")')->count());
    }

}
 