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

class BlogController extends Controller
{
    public function showBlogMainPageAction($page)
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
        $catName = $cat->getCategoryName();
        $blogs = $cat->getBlogs();

        $adapter = new DoctrineCollectionAdapter($blogs);
        $pagerBlog = new Pagerfanta($adapter);
        $pagerBlog->setMaxPerPage(2);

        try {
            $pagerBlog->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {

            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $page));
        }

        return $this->render('EtheriqBlogBundle:pages:homepage.html.twig', array(
            'blogs' => $pagerBlog,
            'filter' => $catName
        ));
    }

    public function showBlogsByTagAction($page, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository('EtheriqBlogBundle:Tags')->find($id);
        $tagName = $tag->getTagName();
        $blogs = $tag->getBlogTags();

        $adapter = new DoctrineCollectionAdapter($blogs);
        $pagerBlog = new Pagerfanta($adapter);
        $pagerBlog->setMaxPerPage(5);

        try {
            $pagerBlog->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {

            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $page));
        }

        return $this->render('EtheriqBlogBundle:pages:homepage.html.twig', array(
            'blogs' => $pagerBlog,
            'filter' => $tagName
        ));
    }

    public function showBlogInfoAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $blogShow = $em->getRepository('EtheriqBlogBundle:Blog')->findOneBySlug($slug);

        if (!$blogShow) {
            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $slug));
            exit;
        }

        $blogShow->setTitle($blogShow->getTitle());
        $blogShow->setTextBlog($blogShow->getTextBlog());



    }

}