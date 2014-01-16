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
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Etheriq\BlogBundle\Form\GuestType;
use Etheriq\BlogBundle\EventListener\GuestEvent;

class GuestController extends Controller
{
    public function showGuestAction($page, Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Guest book");

        $em = $this->getDoctrine()->getManager();
//        $em->getFilters()->disable('softdeleteable');  // to display removed data
        $query = $em->getRepository('EtheriqBlogBundle:Guest')->findDESCGuests();  // Order by DESC
//        $query = $em->getRepository('EtheriqBlogBundle:Guest')->findAllGuests();  // normal order
        $adapter = new DoctrineORMAdapter($query);
        $pagerFanta = new Pagerfanta($adapter);

        $pagerFanta->setMaxPerPage(5);

        try {
            $pagerFanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $page));
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

    public function showGuestInfoAction($slug, Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Guest book", $this->get("router")->generate("guest"));
        $breadcrumbs->addItem("Guest book detail");

        $em = $this->getDoctrine()->getManager();
        $guestShow = $em->getRepository('EtheriqBlogBundle:Guest')->findOneBySlug($slug);

        if (!$guestShow) {
            return $this->render('EtheriqBlogBundle:pages:guestPageNotFound.html.twig', array('pageNumber' => $slug));
            exit;
        }
        $guestShow->setNameGuest($guestShow->getNameGuest());
        $guestShow->setEmailGuest($guestShow->getEmailGuest());
        $guestShow->setBodyGuest($guestShow->getBodyGuest());

        $created = $guestShow->getCreated()->format('d.m.Y G:i');
        $updated = $guestShow->getUpdated()->format('d.m.Y G:i');

        $form = $this->createForm(new GuestType(), $guestShow);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $guestToDb = $this->getDoctrine()->getManager();

//            $guestEvent = new GuestEvent($guestShow);
//            $dispatcher = $this->get('event_dispatcher');
//            $dispatcher->dispatch(RegisterEvent::GUEST_EDIT, $guestEvent);

            $guestToDb->flush();

            return $this->redirect($this->generateUrl('guest'));
        }

        $deleteForm = $this->createDeleteForm($slug);

        return $this->render('EtheriqBlogBundle:pages:guestShowInfo.html.twig', array(
            'form' => $form->createView(),
            'created' => $created,
            'updated' => $updated,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteGuestItemAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $guestDelete = $em->getRepository('EtheriqBlogBundle:Guest')->findOneBySlug($slug);

//        $guestEvent = new GuestEvent($guestDelete);
//        $dispatcher = $this->get('event_dispatcher');
//        $dispatcher->dispatch(RegisterEvent::GUEST_DELETE, $guestEvent);

        $em->remove($guestDelete);
        $em->flush();

        return $this->redirect($this->generateUrl('guest'));
    }

    public function showLastGuestAction()
    {
        $em = $this->getDoctrine()->getManager();
        $guests = $em->getRepository('EtheriqBlogBundle:Guest')->fiveLastGuest();

        return $this->render('EtheriqBlogBundle:sidebar:lastGuest.html.twig', array('guests' => $guests));
    }

    private function createDeleteForm($slug)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('guest_deleteItem', array('slug' => $slug)))
            ->setMethod('DELETE')
            ->add('delete', 'submit', array('label' => 'Delete', 'attr' => array('class' => "btn btn-danger")))
            ->getForm();
    }
}
