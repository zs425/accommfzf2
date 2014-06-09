<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductChangesdetail
 *
 * @ORM\Table(name="product_changesdetail")
 * @ORM\Entity
 */
class ProductChangesdetail
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */                
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="change_id", type="integer", nullable=false)
     */
    private $changeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="change_field", type="string", nullable=false)
     */
    private $changeField;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="old_value", type="string")
     */
    private $oldValue;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="new_value", type="string")
     */
    private $newValue;

    /**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }
                               
    /**
     * @param number $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return the $changeId
     */
    public function getChangeId() {
        return $this->changeId;
    }

    /**
     * @param string $changeId
     */
    public function setChangeId($changeId) {
        $this->changeId = $changeId;
    }

    /**
     * @return the $changeField
     */
    public function getChangeField() {
        return $this->changeField;
    }

    /**
     * @param string $changeField
     */
    public function setChangeField($changeField) {
        $this->changeField = $changeField;
    }
    
    /**
     * @return the $oldValue
     */
    public function getOldValue() {
        return $this->oldValue;
    }

    /**
     * @param string $oldValue
     */
    public function setOldValue($oldValue) {
        $this->oldValue = $oldValue;
    }
    
    /**
     * @return the $newValue
     */
    public function getNewValue() {
        return $this->newValue;
    }

    /**
     * @param string $newValue
     */
    public function setNewValue($newValue) {
        $this->newValue = $newValue;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function set($key, $value){
        $this->{'set'.ucfirst($key)}($value);
    }
}