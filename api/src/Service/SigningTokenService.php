<?php


namespace App\Service;


use App\Entity\SigningToken;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SigningTokenService
{
    private EntityManagerInterface $entityManager;
    private ParameterBagInterface $parameterBag;
    private UserService $userService;

    public function __construct(LayerService $layerService, UserService $userService)
    {
        $this->entityManager = $layerService->getEntityManager();
        $this->parameterBag = $layerService->getParameterBag();
        $this->userService = $userService;
    }

    public function validateToken(string $token): ?SigningToken
    {
        $token = $this->entityManager->getRepository('App\Entity\SigningToken')->findOneBy(['token' => $token]);
        if(!($token instanceof SigningToken) || $token->getExpirationDate() < new DateTime('now')){
            return null;
        }
        return $token;
    }

    public function setPassword(SigningToken $token, string $password): bool
    {
        if(!$token || $token->getType() != 'SET_PASSWORD'){
            return false;
        }
        $user = $token->getUser();
        try{
            $user = $this->userService->setPassword($user, $password);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return true;
        } catch (BadRequestException $exception){
            return false;
        }
    }

    public function setEmailValidation(SigningToken $token): bool
    {
        if(!$token || $token->getType() != 'VALIDATE_EMAIL'){
            return false;
        }
        $user = $token->getUser();
        $user->setEmailValidated(new DateTime('now'));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }

    public function createToken(Request $request): ?SigningToken
    {
        $user = $this->entityManager->getRepository('App\Entity\User')->findOneBy(['id' => $request->attributes->get('id')]);
        if(
            !$request->query->has('type') ||
            !($user instanceof User)
        ){
            return null;
        }
        $random = base64_encode(random_bytes(32));
        $token = new SigningToken();
        $token->setType($request->query->get('type'));
        $token->setUser($user);
        $token->setExpirationDate(new DateTime('+15 minutes'));
        $token->setToken($random);
        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $token;
    }

    public function getParameterBag(): ParameterBagInterface
    {
        return $this->parameterBag;
    }
}