<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Service\UserService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;;

class CreateUserSubscriber implements EventSubscriberInterface
{
    private UserService $userService;
    private Request $request;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
                $user = $this->userService->setPassword($user, $user->getPassword());
            }
        } catch (\Throwable $e) {
            $user = $this->userService->setPassword($user, $user->getPassword());
        }

        return $user;
    }
}
