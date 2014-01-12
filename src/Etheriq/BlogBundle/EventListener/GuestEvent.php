<?php
/**
 * Created by PhpStorm.
 * File: GuestEvent.php
 * User: Yuriy Tarnavskiy
 * Date: 09.12.13
 * Time: 0:16
 */

namespace Etheriq\BlogBundle\EventListener;

use Etheriq\BlogBundle\Entity\Guest;
use Symfony\Component\EventDispatcher\Event;

class GuestEvent extends Event
{
    protected $guest;

    public function __construct(Guest $guest)
    {
        $this->guest = $guest;
    }

    /**
     * @return mixed
     */
    public function getGuest()
    {
        return $this->guest;
    }

}
