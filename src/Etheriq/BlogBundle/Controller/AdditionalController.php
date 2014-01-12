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

        $repository = $this->getDoctrine()->getRepository('EtheriqBlogBundle:TagsCloud');
        $tags = $repository->findAll();

        $tagsToArray = array();
        foreach ($tags as $tag) {
            $tagsToArray[] = array(
                'text' => $tag->getTagCloudName(),
                'weight' => $tag->getTagCloudCount(),
                'link' => $this->generateUrl('blog_tag', array('slug' => $tag->getTagSlug()))
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