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
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="bets")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Match::class, inversedBy="bets")
     */
    private $rencontre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $winner;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $score;

    /**
     * @ORM\Column(type="datetime")
     */
    private $bet_at;

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

    public function getRencontre(): ?Match
    {
        return $this->rencontre;
    }

    public function setRencontre(?Match $rencontre): self
    {
        $this->rencontre = $rencontre;

        return $this;
    }

    public function getWinner(): ?string
    {
        return $this->winner;
    }

    public function setWinner(string $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getBetAt(): ?\DateTimeInterface
    {
        return $this->bet_at;
    }

    public function setBetAt(\DateTimeInterface $bet_at): self
    {
        $this->bet_at = $bet_at;

        return $this;
    }
}
