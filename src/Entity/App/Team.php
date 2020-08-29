<?php

<<<<<<< Updated upstream
namespace App\Entity\App;

use App\Repository\App\TeamRepository;
=======
namespace App\Entity;

use App\Repository\TeamRepository;
>>>>>>> Stashed changes
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
<<<<<<< Updated upstream
     * @ORM\Column(type="string", length=255)
     */
    private $name;

=======
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;
    
>>>>>>> Stashed changes
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

<<<<<<< Updated upstream
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stadium;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\Column(type="integer")
     */
    private $league;

    public function getId(): ?int
=======
     /**
      * @ORM\Column(type="string", length=255, nullable=true)
      */
    private $stadium;

    /**
      * @ORM\Column(type="integer", nullable=true)
      */
    private $league;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    public function getId(): int
>>>>>>> Stashed changes
    {
        return $this->id;
    }

<<<<<<< Updated upstream
    public function getName(): ?string
=======
    public function getName(): string
>>>>>>> Stashed changes
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getStadium(): ?string
    {
        return $this->stadium;
    }

    public function setStadium(?string $stadium): self
    {
        $this->stadium = $stadium;

        return $this;
    }

<<<<<<< Updated upstream
    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;
=======
    public function getLeague(): ?int
    {
        return $this->league;
    }

    public function setLeague(?int $league): self
    {
        $this->league = $league;
>>>>>>> Stashed changes

        return $this;
    }

<<<<<<< Updated upstream
    public function getLeague(): ?int
    {
        return $this->league;
    }

    public function setLeague(int $league): self
    {
        $this->league = $league;
=======
    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
>>>>>>> Stashed changes

        return $this;
    }
}
