<?php
/**
 * Created by PhpStorm.
 * File: EtheriqTwigExtention.php
 * User: Yuriy Tarnavskiy
 * Date: 02.01.14
 * Time: 16:16
 */

namespace Etheriq\BlogBundle\Twig\Extention;

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

    /**
     *
     * @param string $string
     * @param string $link
     */
    public function tagView($string, $link)
    {
        $scale = mt_rand(80, 150);

        return "<a href=".$link."><span style='font-size: $scale%'>$string</span></a>";
    }

}
