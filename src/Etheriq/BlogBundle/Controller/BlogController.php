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
use Symfony\Component\HttpFoundation\Request;
use Etheriq\BlogBundle\Form\BlogDetailType;

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

    public function showBlogInfoAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blogShow = $em->getRepository('EtheriqBlogBundle:Blog')->findOneBySlug($slug);

        if (!$blogShow) {
            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $slug));
            exit;
        }

        $allRequest = $request->createFromGlobals();
        $rate = $allRequest->request->all();

        $categorys = $em->getRepository('EtheriqBlogBundle:Category')->findAll();


        $blogShow->setTitle($blogShow->getTitle());
        $blogShow->setTextBlog($blogShow->getTextBlog());

        $ratingOld = $blogShow->getRating();
        $blogShow->setRating(0);

        $form = $this->createForm(new BlogDetailType(), $blogShow);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $blogToDb = $this->getDoctrine()->getManager();

            if ($rate['blogDetailed']['rating'] != 0) {
                $ratingNew = $ratingOld + $rate['blogDetailed']['rating'];
                $voters = $blogShow->getNumberOfVoters();

                $blogShow->setRating($ratingNew);
                $blogShow->setNumberOfVoters($voters + 1);

            } else {
                $blogShow->setRating($ratingOld);
            }

            $category = $em->getRepository('EtheriqBlogBundle:Category')->findOneById($rate['category_article']);
            $blogShow->setCategory($category);

            $blogToDb->flush();

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('EtheriqBlogBundle:pages:blogDetail.html.twig', array(
            'form' => $form->createView(),
            'rating' => $ratingOld,
            'voters' => $blogShow->getNumberOfVoters(),
            'categorys' => $categorys,
            'categotyBlogId' => $blogShow->getCategory()->getId()
        ));

    }

}