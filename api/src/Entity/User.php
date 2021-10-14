<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\DefaultController;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * All properties that the entity User holds.
 *
 * Entity User exists of an id, a name, a password, a email and has zero or more roles.
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
 *          "get_scopes"={
 *              "path"="/users/{id}/scopes",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Scopes",
 *                  "description"="Gets al the scopes linked to this user"
 *              }
 *          },
 *          "get_token"={
 *              "path"="/users/{id}/token",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Token",
 *                  "description"="Gets a signing token for this user"
 *              }
 *          },
 *          "get_change_logs"={
 *              "path"="/users/{id}/change_log",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Changelogs",
 *                  "description"="Gets al the change logs for this resource"
 *              }
 *          },
 *          "get_audit_trail"={
 *              "path"="/users/{id}/audit_trail",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Audittrail",
 *                  "description"="Gets the audit trail for this resource"
 *              }
 *          }
 *     },
 *     collectionOperations={
 *  	   "get",
 *  	   "post",
 *          "use_token"={
 *              "path"="/users/token",
 *              "method"="post",
 *              "swagger_context" = {
 *                  "summary"="Token",
 *                  "description"="Process a signing token"
 *              }
 *          },
 *          "login"={
 *              "summary"="Login a user with a username and password.",
 *              "description"="Login a user with a username and password.",
 *              "method"="post",
 *              "path"="login",
 *              "controller"=DefaultController::class,
 *              "read"=false,
 *              "requestBody" = {
 *                  "content" = {
 *                      "application/json" = {
 *                          "schema" = {
 *                              "type" = "object",
 *                              "properties" =
 *                                  {
 *                                      "username" = {"type" = "string"},
 *                                      "password" = {"type" = "string"},
 *                                  },
 *                          },
 *                          "example" = {
 *                              "username" = "JohnDoe@gmail.com",
 *                              "password" = "n$5Ssqs]eCDT!$})",
 *                          },
 *                      },
 *                  },
 *              },
 *           },
 *          "logout"={
 *              "summary"="Login a user with a username and password.",
 *              "description"="Login a user with a username and password.",
 *              "method"="post",
 *              "path"="logout",
 *              "controller"=DefaultController::class,
 *              "read"=false,
 *              "requestBody" = {
 *                  "content" = {
 *                      "application/json" = {
 *                          "schema" = {
 *                              "type" = "object",
 *                              "properties" =
 *                                  {
 *                                      "jwtToken" = {"type" = "string"},
 *                                  },
 *                          },
 *                          "example" = {
 *                              "jwtToken" = "eyJhbGciOiJSUzUxMiJ9.eyJ1c2VySWQiOiIwNTFiNTM0MS00MzNiLTQ1ODAtYTFiOC03ZWU0NTBjZmZkNDgiLCJ1c2VybmFtZSI6Im1haW4rdGVzdGFkbWluQGNvbmR1Y3Rpb24ubmwiLCJyb2xlcyI6WyJ1c2VyIl0sInNlc3Npb24iOiJhMmY3ZTAzMy00OGRkLTRhMjUtODI1Mi0wOTllNGYzNzFmMmEiLCJjc3JmVG9rZW4iOiJiOGY5YzM0ZDhiMGIxOTQ2ZWUuY1dTMTFKa1BfMHAxdXg3SzVFSjgyaGJrTUdGdldKWXhOZ3FsMU0tQU5OOC5HeWZSb1BoZXIzc045RlNhZ3hJcnRselhXUTRPRy1SbFJWLWRzcERTYnJKRUxkMnM0VmV0R2lYSVR3IiwiaXNzIjoiaHR0cDpcL1wvbG9jYWxob3N0IiwiaWFzIjoxNjI3OTA2ODY2LCJleHAiOjE2MjgzMzg4NjV9.VbdkuKY9C_Ru92iQ7n607sNdwcGdRu61pyUnTe-g4o9DQcYLvfA-NRQIe13s4hALkHG94Wb9JVeETkvfIY9F1zFvcksmocmiU6RkTpFKPz_m9rTH8nlLT4oLNVMvFhU-47Byea4zxNAf8cu_nH_41Ff0L81H2fsJi3XoANy1mP_subxhvxnqNMGwy6EFja1xlOtMBLReDVCLC_6WN3NUAgwvfSCOckxjJ0-bsJUpUV9ZsjYUgkaVepX4ERYDKtRCigrTl98HU5T-lu0VuLd25Kx0qrj4WxIDWutlgQmClfC_6XHRcOItr9bv-H3H_TzdtaAVI2_aIza9Wgea64NkhoD8BfvC0RmUYfclVLcoWMfcfYPDi3XebAjmdL9CuWU2AST9Xp8gFZeVKcleXNy92a7sey0CS5OpfAxCl8K-WOlZ85SdJb5fvPoTKXl4hzbW7YcCzI-ULXhE6CQebrcLL9Ok5NeGSn9R0KMf-Uhc5VGxd9vguBoIwcCbojSPw6EduMMNQGPrOTY-XjyfBA6luvQlC8SyI_Yf4QpylHLoui1NcmGTNamk-nevffWqQO715wy_q6GZQTh9cv5wRUdv8O2hbQTZCGrmlSdZ3E4JobTcdAV-BJodwwn3l_4DYi2BDYVoaefTww842EZHOqzlxix_1f95sIkrpjJPWjH5Zg0",
 *                          },
 *                      },
 *                  },
 *              },
 *      	}
 *  	}
 *
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Gedmo\Loggable(logEntryClass="Conduction\CommonGroundBundle\Entity\ChangeLog")
 *
 * @ORM\Table(name="userTable")
 *
 * @ApiFilter(BooleanFilter::class)
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(DateFilter::class, strategy=DateFilter::EXCLUDE_NULL)
 * @ApiFilter(SearchFilter::class, properties={"username": "iexact", "organization": "partial", "person": "partial"})
 */
