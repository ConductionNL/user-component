<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * A user Group.
 *
 * @author Ruben van der Linde <ruben@conduction.nl>
 * @license EUPL <https://github.com/ConductionNL/user-component/blob/master/LICENSE.md>
 * @category Entity
 * @package user-component
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
 *     itemOperations={
 *          "get",
 *          "put",
 *          "delete",
 *          "get_change_logs"={
 *              "path"="/groups/{id}/change_log",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Changelogs",
 *                  "description"="Gets al the change logs for this resource"
 *              }
 *          },
 *          "get_audit_trail"={
 *              "path"="/groups/{id}/audit_trail",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Audittrail",
 *                  "description"="Gets the audit trail for this resource"
 *              }
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 * @Gedmo\Loggable(logEntryClass="App\Entity\ChangeLog")
 * @ORM\Table(name="userGroup")
 *
 * @ApiFilter(BooleanFilter::class)
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(DateFilter::class, strategy=DateFilter::EXCLUDE_NULL)
 * @ApiFilter(SearchFilter::class)
 */
class Group
{
	/**
	 * @var UuidInterface $id The (uu)id of this group
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
	 * @var string $organization The RSIN of the organization that owns this group
	 *
	 * @example 002851234
	 *
     * @Gedmo\Versioned
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 8,
	 *      max = 11
	 * )
	 * @Groups({"read", "write"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $organization;

	/**
	 * @var string $name The name of this group
	 *
	 * @example Admin
	 *
     * @Gedmo\Versioned
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      max = 255
	 * )
	 * @Groups({"read","write"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;

	/**
	 * @var string $description The description of this group.
	 *
	 * @example This group holds all the Admin members
	 *
     * @Gedmo\Versioned
	 * @Assert\NotNull
	 * @Assert\Length(
	 *     max = 255
	 * )
	 * @Groups({"read","write"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $description;

	/**
	 * @var string $code The code of this scope
	 *
	 * @example contact.write
	 *
	 * @Gedmo\Versioned
	 * @Gedmo\Slug(fields={"name"})
	 * @Groups({"read"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $code;

	/**
	 * @var $parent Group The group that this group is part of
	 *
	 * @MaxDepth(1)
	 * @Groups({"write"})
	 * @ORM\ManyToOne(targetEntity="App\Entity\Group", inversedBy="children")
	 */
	private $parent;

	/**
	 * @var ArrayCollection Groups that are a part of this group
	 *
	 * @MaxDepth(1)
	 * @Groups({"read"})
	 * @ORM\OneToMany(targetEntity="App\Entity\Group", mappedBy="parent")
	 */
	private $children;

    /**
	 * @var Scope[] $scopes The scopes that members of this group have
	 *
	 * @Groups({"read","write"})
     * @MaxDepth(1)
     * @ORM\ManyToMany(targetEntity="App\Entity\Scope", inversedBy="userGroups", fetch="EAGER")
     */
    private $scopes;

    /**
	 * @var User[] $users The users that belong to this group
	 *
	 * @Groups({"read","write"})
     * @MaxDepth(1)
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="userGroups")
     */
    private $users;

    /**
     * @var Datetime $dateCreated The moment this request was created
     *
     * @Assert\DateTime
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var Datetime $dateModified  The moment this request last Modified
     *
     * @Assert\DateTime
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

    public function __construct()
    {
        $this->scopes = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCode(): ?string
    {
    	return $this->code;
    }

    public function setCode(string $code): self
    {
    	$this->code = $code;

    	return $this;
    }

    public function getParent(): ?self
    {
    	return $this->parent;
    }

    public function setParent(?self $parent): self
    {
    	$this->parent = $parent;

    	return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
    	return $this->children;
    }

    public function addChild(self $child): self
    {
    	if (!$this->children->contains($child)) {
    		$this->children[] = $child;
    		$child->setParent($this);
    	}

    	return $this;
    }

    public function removeChild(self $child): self
    {
    	if ($this->children->contains($child)) {
    		$this->children->removeElement($child);
    		// set the owning side to null (unless already changed)
    		if ($child->getParent() === $this) {
    			$child->setParent(null);
    		}
    	}

    	return $this;
    }

    /**
     * @return Collection|Scope[]
     */
    public function getScopes(): Collection
    {
        return $this->scopes;
    }

    public function addScope(Scope $scope): self
    {
        if (!$this->scopes->contains($scope)) {
            $this->scopes[] = $scope;
        }

        return $this;
    }

    public function removeScope(Scope $scope): self
    {
        if ($this->scopes->contains($scope)) {
            $this->scopes->removeElement($scope);
        }

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
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
    	return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
    	$this->dateCreated= $dateCreated;

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
