<?php
/**
 * Created by PhpStorm.
 * File: GuestControllerTest.php
 * User: Yuriy Tarnavskiy
 * Date: 08.01.14
 * Time: 14:43
 */

namespace Etheriq\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GuestControllerTest extends WebTestCase
{
    public function testShowGuest()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/en/guest');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Created:")')->count());

    }
}
 