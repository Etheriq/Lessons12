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
        $crawler = $client->request('GET', '/en');

        $link = $crawler->filter('a:contains("About")')->first()->link();
        $crawler = $client->click($link);

//        $this->assertTrue($crawler->filter('html:contains("Proin vel molestie")')->count() > 0);
          $this->assertTrue($client->getResponse()->isSuccessful());
    }
//
//    public function testGuestTest()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('get', '/en/guest');
//
//        $this->assertRegExp('/More info/', $client->getResponse()->getContent());
//    }
//
//    public function testCountLinkInGuest()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/en/guest');
//
//        $this->assertEquals(5, $crawler->filter('a:contains("More info")')->count());
//
//    }

}
 