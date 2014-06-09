<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="email_verification", type="string", length=36, precision=0, scale=0, nullable=false, unique=false)
     */
    private $emailVerification;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=90, precision=0, scale=0, nullable=false, unique=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="password_open", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $passwordOpen;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_lastlogin", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $userLastlogin;

    /**
     * @var string
     *
     * @ORM\Column(name="user_host", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $userHost;

    /**
     * @var string
     *
     * @ORM\Column(name="user_role", type="string", length=36, precision=0, scale=0, nullable=false, unique=false)
     */
    private $userRole;

    /**
     * @var string
     *
     * @ORM\Column(name="user_status", type="string", length=90, precision=0, scale=0, nullable=false, unique=false)
     */
    private $userStatus;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_created", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $userCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_modified", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $userModified;


    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set emailVerification
     *
     * @param string $emailVerification
     * @return Users
     */
    public function setEmailVerification($emailVerification)
    {
        $this->emailVerification = $emailVerification;
    
        return $this;
    }

    /**
     * Get emailVerification
     *
     * @return string 
     */
    public function getEmailVerification()
    {
        return $this->emailVerification;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set passwordOpen
     *
     * @param string $passwordOpen
     * @return Users
     */
    public function setPasswordOpen($passwordOpen)
    {
        $this->passwordOpen = $passwordOpen;
    
        return $this;
    }

    /**
     * Get passwordOpen
     *
     * @return string 
     */
    public function getPasswordOpen()
    {
        return $this->passwordOpen;
    }

    /**
     * Set userLastlogin
     *
     * @param integer $userLastlogin
     * @return Users
     */
    public function setUserLastlogin($userLastlogin)
    {
        $this->userLastlogin = $userLastlogin;
    
        return $this;
    }

    /**
     * Get userLastlogin
     *
     * @return integer 
     */
    public function getUserLastlogin()
    {
        return $this->userLastlogin;
    }

    /**
     * Set userHost
     *
     * @param string $userHost
     * @return Users
     */
    public function setUserHost($userHost)
    {
        $this->userHost = $userHost;
    
        return $this;
    }

    /**
     * Get userHost
     *
     * @return string 
     */
    public function getUserHost()
    {
        return $this->userHost;
    }

    /**
     * Set userRole
     *
     * @param string $userRole
     * @return Users
     */
    public function setUserRole($userRole)
    {
        $this->userRole = $userRole;
    
        return $this;
    }

    /**
     * Get userRole
     *
     * @return string 
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * Set userStatus
     *
     * @param string $userStatus
     * @return Users
     */
    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;
    
        return $this;
    }

    /**
     * Get userStatus
     *
     * @return string 
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    /**
     * Set userCreated
     *
     * @param integer $userCreated
     * @return Users
     */
    public function setUserCreated($userCreated)
    {
        $this->userCreated = $userCreated;
    
        return $this;
    }

    /**
     * Get userCreated
     *
     * @return integer 
     */
    public function getUserCreated()
    {
        return $this->userCreated;
    }

    /**
     * Set userModified
     *
     * @param integer $userModified
     * @return Users
     */
    public function setUserModified($userModified)
    {
        $this->userModified = $userModified;
    
        return $this;
    }

    /**
     * Get userModified
     *
     * @return integer 
     */
    public function getUserModified()
    {
        return $this->userModified;
    }
}
