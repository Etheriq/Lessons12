<?php
/**
 * Created by PhpStorm.
 * File: EtheriqTwigExtentionTest.php
 * User: Yuriy Tarnavskiy
 * Date: 16.01.14
 * Time: 10:08
 */

namespace Etheriq\BlogBundle\Tests\Twig\Extention;

class EtheriqTwigExtentionTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @dataProvider limitWordsData
     */
    public function testLimitWords($result, $inData)
    {
        $te = $this->getMockBuilder('Etheriq\BlogBundle\Twig\Extention\EtheriqTwigExtention')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->assertEquals($result, trim($te->limitWords($inData[0], $inData[1])));

    }

    /**
     *
     * @dataProvider ratingData
     */
    public function testRating($resultData, $inData)
    {
        $rating = $this->getMockBuilder('Etheriq\BlogBundle\Twig\Extention\EtheriqTwigExtention')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->assertEquals($resultData, $rating->rating($inData[0], $inData[1]));
    }

    public function ratingData()
    {
        return array(
            array(6.4, array(32, 5)),
            array(1.3, array(4, 3) ),
            array(2.6, array(18, 7))
        );
    }

    public function limitWordsData()
    {
        return array(
            array('lorem ipsum', array('lorem ipsum dolar siptic', 2)),
            array('Sed', array('Sed ante magna, tincidunt eleifend elementum', 1)),
            array('Proin et orci congue,', array('Proin et orci congue, facilisis dui at, mattis mauris.', 4)),
            array('Proin et orci', array('Proin et orci', 6))
        );
    }
}
