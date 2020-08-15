<?php


namespace App\Service;


class GroupBuilder
{
    /**
     * Random token to symbolize a group
     *
     * @var string
     */
    private $token;
    
    /**
     * DateTime group was created
     *
     * @var \DateTime
     */
    private $created_at;
    
    /**
     * Group active or not ?
     *
     * @var bool
     */
    private $is_active = true;
    
    /**
     * Limit for the token
     *
     * @var integer;
     */
    private const TOKEN_LIMIT = 20;
    
    /**
     * @inheritDoc
     */
    public function __construct() {
        $this->created_at = new \DateTime();
        $this->token = $this->generateToken();
    }
    
    /**
     * @return GroupBuilder
     */
    public function new()
    {
        return new self();
    }
    
    public function generateToken()
    {
        return bin2hex(random_bytes(self::TOKEN_LIMIT));
    }
    
    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
    
    /**
     * @param string $token
     *
     * @return GroupBuilder
     */
    public function setToken(string $token): GroupBuilder
    {
        $this->token = $token;
        
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }
    
    /**
     * @param \DateTime $created_at
     *
     * @return GroupBuilder
     */
    public function setCreatedAt(\DateTime $created_at): GroupBuilder
    {
        $this->created_at = $created_at;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }
    
    /**
     * @param bool $is_active
     *
     * @return GroupBuilder
     */
    public function setIsActive(bool $is_active): GroupBuilder
    {
        $this->is_active = $is_active;
        
        return $this;
    }
}
