<?php

namespace CentralDB\Entity;

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
     * @ORM\Column(name="role_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $roleId;

    /**
     * @var string
     *
     * @ORM\Column(name="role_name", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $roleName;

    /**
     * @var string
     *
     * @ORM\Column(name="role_permissions", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $rolePermissions;


    /**
     * Get roleId
     *
     * @return integer 
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set roleName
     *
     * @param string $roleName
     * @return Roles
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;
    
        return $this;
    }

    /**
     * Get roleName
     *
     * @return string 
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * Set rolePermissions
     *
     * @param string $rolePermissions
     * @return Roles
     */
    public function setRolePermissions($rolePermissions)
    {
        $this->rolePermissions = $rolePermissions;
    
        return $this;
    }

    /**
     * Get rolePermissions
     *
     * @return string 
     */
    public function getRolePermissions()
    {
        return $this->rolePermissions;
    }
}
