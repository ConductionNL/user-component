<?php

namespace App\Service;

use App\Entity\Session;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginService
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $encoder;
    private JWTService $jwtService;
    private ParameterBagInterface $parameterBag;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $encoder,
        JWTService $jwtService,
        ParameterBagInterface $parameterBag
    )
    {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->jwtService = $jwtService;
        $this->parameterBag = $parameterBag;
    }

    public function getCSRFToken(): string
    {
        return '';
    }

    public function login(string $content): User
    {
        $data = json_decode($content, true);

        $user = $this->userCheck($data);
        $this->passwordCheck($user, $data);

        $expiry = new DateTime('+5 days');
        $csrfToken = $this->getCSRFToken();

        $session = new Session();
        $session->setUserIdentifier($user->getId());
        $session->setExpiry($expiry);
        $session->setCSRFToken($csrfToken);
        $this->entityManager->persist($session);
        $this->entityManager->flush();

        $jwtToken = $this->getJWTToken($user, $session);

        return $user;
    }

    public function logout(string $content): bool
    {
        return true;
    }

    public function getJWTToken(User $user, Session $session): string
    {

        $time = new DateTime();
        $jwtBody = [
            'userId'    => $user->getId(),
            'username'  => $user->getUsername(),
            'session'   => $session->getId(),
            'csrfToken' => $session->getCSRFToken(),
            'iss'       => $this->parameterBag->get('app_url'),
            'ias'       => $time->getTimestamp(),
            'exp'       => $session->getExpiry()->getTimestamp(),
        ];

        return $this->jwtService->createJWTToken($jwtBody);
    }

    public function userCheck(array $data): User
    {
        if (!$user = $this->entityManager->getRepository('App\Entity\User')->findOneBy(['username' => $data['username']])) {
            throw new AccessDeniedHttpException('The username/password combination is invalid');
        }

        if($user instanceof User)
            return $user;
        else
            throw new AccessDeniedHttpException('The username/password combination is invalid');
    }

    public function passwordCheck($user, $data): void
    {
        if ($user && !$this->encoder->isPasswordValid($user, $data['password'])) {
            throw new AccessDeniedHttpException('The username/password combination is invalid');
        }
    }
}