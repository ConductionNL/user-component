<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

//use App\Service\MailService;
//use App\Service\MessageService;

class LoginSubscriber implements EventSubscriberInterface
{
    private $params;
    private $em;
    private $encoder;
    private $request;
    private $serializer;

    public function __construct(ParameterBagInterface $params, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer)
    {
        $this->params = $params;
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
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $route = $event->getRequest()->attributes->get('_route');
        $contentType = $event->getRequest()->headers->get('accept');

        if (!$contentType) {
            $contentType = $event->getRequest()->headers->get('Accept');
        }

        //var_dump($route);
        if ($route != 'api_users_login_collection' || Request::METHOD_POST !== $method) {
            return;
        }

        // Okey lets find the user based on its email

        // whatever *your* User object is
        $post = json_decode($this->request->getContent(), true);

        // Lets see if we can find the user
        if (!$user = $this->em->getRepository(User::class)->findOneBy(['username' => $post['username']])) {
            Throw new AccessDeniedHttpException('The username/password combination is invalid');
        }

        // Then lets check the pasword
        if ($user && !$this->encoder->isPasswordValid($user, $post['password'])) {
            Throw new AccessDeniedHttpException('The username/password combination is invalid');
        } else {
            // Everything is okey, so lets return the user

            // Lets set a return content type
            switch ($contentType) {
                case 'application/json':
                    $renderType = 'json';
                    break;
                case 'application/ld+json':
                    $renderType = 'jsonld';
                    break;
                case 'application/hal+json':
                    $renderType = 'jsonhal';
                    break;
                default:
                    $contentType = 'application/json';
                    $renderType = 'json';
            }

            // now we need to overide the normal subscriber
            $json = $this->serializer->serialize(
                $user,
                $renderType,
                ['enable_max_depth' => true]
            );

            $response = new Response(
                $json,
                Response::HTTP_OK,
                ['content-type' => $contentType]
            );
        }

        $event->setResponse($response);
    }
}
