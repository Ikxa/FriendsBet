<?php

namespace App\Entity\App;

use App\Repository\App\MatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatchRepository::class)
 * @ORM\Table(name="`match`")
 */
class Match
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer", length=50)
     */
    private $matchId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $team_one;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $team_two;

    /**
     * @ORM\Column(type="datetime")
     */
    private $played_at;

    /**
     * @ORM\Column(type="integer", length=2)
     */
    private $scoreHometeam;
    
    /**
     * @ORM\Column(type="integer", length=2)
     */
    private $scoreAwayteam;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_over;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="matches")
     */
    private $sport;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="rencontre")
     */
    private $bets;
    
    /**
     * Match constructor.
     */
    public function __construct()
    {
        $this->bets = new ArrayCollection();
    }
    
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @return mixed
     */
    public function getMatchId()
    {
        return $this->matchId;
    }
    
    /**
     * @param mixed $matchId
     *
     * @return Match
     */
    public function setMatchId($matchId)
    {
        $this->matchId = $matchId;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getTeamOne(): ?string
    {
        return $this->team_one;
    }
    
    /**
     * @param string $team_one
     *
     * @return $this
     */
    public function setTeamOne(string $team_one): self
    {
        $this->team_one = $team_one;

        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getTeamTwo(): ?string
    {
        return $this->team_two;
    }
    
    /**
     * @param string $team_two
     *
     * @return $this
     */
    public function setTeamTwo(string $team_two): self
    {
        $this->team_two = $team_two;

        return $this;
    }
    
    /**
     * @return \DateTimeInterface|null
     */
    public function getPlayedAt(): ?\DateTimeInterface
    {
        return $this->played_at;
    }
    
    /**
     * @param \DateTimeInterface $played_at
     *
     * @return $this
     */
    public function setPlayedAt(\DateTimeInterface $played_at): self
    {
        $this->played_at = $played_at;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getScoreHometeam()
    {
        return $this->scoreHometeam;
    }
    
    /**
     * @param mixed $scoreHometeam
     *
     * @return Match
     */
    public function setScoreHometeam($scoreHometeam)
    {
        $this->scoreHometeam = $scoreHometeam;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getScoreAwayteam()
    {
        return $this->scoreAwayteam;
    }
    
    /**
     * @param mixed $scoreAwayteam
     *
     * @return Match
     */
    public function setScoreAwayteam($scoreAwayteam)
    {
        $this->scoreAwayteam = $scoreAwayteam;
        
        return $this;
    }
    
    /**
     * @return bool|null
     */
    public function getIsOver(): ?bool
    {
        return $this->is_over;
    }
    
    /**
     * @param bool $is_over
     *
     * @return $this
     */
    public function setIsOver(bool $is_over): self
    {
        $this->is_over = $is_over;

        return $this;
    }
    
    /**
     * @return Sport|null
     */
    public function getSport(): ?Sport
    {
        return $this->sport;
    }
    
    /**
     * @param Sport|null $sport
     *
     * @return $this
     */
    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * @return Collection|Bet[]
     */
    public function getBets(): Collection
    {
        return $this->bets;
    }
    
    /**
     * @param Bet $bet
     *
     * @return $this
     */
    public function addBet(Bet $bet): self
    {
        if (!$this->bets->contains($bet)) {
            $this->bets[] = $bet;
            $bet->setRencontre($this);
        }

        return $this;
    }
    
    /**
     * @param Bet $bet
     *
     * @return $this
     */
    public function removeBet(Bet $bet): self
    {
        if ($this->bets->contains($bet)) {
            $this->bets->removeElement($bet);
            // set the owning side to null (unless already changed)
            if ($bet->getRencontre() === $this) {
                $bet->setRencontre(null);
            }
        }

        return $this;
    }
}
