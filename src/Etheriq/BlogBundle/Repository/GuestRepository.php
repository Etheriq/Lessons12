<?php
/**
 * Created by PhpStorm.
 * File: GuestRepository.php
 * User: Yuriy Tarnavskiy
 * Date: 02.01.14
 * Time: 15:12
 */

namespace Etheriq\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GuestRepository extends EntityRepository
{
    public function findDESCGuests()
    {

        return $this->getEntityManager()
            ->createQuery(
                'SELECT g FROM EtheriqBlogBundle:Guest g ORDER BY g.id DESC'
            );
    }

    public function findAllGuests()
    {

        return $this->getEntityManager()
            ->createQuery(
                'SELECT g FROM EtheriqBlogBundle:Guest g'
            );
    }
} 