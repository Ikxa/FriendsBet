<?php

namespace App\Entity\App;

use App\Repository\App\MatchToBetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatchToBetRepository::class)
 * @ORM\Table(name="`matchToBet`")
 */
class MatchToBet
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
    private $first_team;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $second_team;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $score_first_team;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $score_second_team;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $played_at;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_over;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $winner;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $match_id;
    
    /**
     * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="matches")
     */
    private $sport;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_custom;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="matchToBet")
     */
    private $bets;

    public function __construct()
    {
        $this->bets = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getFirstTeam(): ?string
    {
        return $this->first_team;
    }
    
    public function setFirstTeam(string $first_team): self
    {
        $this->first_team = $first_team;
        
        return $this;
    }
    
    public function getSecondTeam(): ?string
    {
        return $this->second_team;
    }
    
    public function setSecondTeam(string $second_team): self
    {
        $this->second_team = $second_team;
        
        return $this;
    }
    
    public function getScoreFirstTeam(): ?int
    {
        return $this->score_first_team;
    }
    
    public function setScoreFirstTeam(int $score_first_team): self
    {
        $this->score_first_team = $score_first_team;
        
        return $this;
    }
    
    public function getScoreSecondTeam(): ?int
    {
        return $this->score_second_team;
    }
    
    public function setScoreSecondTeam(int $score_second_team): self
    {
        $this->score_second_team = $score_second_team;
        
        return $this;
    }
    
    public function getPlayedAt(): ?\DateTimeInterface
    {
        return $this->played_at;
    }
    
    public function setPlayedAt(\DateTimeInterface $played_at): self
    {
        $this->played_at = $played_at;
        
        return $this;
    }
    
    public function getIsOver(): ?bool
    {
        return $this->is_over;
    }
    
    public function setIsOver(bool $is_over): self
    {
        $this->is_over = $is_over;
        
        return $this;
    }
    
    public function getStatus(): ?string
    {
        return $this->status;
    }
    
    public function setStatus(string $status): self
    {
        $this->status = $status;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getWinner()
    {
        return $this->winner;
    }
    
    /**
     * @param mixed $winner
     *
     * @return self
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
        
        return $this;
    }
    
    public function getMatchId(): ?int
    {
        return $this->match_id;
    }
    
    public function setMatchId(int $match_id): self
    {
        $this->match_id = $match_id;
        
        return $this;
    }
    
    public function getSport(): ?Sport
    {
        return $this->sport;
    }
    
    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;
        
        return $this;
    }
    
    public function getIsCustom(): ?bool
    {
        return $this->is_custom;
    }
    
    public function setIsCustom(?bool $is_custom): self
    {
        $this->is_custom = $is_custom;
        
        return $this;
    }

    /**
     * @return Collection|Bet[]
     */
    public function getBets(): Collection
    {
        return $this->bets;
    }

    public function addBet(Bet $bet): self
    {
        if (!$this->bets->contains($bet)) {
            $this->bets[] = $bet;
            $bet->setMatchToBet($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): self
    {
        if ($this->bets->contains($bet)) {
            $this->bets->removeElement($bet);
            // set the owning side to null (unless already changed)
            if ($bet->getMatchToBet() === $this) {
                $bet->setMatchToBet(null);
            }
        }

        return $this;
    }
}
