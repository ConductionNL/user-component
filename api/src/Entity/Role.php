<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * All properties that the entity Role holds.
 *
 * Entity Role exists of an id, a name, has an administrator and has one or more rights.
 *
 * @author Barry Brands <barry@conduction.nl>
 * @license EUPL <https://github.com/ConductionNL/user-component/blob/master/LICENSE.md>
 *
 * @category Entity
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
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
     */
    private $id;

    /**
     * @var string Name of a Role
     *
     * @example board member
     *
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *         	   "description" = "The name of a Role",
     *             "type"="string",
     *             "format"="string",
     *             "example"="board member"
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
    private $name;

    /**
     * @var User Users of a Role
     *
     * @Groups({"read","write"})
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="roles")
     *
     * @MaxDepth(1)
     */
    private $users;

    /**
     * @var User Administrator of a Role
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     *
     * @MaxDepth(1)
     */
    private $administrator;

    /**
     * @var Right Rights of a Role
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Right", mappedBy="roles")
     *
     * @MaxDepth(1)
     */
    private $rights;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->rights = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeRole($this);
        }

        return $this;
    }

    public function getAdministrator(): ?User
    {
        return $this->administrator;
    }

    public function setAdministrator(?User $administrator): self
    {
        $this->administrator = $administrator;

        return $this;
    }

    /**
     * @return Collection|Right[]
     */
    public function getRights(): Collection
    {
        return $this->rights;
    }

    public function addRight(Right $right): self
    {
        if (!$this->rights->contains($right)) {
            $this->rights[] = $right;
            $right->addRole($this);
        }

        return $this;
    }

    public function removeRight(Right $right): self
    {
        if ($this->rights->contains($right)) {
            $this->rights->removeElement($right);
            $right->removeRole($this);
        }

        return $this;
    }
}
