<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 05.01.14
 * Time: 18:40
 */

namespace Etheriq\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutMeController extends Controller
{
    public function showAboutMePageAction()
    {
        return $this->render('EtheriqBlogBundle:pages:about.html.twig');
    }



} 