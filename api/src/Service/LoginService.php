<?php

namespace App\Service;

use App\Entity\Session;
use App\Entity\User;
use DateTime;
use Doctrine\Common\Collections\Collection;
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
    private UserPasswordHasherInterface $hasher;
    private JWTService $jwtService;
    private ParameterBagInterface $parameterBag;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $hasher,
        JWTService $jwtService,
        ParameterBagInterface $parameterBag
    ) {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
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

        $expiry = new DateTime("+{$this->parameterBag->get('expiration_time')}");

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
        $session = $this->entityManager->getRepository('App\Entity\Session')->findOneBy(['id' => $payload['session']]);

        if (!($session instanceof Session)) {
            return false;
        }
        $session->setValid(false);
        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return true;
    }

    private function getOrganizations(Collection $userGroups, array $organizations): array
    {
        foreach ($userGroups as $userGroup) {
            if (!in_array($userGroup->getOrganization(), $organizations)) {
                $organizations[] = $userGroup->getOrganization();
            }
        }

        return $organizations;
    }

    public function getJWTToken(User $user, Session $session): string
    {
        $time = new DateTime();
        $jwtBody = [
            'userId'        => $user->getId(),
            'username'      => $user->getUsername(),
            'organization'  => $user->getOrganization(),
            'organizations' => $this->getOrganizations($user->getUserGroups(), [$user->getOrganization()]),
            'person'        => $user->getPerson(),
            'locale'        => $user->getLocale(),
            'roles'         => $user->getRoles(),
            'session'       => $session->getId(),
            'csrfToken'     => $session->getCSRFToken(),
            'iss'           => $this->parameterBag->get('app_url'),
            'ias'           => $time->getTimestamp(),
            'exp'           => $session->getExpiry()->getTimestamp(),
        ];

        return $this->jwtService->createJWTToken($jwtBody);
    }

    public function userCheck(array $data): User
    {
        if ($this->parameterBag->has('case_insensitive_username') && $this->parameterBag->get('case_insensitive_username')) {
            if (!$user = $this->entityManager
                ->getRepository('App\Entity\User')
                ->createQueryBuilder('a')
                ->where('upper(a.username) = upper(:username)')
                ->setParameter('username', $data['username'])
                ->getQuery()
                ->execute()[0]) {
                throw new AccessDeniedHttpException('The username/password combination is invalid');
            }
        } else {
            if (!$user = $this->entityManager->getRepository('App\Entity\User')->findOneBy(['username' => $data['username']])) {
                throw new AccessDeniedHttpException('The username/password combination is invalid');
            }
        }

        if ($user instanceof User) {
            if ($user->getBlocked() && new DateTime() >= $user->getBlocked()) {
                throw new AccessDeniedHttpException('This user is blocked, you are not allowed to log in');
            }

            return $user;
        } else {
            throw new AccessDeniedHttpException('The username/password combination is invalid');
        }
    }

    public function passwordCheck($user, $data): void
    {
        if ($user && !$this->hasher->isPasswordValid($user, $data['password'])) {
            throw new AccessDeniedHttpException('The username/password combination is invalid');
        }
    }
}
