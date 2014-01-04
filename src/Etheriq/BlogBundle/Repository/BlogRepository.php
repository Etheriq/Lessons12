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
            ->createQuery('SELECT b FROM EtheriqBlogBundle:Blog b ORDER BY b.rating DESC')
            ->setMaxResults(5)
            ->getArrayResult();
    }

    public function findBlogsDESC()
    {

        return $this->getEntityManager()
            ->createQuery('SELECT b FROM EtheriqBlogBundle:Blog b ORDER BY b.created DESC');
    }

    public function findAllBlogs()
    {

        return $this->getEntityManager()
            ->createQuery('SELECT b FROM EtheriqBlogBundle:Blog b ORDER BY b.id');

    }

} 