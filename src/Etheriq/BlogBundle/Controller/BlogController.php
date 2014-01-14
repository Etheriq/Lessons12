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
use Pagerfanta\Adapter\ArrayAdapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BlogController extends Controller
{
    public function showBlogMainPageAction($page)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home");

        $em = $this->getDoctrine()->getManager();
//        $em->getFilters()->disable('softdeleteable');  // to display removed data
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
        if ($cat == null) {
            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $slug));
        }
        $catName = $cat->getCategoryName();
        $blogs = $cat->getBlogs();

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
            'filter' => $catName
        ));
    }

    public function showBlogsByTagAction($page, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository('EtheriqBlogBundle:Tags')->findOneBySlug($slug);
        if ($tag == null) {
            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $slug));
        }
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

        $editForm = $this->createEditForm($slug);
        return $this->render('EtheriqBlogBundle:pages:blogShow.html.twig', array(
            'article' => $blogShow,
            'edit_form' => $editForm->createView(),
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

        if ($form->isValid()) {
            $newArticle = $this->getDoctrine()->getManager();

            $tags = $blog->getTags();

            $blog
                ->setTags($tags)
                ->setNumberOfVoters(1);

            if ($blog->getNewTags() != null) {
                $newTags = explode(',', trim($blog->getNewTags()));

                foreach ($newTags as $item) {
                    $tag = new Tags();
                    $tag->setTagName(trim($item));

                    $newArticle->persist($tag);
                    $blog->addTag($tag);
                }

            }
            if ($blog->getNewCategory() != null) {
                $newCategory = explode(',', trim($blog->getNewCategory()));

                foreach ($newCategory as $item) {
                    $category = new Category();
                    $category->setCategoryName(trim($item));

                    $newArticle->persist($category);
                    $blog->setCategory($category);
                }
            }

            $blog->uploadImage('new');

            $blog->setNewTags(null);
            $blog->setNewCategory(null);
            $newArticle->persist($blog);
            $newArticle->flush();

            $this->get('etheriq.tagscloud')->update();

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('EtheriqBlogBundle:pages:addNewBlogArticle.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function findAction(Request $request)
    {
        try {
        $allRequest = $request->createFromGlobals();
        $s = $allRequest->request->all();

        $search = strip_tags(trim($s['search']));

        if ($search == null or $search == ' ') {
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->redirect($this->generateUrl('blog_search', array('search' => $search)));
        } catch (NotFoundHttpException $e) {
            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => ''));
        }
    }

    public function searchBlogsByTitleAction($search=null, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $searchedBlogs = $em->getRepository('EtheriqBlogBundle:Blog')->searchArticlesByTitle($search);

        $adapter = new ArrayAdapter($searchedBlogs);
        $pagerBlog = new Pagerfanta($adapter);
        $pagerBlog->setMaxPerPage(5);

            $pagerBlog->setCurrentPage($page);

        return $this->render('EtheriqBlogBundle:pages:homepage.html.twig', array(
            'blogs' => $pagerBlog,
            'filter' => $search
        ));
    }

    public function editBlogInfoAction($slug, Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Blog in detail", $this->get("router")->generate("blog_showInfo", array('slug' => $slug)));
        $breadcrumbs->addItem("Edit Article");

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

            if ($blogShow->getNewTags() != null) {
                $newTags = explode(',', trim($blogShow->getNewTags()));

                foreach ($newTags as $item) {
                    $tag = new Tags();
                    $tag->setTagName(trim($item));

                    $blogToDb->persist($tag);
                    $blogShow->addTag($tag);
                }

            }
            if ($blogShow->getNewCategory() != null) {
                $newCategory = explode(',', trim($blogShow->getNewCategory()));

                foreach ($newCategory as $item) {
                    $category = new Category();
                    $category->setCategoryName(trim($item));

                    $blogToDb->persist($category);
                    $blogShow->setCategory($category);
                }
            }

            $blogShow->uploadImage('edit');
            $blogShow->setNewTags(null);
            $blogShow->setNewCategory(null);
            $blogToDb->flush();

            $this->get('etheriq.tagscloud')->update();

            return $this->redirect($this->generateUrl('homepage'));
        }

            $deleteForm = $this->createDeleteForm($slug);

        return $this->render('EtheriqBlogBundle:pages:blogEdit.html.twig', array(
            'form' => $form->createView(),
            'rating' => $ratingOld,
            'voters' => $blogShow->getNumberOfVoters(),
            'delete_form' => $deleteForm->createView(),
            'oldImage' => $blogShow->getPathImage()
        ));

    }

    public function deleteBlogInfoAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('EtheriqBlogBundle:Blog')->findOneBy(array('slug' => $slug));

        if (!$article) {
            throw $this->createNotFoundException("Not found entity $slug.");
        }

        $em->remove($article);
        $em->flush();

        $this->get('etheriq.tagscloud')->update();

        return $this->redirect($this->generateUrl('homepage'));
    }


    private function createEditForm($slug)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_edit', array('slug' => $slug)))
            ->setMethod('PUT')
            ->add('edit', 'submit', array('label' => 'Edit', 'attr' => array('class' => "btn btn-warning btn-xs")))
            ->getForm();
    }

    private function createDeleteForm($slug)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_delete', array('slug' => $slug)))
            ->setMethod('DELETE')
            ->add('delete', 'submit', array('label' => 'Delete', 'attr' => array('class' => "btn btn-danger")))
            ->getForm();
    }



}
