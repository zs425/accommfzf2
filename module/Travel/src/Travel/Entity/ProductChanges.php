<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductChanges
 *
 * @ORM\Table(name="product_changes")
 * @ORM\Entity
 */
class ProductChanges
{
    
    public function __construct() {
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="change_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */                
    private $changeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     */
    private $productId;
    
    /**
     * @var Travel\Entity\User
     * @ORM\ManyToOne(targetEntity="Travel\Entity\User", inversedBy="userId")
     * @ORM\JoinColumn(name="admin_id", referencedColumnName="user_id")
     */
    private $adminId;

    /**
     * @var integer
     * 
     * @ORM\Column(name="change_date", type="integer", nullable=false)
     */
    private $changeDate;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="change_back", type="integer", nullable=true)
     */
    private $changeBack;

    /**
     * @return the $changeId
     */
    public function getChangeId() {
        return $this->changeId;
    }

    /**
     * @param number $changeId
     */
    public function setChangeId($changeId) {
        $this->changeId = $changeId;
    }

    /**
     * @return the $productId
     */
    public function getProductId() {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId($productId) {
        $this->productId = $productId;
    }
    
    /**
     * @return the $adminId
     */
    public function getAdminId() {
        return $this->adminId;
    }

    /**
     * @param string $adminId
     */
    public function setAdminId($adminId) {
        $this->adminId = $adminId;
    }

    /**
     * @return the $changeDate
     */
    public function getChangeDate() {
        return $this->changeDate;
    }

    /**
     * @param string $changeDate
     */
    public function setChangeDate($changeDate) {
        $this->changeDate = $changeDate;
    }
    
    /**
     * @return the $changeBack
     */
    public function getChangeBack() {
        return $this->changeBack;
    }

    /**
     * @param string $changeBack
     */
    public function setChangeBack($changeBack) {
        $this->changeBack = $changeBack;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function set($key, $value){
        $this->{'set'.ucfirst($key)}($value);
    }
}