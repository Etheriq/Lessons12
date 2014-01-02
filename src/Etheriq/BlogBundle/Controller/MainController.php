<?php
/**
 * Created by PhpStorm.
 * File: MainController.php
 * User: Yuriy Tarnavskiy
 * Date: 02.01.14
 * Time: 11:36
 */

namespace Etheriq\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('EtheriqBlogBundle:pages:homepage.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('EtheriqBlogBundle:pages:about.html.twig');
    }

    public function guestAction()
    {
        return $this->render('EtheriqBlogBundle:pages:guest.html.twig');
    }

}