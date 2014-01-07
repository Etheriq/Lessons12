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

} 