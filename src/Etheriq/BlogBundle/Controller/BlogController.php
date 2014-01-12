<?php
/**
 * Created by PhpStorm.
 * File: MainController.php
 * User: Yuriy Tarnavskiy
 * Date: 02.01.14
 * Time: 11:36
 */

namespace Etheriq\BlogBundle\Controller;

use Etheriq\BlogBundle\Entity\Blog;
use Etheriq\BlogBundle\Entity\Tags;
use Etheriq\BlogBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Symfony\Component\HttpFoundation\Request;
use Etheriq\BlogBundle\Form\BlogDetailType;
use Pagerfanta\Adapter\FixedAdapter;
use Pagerfanta\Adapter\ArrayAdapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends Controller
{
    public function showBlogMainPageAction($page)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home");

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

    public function showBlogsByCategoryAction($page, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('EtheriqBlogBundle:Category')->findOneBySlug($slug);
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

    public function showBlogsByTagAction($page, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository('EtheriqBlogBundle:Tags')->findOneBySlug($slug);
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
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Blog in detail");

        $em = $this->getDoctrine()->getManager();
        $blogShow = $em->getRepository('EtheriqBlogBundle:Blog')->findOneBySlug($slug);

        if (!$blogShow) {
            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $slug));
            exit;
        }

        $allRequest = $request->createFromGlobals();
        $rate = $allRequest->request->all();

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

            if($blogShow->getNewTags() != null)
            {
                $newTags = explode(',', trim($blogShow->getNewTags()));

                foreach ($newTags as $item)
                {
                    $tag = new Tags();
                    $tag->setTagName(trim($item));

                    $blogToDb->persist($tag);
                    $blogShow->addTag($tag);
                }

            }
            if($blogShow->getNewCategory() != null)
            {
                $newCategory = explode(',', trim($blogShow->getNewCategory()));

                foreach ($newCategory as $item)
                {
                    $category = new Category();
                    $category->setCategoryName(trim($item));

                    $blogToDb->persist($category);
                    $blogShow->setCategory($category);
                }
            }

            $blogToDb->flush();

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('EtheriqBlogBundle:pages:blogDetail.html.twig', array(
            'form' => $form->createView(),
            'rating' => $ratingOld,
            'voters' => $blogShow->getNumberOfVoters(),
        ));

    }

    public function newBlogArticleAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Blog in detail");

        $blog = new Blog();

        $form = $this->createForm(new BlogDetailType(), $blog);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $newArticle = $this->getDoctrine()->getManager();

            $tags = $blog->getTags();

            $blog
                ->setTags($tags)
                ->setPicture('img/blog/bluz.jpg')
                ->setNumberOfVoters(1);

            if($blog->getNewTags() != null)
            {
                $newTags = explode(',', trim($blog->getNewTags()));

                foreach ($newTags as $item)
                {
                    $tag = new Tags();
                    $tag->setTagName(trim($item));

                    $newArticle->persist($tag);
                    $blog->addTag($tag);
                }

            }
            if($blog->getNewCategory() != null)
            {
                $newCategory = explode(',', trim($blog->getNewCategory()));

                foreach ($newCategory as $item)
                {
                    $category = new Category();
                    $category->setCategoryName(trim($item));

                    $newArticle->persist($category);
                    $blog->setCategory($category);
                }
            }


            $newArticle->persist($blog);
            $newArticle->flush();

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('EtheriqBlogBundle:pages:addNewBlogArticle.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function findAction(Request $request)
    {
        $allRequest = $request->createFromGlobals();
        $s = $allRequest->request->all();

        $search = trim($s['search']);

        if ($search == null or $search == ' ')
        {

            return $this->redirect($this->generateUrl('homepage'));
        }


        return $this->redirect($this->generateUrl('blog_search', array('search' => $search)));
    }

    public function searchBlogsByTitleAction($search=null, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $searchedBlogs = $em->getRepository('EtheriqBlogBundle:Blog')->searchArticlesByTitle($search);

        $adapter = new ArrayAdapter($searchedBlogs);
        $pagerBlog = new Pagerfanta($adapter);
        $pagerBlog->setMaxPerPage(5);

        try {
            $pagerBlog->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {

            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $page));
        }

        return $this->render('EtheriqBlogBundle:pages:homepage.html.twig', array(
            'blogs' => $pagerBlog,
            'filter' => $search
        ));
    }

}