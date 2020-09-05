<?php

namespace App\Entity\App;

use App\Entity\Security\User;
use App\Repository\App\BetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BetRepository::class)
 */
class Bet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="bets")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scoreFirstTeam;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scoreSecondTeam;

    /**
     * @ORM\ManyToOne(targetEntity=MatchToBet::class, inversedBy="bets")
     */
    private $matchToBet;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="bets")
     */
    private $user_group;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
        }

        return $this;
    }

    public function getScoreFirstTeam(): ?int
    {
        return $this->scoreFirstTeam;
    }

    public function setScoreFirstTeam(?int $scoreFirstTeam): self
    {
        $this->scoreFirstTeam = $scoreFirstTeam;

        return $this;
    }

    public function getScoreSecondTeam(): ?int
    {
        return $this->scoreSecondTeam;
    }

    public function setScoreSecondTeam(?int $scoreSecondTeam): self
    {
        $this->scoreSecondTeam = $scoreSecondTeam;

        return $this;
    }

    public function getMatchToBet(): ?MatchToBet
    {
        return $this->matchToBet;
    }

    public function setMatchToBet(?MatchToBet $matchToBet): self
    {
        $this->matchToBet = $matchToBet;

        return $this;
    }

    public function getUserGroup(): ?Group
    {
        return $this->user_group;
    }

    public function setUserGroup(?Group $user_group): self
    {
        $this->user_group = $user_group;

        return $this;
    }
}
