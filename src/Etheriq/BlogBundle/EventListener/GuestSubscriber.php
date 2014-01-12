<?php

namespace Etheriq\BlogBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GuestSubscriber implements EventSubscriberInterface
{
    protected $mailer;

    public function setMailer(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'guest.edit'    => 'onGuestEdit',
            'guest.add'     => 'onGuestCreated',
            'guest.delete'  => 'onGuestDelete'
        );
    }

    public function onGuestEdit(GuestEvent $event)
    {
        $guest = $event->getGuest();

        $message = \Swift_Message::newInstance()
            ->setSubject('Данные пользователя '.$guest->getNameGuest().' отредактированы')
            ->setFrom('nobody@example.com')
            ->setTo('emris@uch.net')
            ->setBody("
            Данные пользователя с id=".$guest->getId()." были успешно изменены на ".$guest->getNameGuest()." (".$guest->getEmailGuest().")
            ");

        $this->mailer->send($message);
        $event->stopPropagation();
    }

    public function onGuestCreated(GuestEvent $event)
    {
        $guest = $event->getGuest();

        $message = \Swift_Message::newInstance()
            ->setSubject('Создан новый пользователь '.$guest->getNameGuest())
            ->setFrom('nobody@example.com')
            ->setTo('emris@uch.net')
            ->setBody("
Создан новый пользователь:\n
Login: ".$guest->getNameGuest().";\n
E-mail: ".$guest->getEmailGuest()."
");

        $this->mailer->send($message);
        $event->stopPropagation();
    }

    public function onGuestDelete(GuestEvent $event)
    {
        $guest = $event->getGuest();

        $message = \Swift_Message::newInstance()
            ->setSubject('Был удален пользователь '.$guest->getNameGuest())
            ->setFrom('nobody@example.com')
            ->setTo('emris@uch.net')
            ->setBody("
Данные удаленного пользователя:\n
id: ".$guest->getId().";\n
Login: ".$guest->getNameGuest().";\n
E-mail: ".$guest->getEmailGuest()."
");

        $this->mailer->send($message);
        $event->stopPropagation();
    }

}
