<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Roles
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity
 */
class Role
{
    /**
     * @var integer
     *
     * @ORM\Column(name="role_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $roleId;

    /**
     * @var string
     *
     * @ORM\Column(name="role_name", type="string", length=255, nullable=false)
     */
    private $roleName;

    /**
     * @var string
     *
     * @ORM\Column(name="role_permissions", type="text", nullable=true)
     */
    private $rolePermissions;
	/**
	 * @return the $roleId
	 */
	public function getRoleId() {
		return $this->roleId;
	}

	/**
	 * @param number $roleId
	 */
	public function setRoleId($roleId) {
		$this->roleId = $roleId;
	}

	/**
	 * @return the $roleName
	 */
	public function getRoleName() {
		return $this->roleName;
	}

	/**
	 * @param string $roleName
	 */
	public function setRoleName($roleName) {
		$this->roleName = $roleName;
	}

	/**
	 * @return the $rolePermissions
	 */
	public function getRolePermissions() {
		return $this->rolePermissions;
	}

	/**
	 * @param string $rolePermissions
	 */
	public function setRolePermissions($rolePermissions) {
		$this->rolePermissions = $rolePermissions;
	}
}
