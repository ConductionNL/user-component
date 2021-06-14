<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class LoginSubscriber implements EventSubscriberInterface
{
    private $em;
    private $encoder;
    private $request;
    private $serializer;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->request = Request::createFromGlobals();
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['login', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function login(ViewEvent $event)
    {
        $method = $event->getRequest()->getMethod();
        $route = $event->getRequest()->attributes->get('_route');
        $contentType = $event->getRequest()->headers->get('accept');

        if (!$contentType) {
            $contentType = $event->getRequest()->headers->get('Accept');
        }

        if ($route != 'api_users_login_collection' || Request::METHOD_POST !== $method) {
            return;
        }

        $post = json_decode($this->request->getContent(), true);

        // Lets see if we can find the user
        $user = $this->userCheck($post);

        // Then lets check the password
        $this->passwordCheck($user, $post);

        // now we need to override the normal subscriber
        $json = $this->serializer->serialize(
            $user,
            'json',
            ['enable_max_depth' => true]
        );

        $response = new Response(
            $json,
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );

        $event->setResponse($response);
    }

    public function userCheck($post)
    {
        if (!$user = $this->em->getRepository(User::class)->findOneBy(['username' => $post['username']])) {
            throw new AccessDeniedHttpException('The username/password combination is invalid');
        }

        return $user;
    }

    public function passwordCheck($user, $post)
    {
        if ($user && !$this->encoder->isPasswordValid($user, $post['password'])) {
            throw new AccessDeniedHttpException('The username/password combination is invalid');
        }
    }
}
