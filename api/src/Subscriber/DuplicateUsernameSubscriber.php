<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//use App\Service\MailService;
//use App\Service\MessageService;

class DuplicateUsernameSubscriber implements EventSubscriberInterface
{
    private $params;
    private $em;
    private $encoder;
    private $request;

    public function __construct(ParameterBagInterface $params, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->params = $params;
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
        $method = $event->getRequest()->getMethod();
        $route = $event->getRequest()->attributes->get('_route');

        if (($route != 'api_users_post_collection' && $route != 'api_users_put_item') || (Request::METHOD_POST !== $method && Request::METHOD_PUT !== $method)) {
            return;
        }

        if ($newUser = $this->em->getRepository(User::class)->findOneBy(['username' => $user->getUsername()])) {
            throw new HttpException(500, 'Username is unavailable');
        }

        return $user;
    }
}
