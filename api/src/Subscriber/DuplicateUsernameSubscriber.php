<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;;

class DuplicateUsernameSubscriber implements EventSubscriberInterface
{
    private $em;
    private $encoder;
    private $request;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->request = Request::createFromGlobals();
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['checkUsername', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function checkUsername(ViewEvent $event)
    {
        $user = $event->getControllerResult();
        $route = $event->getRequest()->attributes->get('_route');

        if (($route != 'api_users_post_collection' && $route != 'api_users_put_item') || (Request::METHOD_POST !== $event->getRequest()->getMethod() && Request::METHOD_PUT !== $event->getRequest()->getMethod())) {
            return;
        }

        if ($route == 'api_users_post_collection' && $newUser = $this->em->getRepository(User::class)->findOneBy(['username' => $user->getUsername()])) {
            throw new HttpException(409, 'Username is unavailable');
        } elseif ($route == 'api_users_put_item' && $event->getRequest()->get('previous_data')->getUsername() !== $event->getRequest()->get('data')->getUsername()) {
            if ($newUser = $this->em->getRepository(User::class)->findOneBy(['username' => $event->getRequest()->get('data')->getUsername()])) {
                throw new HttpException(409, 'Username is unavailable');
            }
        }

        return $user;
    }
}
