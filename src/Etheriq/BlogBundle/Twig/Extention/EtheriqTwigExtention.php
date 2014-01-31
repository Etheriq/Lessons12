<?php
/**
 * Created by PhpStorm.
 * File: EtheriqTwigExtention.php
 * User: Yuriy Tarnavskiy
 * Date: 02.01.14
 * Time: 16:16
 */

namespace Etheriq\BlogBundle\Twig\Extention;

use Etheriq\BlogBundle\Entity\Blog;

class EtheriqTwigExtention extends \Twig_Extension
{
    public function getName()
    {
        return 'blogGuestExtentionStringLimit';
    }

    public function getFilters()
    {
        return array(
            'limitWords' => new \Twig_Filter_Method($this, 'limitWords'),
            'rating' => new \Twig_Filter_Method($this, 'rating'),
            'tagView' => new \Twig_Filter_Method($this, 'tagView')
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('setLocaleImg', array($this, 'setLocaleImg'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('getCountComments', array($this, 'getCountComments'), array('is_safe' => array('html'))),
        );
    }

    public function getCountComments(Blog $blogComments)
    {
        $comments = $blogComments->getComments();

        return count($comments);
    }

    public function setLocaleImg($string)
    {
        switch ($string) {
            case 'en':
                $img = 'img/flag_great_britain.png';
                $alt = 'English';
                break;
            case 'ru':
                $img = 'img/flag_russia.png';
                $alt = 'Russian';
                break;
            case 'ua':
                $img = 'img/flag_ukraine.png';
                $alt = 'Ukrainian';
                break;
            default:
                $img = 'img/flag_great_britain.png';
                $alt = 'English';
        }

        return $img;
    }

    /**
     *
     * @param string $string
     */
    public function limitWords($string, $limit = 5, $link = null)
    {
        $str = explode(' ', $string);
        $countWords = count($str);

        if ($countWords <= $limit) {
            $lim = $countWords;
        } else {
            $lim = $limit;
        }

        $strResult = '';
        for ($i = 0; $i < $lim; $i++) {
            $strResult = $strResult.$str[$i]. ' ';
        }

        if ($link != null) {
            return $strResult.' <a href="'.$link.'"> ..... </a>';
        } else {
            return $strResult;
        }
    }

    /**
     *
     * @param integer $rating
     * @param integer $voters
     */
    public function rating($rating, $voters)
    {
        return round($rating / $voters, 1);
    }

}
