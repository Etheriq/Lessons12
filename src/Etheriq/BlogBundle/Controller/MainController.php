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
        $locale = $this->get('request')->getLocale();

        return $this->render('EtheriqBlogBundle:pages:homepage.html.twig', array('locale' => $locale));
    }

    public function aboutAction()
    {
        return $this->render('EtheriqBlogBundle:pages:about.html.twig');
    }

    public function setLocaleAction($loc)
    {
        $this->get('request')->setLocale($loc);
        return $this->redirect($this->generateUrl('homepage', array('_locale' => $loc) ));
    }


}