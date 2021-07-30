<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use App\Service\LoginService;
use Conduction\CommonGroundBundle\Service\SerializerService;
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

        if ($route != 'api_users_login_collection' || Request::METHOD_POST !== $method) {
            return;
        }

        $results = $this->loginService->login($event->getRequest()->getContent());

//        $post = json_decode($this->request->getContent(), true);

        // Lets see if we can find the user
//        $user = $this->userCheck($post);
//
//        // Then lets check the password
//        $this->passwordCheck($user, $post);

        $this->serializerService->setResponse();

        // now we need to override the normal subscriber


//        $json = $this->addAtId($json);
//
//        $response = new Response(
//            $json,
//            Response::HTTP_OK,
//            ['content-type' => 'application/json']
//        );
//
//        $event->setResponse($response);
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
