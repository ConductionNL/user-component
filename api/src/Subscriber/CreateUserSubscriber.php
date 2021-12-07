<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use App\Service\LoginService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CreateUserSubscriber implements EventSubscriberInterface
{
    private UserService $userService;
    private LoginService $loginService;
    private Request $request;
    private ParameterBagInterface $parameterBag;
    private EntityManagerInterface $entityManager;

    public function __construct(UserService $userService, LoginService $loginService, ParameterBagInterface $parameterBag, EntityManagerInterface $entityManager)
    {
        $this->userService = $userService;
        $this->request = Request::createFromGlobals();
        $this->loginService = $loginService;
        $this->parameterBag = $parameterBag;
        $this->entityManager = $entityManager;
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
        $data = json_decode($event->getRequest()->getContent(), true);

        if (($route != 'api_users_post_collection' && $route != 'api_users_put_item')) {
            return;
        } elseif (
            $route == 'api_users_put_item' &&
            $user instanceof User &&
            $this->parameterBag->get('validate_current_password') &&
            $user->getCurrentPassword()
        ) {
            $check['password'] = $user->getCurrentPassword();
            $this->loginService->passwordCheck($event->getRequest()->get('previous_data'), $check);
        } elseif (
            $route == 'api_users_put_item' &&
            $this->parameterBag->get('validate_current_password') &&
            !$user->getCurrentPassword() &&
            (key_exists('password', $data) || !$user->getUsername() || $event->getRequest()->get('previous_data')->getUsername() !== $event->getRequest()->get('data')->getUsername())
        ) {
            throw new BadRequestException("The field 'currentPassword' is required");
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
