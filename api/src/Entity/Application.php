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
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * All properties that the entity Application holds.
 *
 * @author Ruben van der Linde <ruben@conduction.nl>
 * @license EUPL <https://github.com/ConductionNL/user-component/blob/master/LICENSE.md>
 * @category Entity
 * @package user-component
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationRepository")
 */
class Application
{
	/**
	 * @var UuidInterface
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
	 * @var string The RSIN of the organization that owns this product
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
	 * @var string The name of this menu
	 *
	 * @example webshop menu
	 *
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      max = 255
	 * )
	 * @Groups({"read","write"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;
	
	/**
	 * @var string The description of this page.
	 *
	 * @example This page holds info about this application
	 *
	 * @Assert\NotNull
	 * @Assert\Length(
	 *     max = 255
	 * )
	 * @Groups({"read","write"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $description;

    /**
	 * @Groups({"read","write"})
     * @MaxDepth(1)
     * @ORM\OneToMany(targetEntity="App\Entity\Scope", mappedBy="application", orphanRemoval=true)
     */
	private $scopes;
	
	/**
	 * @var DateTime The moment this resource was created
	 *
	 * @Groups({"read"})
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $createdAt;
	
	/**
	 * @var DateTime The last time this resource was changed
	 *
	 * @Groups({"read"})
	 * @Gedmo\Timestampable(on="update")
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $updatedAt;

    public function __construct()
    {
        $this->scopes = new ArrayCollection();
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
            $scope->setApplication($this);
        }

        return $this;
    }

    public function removeScope(Scope $scope): self
    {
        if ($this->scopes->contains($scope)) {
            $this->scopes->removeElement($scope);
            // set the owning side to null (unless already changed)
            if ($scope->getApplication() === $this) {
                $scope->setApplication(null);
            }
        }

        return $this;
    }
    
    public function getCreatedAt(): ?\DateTimeInterface
    {
    	return $this->createdAt;
    }
    
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
    	$this->createdAt = $createdAt;
    	
    	return $this;
    }
    
    public function getUpdatedAt(): ?\DateTimeInterface
    {
    	return $this->updatedAt;
    }
    
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
    	$this->updatedAt = $updatedAt;
    	
    	return $this;
    }
}
