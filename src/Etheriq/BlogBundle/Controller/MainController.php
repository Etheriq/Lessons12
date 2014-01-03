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
       $em = $this->getDoctrine()->getManager();
       $blog1 = $em->getRepository('EtheriqBlogBundle:Blog')->findOneById(2);


//        $tags = $blog1->getTags();
//
//        var_dump($tags->getTags()); exit;

        return $this->render('EtheriqBlogBundle:pages:homepage.html.twig', array(
//            'title' => $blog1->getTitle(),
//            'category' => $blog1->getCategory(),
//            'tags' => $blog1->getTags(),
            'blog' => $blog1
        ));
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