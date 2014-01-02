<?php
/**
 * Created by PhpStorm.
 * File: GuestController.php
 * User: Yuriy Tarnavskiy
 * Date: 02.01.14
 * Time: 15:06
 */

namespace Etheriq\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Etheriq\BlogBundle\Entity\Guest;
use Etheriq\BlogBundle\EventListener\RegisterEvent;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Etheriq\BlogBundle\Form\GuestType;
use Etheriq\BlogBundle\EventListener\GuestEvent;
use Symfony\Component\HttpFoundation\Response;

class GuestController extends Controller
{
    public function showGuestAction($page, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $em->getFilters()->disable('softdeleteable');  // to display removed data
        $query = $em->getRepository('EtheriqBlogBundle:Guest')->findDESCGuests();  // Order by DESC
//        $query2 = $em->getRepository('EtheriqBlogBundle:Guest')->findAllGuests();  // normal order
        $adapter = new DoctrineORMAdapter($query);
        $pagerFanta = new Pagerfanta($adapter);

        $pagerFanta->setMaxPerPage(5);

        try {
            $pagerFanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {

            return $this->render('EtheriqBlogBundle:pages:pageNotFound.html.twig', array('pageNumber' => $page));
        }

        $guest = new Guest();
        $form = $this->createForm(new GuestType(), $guest);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $guestToDb = $this->getDoctrine()->getManager();

//            $guestEvent = new GuestEvent($guest);
//            $dispatcher = $this->get('event_dispatcher');
//            $dispatcher->dispatch(RegisterEvent::GUEST_ADD, $guestEvent);

            $guestToDb->persist($guest);
            $guestToDb->flush();

            return $this->redirect($this->generateUrl('guest'));
        }

        return $this->render('EtheriqBlogBundle:pages:guest.html.twig', array(
            'fanta' => $pagerFanta,
            'form' => $form->createView()
        ));
    }

} 