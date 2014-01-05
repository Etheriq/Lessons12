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
            'rating' => new \Twig_Filter_Method($this, 'rating')
        );
    }

    public function limitWords($string, $limit=5, $link='#')
    {
        $str = explode(' ', $string);
        $countWords = count($str);

        if ($countWords <= $limit)
        {
            $lim = $countWords;
        } else {
            $lim = $limit;
        }

        $strResult = '';
        for ($i = 0; $i < $lim; $i++)
        {
            $strResult = $strResult.$str[$i]. ' ';
        }

        return $strResult.' <a href="'.$link.'"> ..... </a>';
    }

    public function rating($rating, $voters)
    {

        return round($rating / $voters, 1);
    }

} 