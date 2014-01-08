<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 08.01.14
 * Time: 22:38
 */

namespace Etheriq\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function testShowBlogMainPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler->filter('a:contains("About me")')->eq(0)->link();
        $crawler = $client->click($link);

        $this->assertTrue($crawler->filter('html:contains("Proin vel molestie")')->count() > 0);
    }

    public function testGuestTest()
    {
        $client = static::createClient();
        $client->request('get', '/en/guest');

        $this->assertRegExp('/More info/', $client->getResponse()->getContent());
    }

}
 