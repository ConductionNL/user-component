<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Service\LoginService;
use Conduction\CommonGroundBundle\Service\SerializerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class LoginSubscriber implements EventSubscriberInterface
{
    private $em;
    private $encoder;
    private LoginService $loginService;
    private $request;
    private $serializer;
    private SerializerService $serializerService;

    public function __construct(LoginService $loginService, SerializerInterface $serializer)
    {
//        $this->em = $em;
//        $this->encoder = $encoder;
        $this->request = Request::createFromGlobals();
        $this->loginService = $loginService;
        $this->serializer = $serializer;
        $this->serializerService = new SerializerService($serializer);
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

        if (($route != 'api_users_login_collection' && $route != 'api_users_logout_collection') || Request::METHOD_POST !== $method) {
            return;
        }

        if ($route == 'api_users_login_collection') {
            $results = $this->loginService->login($event->getRequest()->getContent());
            $this->serializerService->setResponse($results, $event, ['groups' => 'login']);
        }

        if ($route == 'api_users_logout_collection') {
            $this->loginService->logout(json_decode($event->getRequest()->getContent(), true)['jwtToken']) ?
                $event->setResponse(new Response(null, 202)) :
                $event->setResponse(new Response(null, 422));
        }
    }

//    public function addAtId($json)
//    {
//        $json = json_decode($json, true);
//
//        $json['@id'] = '/users/'.$json['id'];
//
//        return $this->serializer->serialize(
//            $json,
//            'json',
//            ['enable_max_depth' => true]
//        );
//    }

//    public function userCheck($post)
//    {
//        if (!$user = $this->em->getRepository('App\Entity\User')->findOneBy(['username' => $post['username']])) {
//            throw new AccessDeniedHttpException('The username/password combination is invalid');
//        }
//
//        return $user;
//    }
//
//    public function passwordCheck($user, $post)
//    {
//        if ($user && !$this->encoder->isPasswordValid($user, $post['password'])) {
//            throw new AccessDeniedHttpException('The username/password combination is invalid');
//        }
//    }
}
