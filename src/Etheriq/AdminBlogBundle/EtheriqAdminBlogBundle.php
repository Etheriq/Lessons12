<?php

namespace Etheriq\AdminBlogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EtheriqAdminBlogBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
