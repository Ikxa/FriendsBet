<?php

namespace App\Entity\App;

use App\Repository\App\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;
    
    /**
     * @ORM\OneToMany(targetEntity=Match::class, mappedBy="sport")
     */
    private $matches;
    
    public function __construct()
    {
        $this->matches = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getLabel(): ?string
    {
        return $this->label;
    }
    
    public function setLabel(string $label): self
    {
        $this->label = $label;
        
        return $this;
    }
    
    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }
    
    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;
        
        return $this;
    }
    
    /**
     * @return Collection|Match[]
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }
    
    public function addMatch(Match $match): self
    {
        if (!$this->matches->contains($match)) {
            $this->matches[] = $match;
            $match->setSport($this);
        }
        
        return $this;
    }
    
    public function removeMatch(Match $match): self
    {
        if ($this->matches->contains($match)) {
            $this->matches->removeElement($match);
            // set the owning side to null (unless already changed)
            if ($match->getSport() === $this) {
                $match->setSport(NULL);
            }
        }
        
        return $this;
    }
}
