<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;

use App\Controller\DefaultController;
/**
 * All properties that the entity User holds.
 *
 * Entity User exists of an id, a name, a password, a email and has zero or more roles.
 *
 * @author Ruben van der Linde <ruben@conduction.nl>
 * @license EUPL <https://github.com/ConductionNL/user-component/blob/master/LICENSE.md>
 * @category Entity
 * @package user-component
 *
 * @ApiResource(collectionOperations={
 * 	   "get",
 * 	   "post",
 *     "login"={
 *         "method"="post",
 *         "path"="login",
 *         "controller"=DefaultController::class,
 *         "read"=false
 *     		}
 * 		},
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @ORM\Table(name="userTable")
 * @ApiFilter(SearchFilter::class, properties={"username": "exact", "organization": "exact", "person": "exact"})
 */
class User implements UserInterface
{
    /**
     * @var UuidInterface  The (uu)id of this group
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
	 * @var string The RSIN of the organization that owns this user
	 *
	 * @example 002851234
	 *
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
	 * @var string  $username A unique visual identifier that represents this user.
	 *
	 * @example 002851234
	 *
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 8,
	 *      max = 255
	 * )
	 * @Groups({"read", "write"})
	 * @ORM\Column(type="string", length=255, unique = true)
	 */
	private $username;
	
	/**
	 * @var string $person A contact component person 
	 *
	 * @example https://cc.zaakonline.nl/people/06cd0132-5b39-44cb-b320-a9531b2c4ac7
	 *
	 * @Assert\Url
	 * @Assert\Length(
	 *      max = 255
	 * )
	 * @Groups({"read", "write"})
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $person;

    /**
     * @ORM\Column(type="json")
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", mappedBy="users")
     */
    private $userGroups;
    
    /**
     * @var array A list of tokens created for this user
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Token", mappedBy="user", orphanRemoval=true)
     */
    private $tokens;
    
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
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

    public function __construct()
    {
        $this->userGroups = new ArrayCollection();
        $this->tokens = new ArrayCollection();
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
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
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
