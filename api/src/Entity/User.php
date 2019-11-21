<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * All properties that the entity User holds.
 *
 * Entity User exists of an id, a name, a password, a email and has zero or more roles.
 *
 * @author Barry Brands <barry@conduction.nl>
 * @license EUPL <https://github.com/ConductionNL/user-component/blob/master/LICENSE.md>
 * @category Entity
 * @package user-component
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @ORM\Table(name="userTable")
 */
class User
{
    /**
     * @var UuidInterface
     *
     * @ApiProperty(
     * 	   identifier=true,
     *     attributes={
     *         "openapi_context"={
     *         	   "description" = "The UUID identifier of this object",
     *             "type"="string",
     *             "format"="uuid",
     *             "example"="e2984465-190a-4562-829e-a8cca81aa35d"
     *         }
     *     }
     * )
     *
     * @Groups({"read"})
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @Assert\NotBlank
     * @Assert\Uuid
     *
     *
     */
    private $id;

    /**
     * @var string $name Name of a User
     * @example Hans Vliet
     *
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *         	   "description" = "The name of a User",
     *             "type"="string",
     *             "format"="string",
     *             "example"="Hans Vliet"
     *         }
     *     }
     * )
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $name;

    /**
     * @var string $password Password of a User
     * @example abc123
     *
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *         	   "description" = "The password of a User",
     *             "type"="string",
     *             "format"="string",
     *             "example"="abc123"
     *         }
     *     }
     * )
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $password;

    /**
     * @var string $email Email of a User
     * @example name@provider.com
     *
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *         	   "description" = "The email of a User",
     *             "type"="string",
     *             "format"="string",
     *             "example"="name@provider.com"
     *         }
     *     }
     * )
     *
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $email;

    /**
     * @var DateTime $registrationDate Registration date of a User
     * @example 01-01-2000
     *
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *         	   "description" = "The date when a User registered",
     *             "type"="datetime",
     *             "format"="datetime",
     *             "example"="01-01-2000"
     *         }
     *     }
     * )
     * @Groups({"read","write"})
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank
     * @Assert\DateTime
     */
    private $registrationDate;

    /**
     * @var Role $roles Roles of a User
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", inversedBy="users")
     *
     * @MaxDepth(1)
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }
}
