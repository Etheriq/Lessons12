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
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;

class MainController extends Controller
{
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('EtheriqBlogBundle:Blog')->findBlogsDESC();  // Order by created DESC
//        $query = $em->getRepository('EtheriqBlogBundle:Blog')->findAllBlogs();  // order by id DESC
        $adapter = new DoctrineORMAdapter($query);
        $pagerBlog = new Pagerfanta($adapter);
        $pagerBlog->setMaxPerPage(5);

        try {
            $pagerBlog->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {

            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $page));
        }

        return $this->render('EtheriqBlogBundle:pages:homepage.html.twig', array(
            'blogs' => $pagerBlog
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

    public function showLastGuestAction()
    {
        $em = $this->getDoctrine()->getManager();
        $guests = $em->getRepository('EtheriqBlogBundle:Guest')->fiveLastGuest();

        return $this->render('EtheriqBlogBundle:sidebar:lastGuest.html.twig', array('guests' => $guests));
    }

    public function showLastArticlesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $blogs = $em->getRepository('EtheriqBlogBundle:Blog')->fiveLastBlogs();

        return $this->render('EtheriqBlogBundle:sidebar:lastArticleFromBlog.html.twig', array('blogs' => $blogs));
    }

    public function showArticlesByRatingAction()
    {
        $em = $this->getDoctrine()->getManager();
        $blogs = $em->getRepository('EtheriqBlogBundle:Blog')->mostPopularArticles();

        return $this->render('EtheriqBlogBundle:sidebar:mostPopularBlogArticles.html.twig', array('blogs' => $blogs));
    }

    public function showBlogsByCategoryAction($page, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('EtheriqBlogBundle:Category')->find($id);
        $blogs = $cat->getBlogs();

        $adapter = new DoctrineCollectionAdapter($blogs);
        $pagerBlog = new Pagerfanta($adapter);
        $pagerBlog->setMaxPerPage(2);

        try {
            $pagerBlog->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {

            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $page));
        }

        return $this->render('EtheriqBlogBundle:pages:homepage.html.twig', array('blogs' => $pagerBlog));
    }

}