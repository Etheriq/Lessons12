<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 12.01.14
 * Time: 19:34
 */

namespace Etheriq\BlogBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Etheriq\BlogBundle\Entity\TagsCloud;

class BlogServices
{
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function update()
    {
        $em = $this->doctrine->getManager();
        $tags = $this->doctrine->getRepository('EtheriqBlogBundle:Tags')->findAll();

        $tagsToArray = array();
        foreach ($tags as $tag) {
            $tagsToArray[] = array(
                'tagName' => $tag->getTagName(),
                'tagArticleCount' => count($tag->getBlogTags()),
                'tagSlug' => $tag->getSlug()
            );
        }

        $con = $this->doctrine->getConnection();
        $platform   = $con->getDatabasePlatform();
        $con->executeUpdate($platform->getTruncateTableSQL('tagsCloud', true /* whether to cascade */));

        foreach ($tagsToArray as $item)
        {
            $tagCloud = new TagsCloud();
            $tagCloud->setTagCloudName($item['tagName']);
            $tagCloud->setTagCloudCount($item['tagArticleCount']);
            $tagCloud->setTagSlug($item['tagSlug']);

            $em->persist($tagCloud);
        }
        $em->flush();

    }

} 