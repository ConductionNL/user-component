<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @var UuidInterface The UUID identifier of this resource
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $userIdentifier;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $expiry;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $csrfToken;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getUserIdentifier(): ?string
    {
        return $this->userIdentifier;
    }

    public function setUserIdentifier(string $userIdentifier): self
    {
        $this->userIdentifier = $userIdentifier;

        return $this;
    }

    public function getExpiry(): ?\DateTimeInterface
    {
        return $this->expiry;
    }

    public function setExpiry(\DateTimeInterface $expiry): self
    {
        $this->expiry = $expiry;

        return $this;
    }

    public function getCSRFToken(): ?string
    {
        return $this->csrfToken;
    }

    public function setCSRFToken(string $csrfToken): self
    {
        $this->csrfToken = $csrfToken;

        return $this;
    }
}
