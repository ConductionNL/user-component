<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SessionRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
 *     itemOperations={
 *          "get",
 *          "put",
 *          "get_change_logs"={
 *              "path"="/scopes/{id}/change_log",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Changelogs",
 *                  "description"="Gets al the change logs for this resource"
 *              }
 *          },
 *          "get_audit_trail"={
 *              "path"="/scopes/{id}/audit_trail",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Audittrail",
 *                  "description"="Gets the audit trail for this resource"
 *              }
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 * @Gedmo\Loggable(logEntryClass="Conduction\CommonGroundBundle\Entity\ChangeLog")
 */
class Session
{
    /**
     * @var UuidInterface The UUID identifier of this resource
     *
     * @Groups({"read"})
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private UuidInterface $id;

    /**
     * @var string The identifier of the user in this session
     *
     * @Groups({"read"})
     * @ORM\Column(type="string", length=255, name="user_identifier")
     */
    private string $user;

    /**
     * @var DateTimeInterface The expiration moment for the session
     * @Groups({"read", "write"})
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $expiry;

    /**
     * @var string|null The CSRF token belonging to the session
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255
     * )
     */
    private ?string $csrfToken = null;

    /**
     * @var bool whether or not the session is valid
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     */
    private bool $valid;

    /**
     * @var Datetime The moment this request was created
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $dateCreated;

    /**
     * @var Datetime The moment this request last Modified
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $dateModified;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getExpiry(): ?DateTimeInterface
    {
        return $this->expiry;
    }

    public function setExpiry(DateTimeInterface $expiry): self
    {
        $this->expiry = $expiry;

        return $this;
    }

    public function getCSRFToken(): ?string
    {
        return $this->csrfToken;
    }

    public function setCSRFToken(?string $csrfToken): self
    {
        $this->csrfToken = $csrfToken;

        return $this;
    }

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    public function getDateCreated(): ?DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }
}
