<?php
/**
 * Created by PhpStorm.
 * File: BlogControllerTest.php
 * User: Yuriy Tarnavskiy
 * Date: 15.01.14
 * Time: 10:49
 */

namespace Etheriq\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function testShowBlogMainPage()
     {
         $client = static::createClient();
         $crawler = $client->request('GET', '/');
 
         $link = $crawler->filter('a:contains("About me")')->first()->link();
         $crawler = $client->click($link);
 
         $this->assertTrue($crawler->filter('html:contains("Proin vel molestie")')->count() > 0);
     }

    public function testGuestTest()
    {
        $client = static::createClient();
        $crawler = $client->request('get', '/en/guest');

        $this->assertRegExp('/More info/', $client->getResponse()->getContent());
    }

    public function testCountLinkInGuest()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/guest');

        $this->assertEquals(5, $crawler->filter('a:contains("More info")')->count());

    }

} 