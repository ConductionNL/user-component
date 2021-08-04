<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Service\LoginService;
use App\Service\SigningTokenService;
use Conduction\CommonGroundBundle\Service\SerializerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class TokenSubscriber implements EventSubscriberInterface
{
    private SerializerInterface $serializer;
    private SigningTokenService $signingTokenService;
    private SerializerService $serializerService;

    public function __construct(SigningTokenService $signingTokenService, SerializerInterface $serializer)
    {
//        $this->em = $em;
//        $this->encoder = $encoder;
        $this->signingTokenService = $signingTokenService;
        $this->serializer = $serializer;
        $this->serializerService = new SerializerService($serializer);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['token', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function token(ViewEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');

        switch($route){
            case 'api_users_get_token_item':
                $this->getToken($event);
                break;
            case 'api_users_use_token_collection':
                $this->useToken($event);
                break;
            default:
                break;
        }
    }

    public function getToken(ViewEvent $event): void
    {
        $token = $this->signingTokenService->createToken($event->getRequest());
        $this->serializerService->setResponse($token, $event, ['attributes' => ['token']]);
    }

    public function useToken(ViewEvent $event): void
    {
        $values = json_decode($event->getRequest()->getContent(), true);
        if(!key_exists('token', $values)){
            $event->setResponse(new Response(null, 404));
            return;
        }
        $token = $this->signingTokenService->validateToken($values['token']);
        if(!$token){
            $event->setResponse(new Response(null, 404));
            return;
        }
        switch($token->getType()){
            case 'SET_PASSWORD':
                $result = $this->signingTokenService->setPassword($token, $values['password']);
                break;
            case 'VALIDATE_EMAIL':
                $result = $this->signingTokenService->setEmailValidation($token);
                break;
            default:
                $result = true;
                break;
        }
        if($result){
            $event->setResponse(new Response(null, 202));
        } else {
            $event->setResponse(new Response(null, 404));
        }
    }
}
