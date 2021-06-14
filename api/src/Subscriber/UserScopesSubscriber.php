<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserScopesSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['getUserScopes', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function getUserScopes(ViewEvent $event)
    {
        $method = $event->getRequest()->getMethod();
        $route = $event->getRequest()->attributes->get('_route');

        if ($route != 'api_users_get_scopes_item' && $method !== 'GET') {
            return;
        }
        $user = $this->em->getRepository('App\Entity\User')->findOneBy(['id' => $event->getRequest()->get('id')]);

        if ($user instanceof User) {
            $scopes = [];

            if (count($user->getUserGroups()) > 0) {
                foreach ($user->getUserGroups() as $group) {
                    if (count($group->getScopes()) > 0) {
                        foreach ($group->getScopes() as $scope) {
                            if (!in_array($scope->getCode(), $scopes)) {
                                array_push($scopes, $scope->getCode());
                            }
                        }
                    }
                }
            }
            $response = new Response(
                json_encode($scopes),
                Response::HTTP_OK,
                ['content-type' => 'application/json']
            );

            $event->setResponse($response);

        }

    }
}
