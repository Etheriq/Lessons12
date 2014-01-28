<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 05.01.14
 * Time: 18:34
 */

namespace Etheriq\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdditionalController extends Controller
{
    public function setLocaleAction($loc, Request $request)
    {
        $this->get('request')->setLocale($loc);

        $src = $request->get('src');
        $params = $this->get('router')->match($src);

        if(isset($params['slug'])) {

            return $this->redirect($this->generateUrl($params['_route'], array('_locale' => $loc, 'slug' => $params['slug'])));
        } else {

            return $this->redirect($this->generateUrl($params['_route'], array('_locale' => $loc)));
        }
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
