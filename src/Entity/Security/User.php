<?php

namespace App\Entity\Security;

use App\Entity\App\Bet;
use App\Entity\App\Group;
use App\Repository\Security\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;
    
    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="users")
     */
    private $group_defined;
    
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
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * @param mixed $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param mixed $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @param mixed $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * @param mixed $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    /**
     * @param mixed $created_at
     *
     * @return User
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }
    
    /**
     * @param mixed $is_active
     *
     * @return User
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        if (empty($this->roles)) {
            return ['ROLE_USER'];
        }
        
        return $this->roles;
    }
    
    /**
     * @param $role
     *
     * @return mixed
     */
    public function addRole($role)
    {
        return $this->roles[] = $role;
    }
    
    /**
     * @inheritDoc
     */
    public function getSalt(): ?string
    {
        return null;
    }
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // eraseCredentials
    }

    public function getGroupDefined(): ?Group
    {
        return $this->group_defined;
    }

    public function setGroupDefined(?Group $group_defined): self
    {
        $this->group_defined = $group_defined;

        return $this;
    }
}
