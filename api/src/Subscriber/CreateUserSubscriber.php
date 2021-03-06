<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserSubscriber implements EventSubscriberInterface
{
    private $encoder;
    private $request;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->request = Request::createFromGlobals();
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['createUser', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function createUser(ViewEvent $event)
    {
        $user = $event->getControllerResult();
        $route = $event->getRequest()->attributes->get('_route');

        if (($route != 'api_users_post_collection' && $route != 'api_users_put_item')) {
            return;
        }

        try {
            if ($event->getRequest()->get('previous_data')->getPassword() !== $event->getRequest()->get('data')->getPassword()) {
                $encoded = $this->encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($encoded);
            }
        } catch (\Throwable $e) {
            $encoded = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
        }

        return $user;
    }
}
