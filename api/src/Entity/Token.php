<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A token from an external identity profider (like facebook).
 *
 * @author Ruben van der Linde <ruben@conduction.nl>
 * @license EUPL <https://github.com/ConductionNL/user-component/blob/master/LICENSE.md>
 *
 * @category Entity
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
 *     itemOperations={
 *          "get",
 *          "put",
 *          "delete",
 *          "get_change_logs"={
 *              "path"="/tokens/{id}/change_log",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Changelogs",
 *                  "description"="Gets al the change logs for this resource"
 *              }
 *          },
 *          "get_audit_trail"={
 *              "path"="/tokens/{id}/audit_trail",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Audittrail",
 *                  "description"="Gets the audit trail for this resource"
 *              }
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 * @Gedmo\Loggable(logEntryClass="Conduction\CommonGroundBundle\Entity\ChangeLog")
 * @ORM\HasLifecycleCallbacks
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(DateFilter::class, strategy=DateFilter::EXCLUDE_NULL)
 * @ApiFilter(SearchFilter::class, properties={"provider.name": "exact","provider.type": "exact","provider.application": "partial", "token": "exact", "user.username": "exact"})
 */
class Token
{
    /**
     * @var UuidInterface The (uu)id of this token
     *
     * @example e2984465-190a-4562-829e-a8cca81aa35d
     *
     * @Groups({"read"})
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @Assert\Uuid
     */
    private $id;

    /**
     * @var User The user that this token belongs to.
     *
     * @Gedmo\Versioned
     * @Assert\NotNull()
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tokens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var Provider The provider that this scope belongs to.
     *
     * @Groups({"read", "write"})
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="App\Entity\Provider", inversedBy="tokens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $provider;

    /**
     * @var string The actual token.
     *
     * @example e2984465-190a-4562-829e-a8cca81aa35d
     *
     * @Assert\NotNull
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @var string Duration the token is active for in minutes
     *
     * @example 4
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $duration = 600;

    /**
     * @var DateTime The moment this token expires
     *
     * @Gedmo\Versioned
     * @Groups({"read"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validTill;

    /**
     * @var DateTime The moment the invite was accepted by the user
     *
     * @example 20190101
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateAccepted;

    /**
     * @var DateTime The moment this request was created by the submitter
     *
     * @example 20190101
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var DateTime The moment this request was created by the submitter
     *
     * @example 20190101
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

    public function getValidTill(): ?\DateTimeInterface
    {
        return $this->validTill;
    }

    public function setValidTill(DateTimeInterface $validTill): self
    {
        $this->validTill = $validTill;

        return $this;
    }

    /**
     *  @ORM\PrePersist
     *  @ORM\PreUpdate
     *
     *  */
    public function prePersist()
    {
        $date = new DateTime('now');
        $duration = $this->getDuration();

        if (isset($duration)) {
            $date->add(new DateInterval('PT'.$duration.'M'));
        }

        $this->setValidTill($date);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    public function setProvider(?Provider $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDateAccepted(): ?\DateTimeInterface
    {
        return $this->dateAccepted;
    }

    public function setDateAccepted(\DateTimeInterface $dateAccepted): self
    {
        $this->dateAccepted = $dateAccepted;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(\DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }
}
