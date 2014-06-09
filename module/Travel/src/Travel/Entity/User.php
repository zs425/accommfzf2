<?php
namespace Travel\Entity;

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
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_customer_id", type="integer", nullable=false)
     */
    private $userCustomerId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="email_verification", type="string", length=36, nullable=false)
     */
    private $emailVerification;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=90, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="password_open", type="string", length=255, nullable=true)
     */
    private $passwordOpen;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_lastlogin", type="integer", nullable=false)
     */
    private $userLastlogin;

    /**
     * @var string
     *
     * @ORM\Column(name="user_host", type="string", length=255, nullable=false)
     */
    private $userHost;

    /**
     * @var string
     *
     * @ORM\Column(name="user_role", type="string", length=36, nullable=false)
     */
    private $userRole;

    /**
     * @var string
     *
     * @ORM\Column(name="user_status", type="string", length=90, nullable=false)
     */
    private $userStatus;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_created", type="integer", nullable=false)
     */
    private $userCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_modified", type="integer", nullable=false)
     */
    private $userModified;

    /**
     * @ORM\OneToMany(targetEntity="Travel\Entity\Content", mappedBy="contentUserId")
     */
    private $createdContent;
    
    /**
	 * @return the $createdContent
	 */
	public function getCreatedContent() {
		return $this->createdContent;
	}

	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection $createdContent
	 */
	public function setCreatedContent($createdContent) {
		$this->createdContent = $createdContent;
	}

	public function __construct() {
    	$this->createdContent = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
	/**
	 * @return the $userId
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @param number $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
	}

	/**
	 * @return the $userCustomerId
	 */
	public function getUserCustomerId() {
		return $this->userCustomerId;
	}

	/**
	 * @param number $userCustomerId
	 */
	public function setUserCustomerId($userCustomerId) {
		$this->userCustomerId = $userCustomerId;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return the $emailVerification
	 */
	public function getEmailVerification() {
		return $this->emailVerification;
	}

	/**
	 * @param string $emailVerification
	 */
	public function setEmailVerification($emailVerification) {
		$this->emailVerification = $emailVerification;
	}

	/**
	 * @return the $username
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param string $username
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @return the $passwordOpen
	 */
	public function getPasswordOpen() {
		return $this->passwordOpen;
	}

	/**
	 * @param string $passwordOpen
	 */
	public function setPasswordOpen($passwordOpen) {
		$this->passwordOpen = $passwordOpen;
	}

	/**
	 * @return the $userLastlogin
	 */
	public function getUserLastlogin() {
		return $this->userLastlogin;
	}

	/**
	 * @param number $userLastlogin
	 */
	public function setUserLastlogin($userLastlogin) {
		$this->userLastlogin = $userLastlogin;
	}

	/**
	 * @return the $userHost
	 */
	public function getUserHost() {
		return $this->userHost;
	}

	/**
	 * @param string $userHost
	 */
	public function setUserHost($userHost) {
		$this->userHost = $userHost;
	}

	/**
	 * @return the $userRole
	 */
	public function getUserRole() {
		return $this->userRole;
	}

	/**
	 * @param string $userRole
	 */
	public function setUserRole($userRole) {
		$this->userRole = $userRole;
	}

	/**
	 * @return the $userStatus
	 */
	public function getUserStatus() {
		return $this->userStatus;
	}

	/**
	 * @param string $userStatus
	 */
	public function setUserStatus($userStatus) {
		$this->userStatus = $userStatus;
	}

	/**
	 * @return the $userCreated
	 */
	public function getUserCreated() {
		return $this->userCreated;
	}

	/**
	 * @param number $userCreated
	 */
	public function setUserCreated($userCreated) {
		$this->userCreated = $userCreated;
	}

	/**
	 * @return the $userModified
	 */
	public function getUserModified() {
		return $this->userModified;
	}

	/**
	 * @param number $userModified
	 */
	public function setUserModified($userModified) {
		$this->userModified = $userModified;
	}
}