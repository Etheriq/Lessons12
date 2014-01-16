<?php
/**
 * Created by PhpStorm.
 * File: EtheriqTwigExtentionTest.php
 * User: Yuriy Tarnavskiy
 * Date: 16.01.14
 * Time: 10:08
 */

namespace Etheriq\BlogBundle\Tests\Twig\Extention;

use Etheriq\BlogBundle\Twig\Extention\EtheriqTwigExtention;

class EtheriqTwigExtentionTest extends \PHPUnit_Framework_TestCase
{
    public function testLimitWords()
    {

        $te = new EtheriqTwigExtention(null);

        $this->assertEquals('lorem ipsum', trim($te->limitWords('lorem ipsum dolar siptic', 2)));
        $this->assertEquals('Sed', trim($te->limitWords('Sed ante magna, tincidunt eleifend elementum', 1)));
        $this->assertEquals('Proin et orci congue,', trim($te->limitWords('Proin et orci congue, facilisis dui at, mattis mauris.', 4)));
    }

    public function testRating()
    {
        $rating = new EtheriqTwigExtention(null);

        $this->assertEquals(6.4, $rating->rating(32, 5));
        $this->assertEquals(1.3, $rating->rating(4, 3));
        $this->assertEquals(2.6, $rating->rating(18, 7));
    }
}