class User implements PasswordAuthenticatedUserInterface
{
    /**
     * @var UuidInterface The (uu)id of this group
     *
     * @example e2984465-190a-4562-829e-a8cca81aa35d
     *
     * @Groups({"read", "login"})
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @Assert\Uuid
     */
    private $id;

    /**
     * @var string A specific commonground organization
     *
     * @example https://wrc.zaakonline.nl/organisations/16353702-4614-42ff-92af-7dd11c8eef9f
     *
     * @Assert\Url
     * @Gedmo\Versioned
     * @Groups({"read", "write", "login"})
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 255
     * )
     */
    private $organization;

    /**
     * @var string A unique visual identifier that represents this user.
     *
     * @example 002851234
     *
     * @Gedmo\Versioned
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 8,
     *      max = 255
     * )
     * @Groups({"read", "write", "login"})
     * @ORM\Column(type="string", length=255, unique = true)
     */
    private $username;

    /**
     * @var string A iso code reprecenting theusers language
     *
     * @example en
     *
     * @Gedmo\Versioned
     * @Assert\NotNull
     * @Assert\Language
     * @Groups({"read", "write", "login"})
     * @ORM\Column(type="string", length=7)
     * @Assert\Length(
     *      max = 7
     * )
     */
    private $locale = 'en';

    /**
     * @var string A contact component person
     *
     * @example https://cc.zaakonline.nl/people/06cd0132-5b39-44cb-b320-a9531b2c4ac7
     *
     * @Gedmo\Versioned
     * @Assert\Url
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"read", "write", "login"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $person;

    /**
     * @Groups({"read", "login"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     *
     * @Groups({"write"})
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var array A list of groups to wichs this user belongs
     *
     * @Groups({"read", "write", "login"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", mappedBy="users", fetch="EAGER", cascade={"persist"})
     */
    private $userGroups;

    /**
     * @var array A list of tokens created for this user
     *
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="App\Entity\Token", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $tokens;

    /**
     * @var Datetime The moment this request was created
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var Datetime The moment this request last Modified
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

    /**
     * @var string|null The JWT token granted on login
     *
     * @Groups({"login"})
     */
    private ?string $jwtToken = null;

    /**
     * @var string|null The CSRF token granted on login
     *
     * @Groups({"login"})
     */
    private ?string $csrfToken = null;

    /**
     * @var Datetime|null The moment this user validated their email
     *
     * @Groups({"read"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $emailValidated = null;

    /**
     * @var Collection Signing Tokens related to this user
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SigningToken", mappedBy="user", orphanRemoval=true, fetch="EXTRA_LAZY")
     */
    private Collection $signingTokens;

    public function __construct()
    {
        $this->userGroups = new ArrayCollection();
        $this->tokens = new ArrayCollection();
        $this->signingTokens = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(?string $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getPerson(): ?string
    {
        return $this->person;
    }

    public function setPerson(?string $person): self
    {
        $this->person = $person;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this users langauge.
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = ['user'];

        foreach ($this->getUserGroups() as $group) {
            $roles[] = 'group.'.$group->getCode();
            foreach ($group->getScopes() as $scope) {
                $roles[] = 'scope.'.$scope->getCode();
            }
        }

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Group[]
     */
    public function getUserGroups(): Collection
    {
        return $this->userGroups;
    }

    public function addUserGroup(Group $userGroup): self
    {
        if (!$this->userGroups->contains($userGroup)) {
            $this->userGroups[] = $userGroup;
            $userGroup->addUser($this);
        }

        return $this;
    }

    public function removeUserGroup(Group $userGroup): self
    {
        if ($this->userGroups->contains($userGroup)) {
            $this->userGroups->removeElement($userGroup);
            $userGroup->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Token[]
     */
    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function addToken(Token $token): self
    {
        if (!$this->tokens->contains($token)) {
            $this->tokens[] = $token;
            $token->setUser($this);
        }

        return $this;
    }

    public function removeToken(Token $token): self
    {
        if ($this->tokens->contains($token)) {
            $this->tokens->removeElement($token);
            // set the owning side to null (unless already changed)
            if ($token->getUser() === $this) {
                $token->setUser(null);
            }
        }

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

    public function getJwtToken(): ?string
    {
        return $this->jwtToken;
    }

    public function setJwtToken(?string $jwtToken): self
    {
        $this->jwtToken = $jwtToken;

        return $this;
    }

    public function getCsrfToken(): ?string
    {
        return $this->csrfToken;
    }

    public function setCsrfToken(?string $csrfToken): self
    {
        $this->csrfToken = $csrfToken;

        return $this;
    }

    public function getEmailValidated(): ?\DateTimeInterface
    {
        return $this->emailValidated;
    }

    public function setEmailValidated(?\DateTimeInterface $emailValidated): self
    {
        $this->emailValidated = $emailValidated;

        return $this;
    }

    /**
     * @return Collection|SigningToken[]
     */
    public function getSigningTokens(): Collection
    {
        return $this->tokens;
    }

    public function addSigningToken(SigningToken $signingToken): self
    {
        if (!$this->signingTokens->contains($signingToken)) {
            $this->signingTokens[] = $signingToken;
            $signingToken->setUser($this);
        }

        return $this;
    }

    public function removeSigningToken(SigningToken $signingToken): self
    {
        if ($this->signingTokens->contains($signingToken)) {
            $this->signingTokens->removeElement($signingToken);
            // set the owning side to null (unless already changed)
            if ($signingToken->getUser() === $this) {
                $signingToken->setUser(null);
            }
        }

        return $this;
    }
}
