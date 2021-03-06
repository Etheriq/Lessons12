<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 03.01.14
 * Time: 19:39
 */

namespace Etheriq\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BlogRepository extends EntityRepository
{
    public function mostPopularArticles()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT b FROM EtheriqBlogBundle:Blog b ORDER BY b.rating/b.numberOfVoters DESC')
            ->setMaxResults(5)
            ->getArrayResult();
    }

    public function findBlogsDESC()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT b FROM EtheriqBlogBundle:Blog b ORDER BY b.created DESC')
            ->execute();
    }

    public function findAllBlogs()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT b FROM EtheriqBlogBundle:Blog b ORDER BY b.id DESC');

    }

    public function fiveLastBlogs()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT b FROM EtheriqBlogBundle:Blog b ORDER BY b.created DESC')
            ->setMaxResults(5)
            ->getArrayResult();
    }

    public function searchArticlesByTitle($title)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT b FROM EtheriqBlogBundle:Blog b where b.title like :titleSearch or b.textBlog like :titleSearch')
            ->setParameter('titleSearch', '%'.$title.'%')
            ->execute();
    }

}
