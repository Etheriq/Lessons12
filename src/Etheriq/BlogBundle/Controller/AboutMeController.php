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
        $this->setLocale();
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("About me");

        return $this->render('EtheriqBlogBundle:pages:about.html.twig');
    }

    private function setLocale()
    {
        $session = $this->get('session');
        if ($session->get('blog_locale')) {
            $this->get('request')->setLocale($session->get('blog_locale'));
        }
    }

}
