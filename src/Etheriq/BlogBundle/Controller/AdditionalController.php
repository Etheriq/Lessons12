<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 05.01.14
 * Time: 18:34
 */

namespace Etheriq\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdditionalController extends Controller
{
    public function setLocaleAction($loc)
    {
        $this->get('request')->setLocale($loc);
        return $this->redirect($this->generateUrl('homepage', array('_locale' => $loc) ));
    }

    public function getArrayTags()
    {
        $repository = $this->getDoctrine()->getRepository('EtheriqBlogBundle:Tags');
        $tags = $repository->findAll();

        $tagsToArray = array();
        foreach ($tags as $tag) {
            $tagsToArray[] = array(
                'text' => $tag->getTagName(),
                'weight' => count($tag->getBlogTags()),
                'link' => $this->generateUrl('blog_tag', array('slug' => $tag->getSlug()))
            );
        }

        return $tagsToArray;
    }

    public function showTagsAction()
    {
        $tags = $this->getArrayTags();

        return $this->render('EtheriqBlogBundle:sidebar:showTagsForBlogSidebar.html.twig', array('tags' => $tags));
    }

} 