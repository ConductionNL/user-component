<?php

namespace App\Service;

use App\Entity\Session;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

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
    ) {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->jwtService = $jwtService;
        $this->parameterBag = $parameterBag;
    }

    public function getCSRFToken(UuidInterface $id): CsrfToken
    {
        $tokenManager = new CsrfTokenManager();

        return $tokenManager->getToken($id->toString());
    }

    public function login(string $content): User
    {
        $data = json_decode($content, true);

        $user = $this->userCheck($data);
        $this->passwordCheck($user, $data);

        $expiry = new DateTime('+5 days');

        $session = new Session();
        $session->setUser($user->getId());
        $session->setExpiry($expiry);
        $session->setValid(true);
        $this->entityManager->persist($session);
        $this->entityManager->flush();

        $csrfToken = $this->getCSRFToken($session->getId());
        $session->setCSRFToken($csrfToken);
        $jwtToken = $this->getJWTToken($user, $session);

        $user->setCsrfToken($csrfToken);
        $user->setJwtToken($jwtToken);

        return $user;
    }

    public function logout(string $jwtToken): bool
    {
        $payload = $this->jwtService->verifyJWTToken($jwtToken);
//        var_dump($payload);
        $session = $this->entityManager->getRepository('App\Entity\Session')->findOneBy(['id' => $payload['session']]);

        if (!($session instanceof Session)) {
            return false;
        }
        $session->setValid(false);
        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return true;
    }

    public function getJWTToken(User $user, Session $session): string
    {
        $time = new DateTime();
        $jwtBody = [
            'userId'    => $user->getId(),
            'username'  => $user->getUsername(),
            'roles'     => $user->getRoles(),
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

        if ($user instanceof User) {
            return $user;
        } else {
            throw new AccessDeniedHttpException('The username/password combination is invalid');
        }
    }

    public function passwordCheck($user, $data): void
    {
        if ($user && !$this->encoder->isPasswordValid($user, $data['password'])) {
            throw new AccessDeniedHttpException('The username/password combination is invalid');
        }
    }
}
