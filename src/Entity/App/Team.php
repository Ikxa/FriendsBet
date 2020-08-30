<?php

namespace App\Entity\App;

use App\Repository\App\TeamRepository;
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

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
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param mixed $id
     *
     * @return Team
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param mixed $name
     *
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }
    
    /**
     * @param mixed $logo
     *
     * @return Team
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getStadium()
    {
        return $this->stadium;
    }
    
    /**
     * @param mixed $stadium
     *
     * @return Team
     */
    public function setStadium($stadium)
    {
        $this->stadium = $stadium;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getLeague()
    {
        return $this->league;
    }
    
    /**
     * @param mixed $league
     *
     * @return Team
     */
    public function setLeague($league)
    {
        $this->league = $league;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    /**
     * @param mixed $isActive
     *
     * @return Team
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        
        return $this;
    }
}
