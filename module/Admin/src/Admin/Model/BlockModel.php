<?php
namespace Admin\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Travel\Entity\Block;
use Travel\Model\AbstractModel;

class BlockModel extends AbstractModel {
 
    protected $entityClass = 'Travel\Entity\Block';
    protected $primaryColumn = 'blockId';
    
    public function getBlock($block_selector) {
        $where = new Where();
        $select = $this->getSql()->select();
        $select->from(array('b' => 'blocks'))              
               ->where($where);
        $where->equalTo('b.block_selector', $block_selector);
        $statement = $this->getSql()->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $result->current();
    }
	
	public function addBlock($data) {
    	$block = new Block();
    	
		$block->setBlockModule($data['block_module']);
		$block->setBlockArea($data['block_area']);
		$block->setBlockSelector($data['block_selector']);
		$block->setBlockCustom($data['block_custom']);
		$block->setBlockStatus($data['block_status']);		
		$block->setBlockDescription($data['block_description']);
		
		$this->getEntityManager()->persist($block);			    	
    }
	
	public function editBlock($id, $data) {
    	$block = $this->getEntityManager()->find($this->entityClass, $id);
    	if($block) {
    		$block->setBlockModule($data['block_module']);
			$block->setBlockArea($data['block_area']);
			$block->setBlockSelector($data['block_selector']);
			$block->setBlockCustom($data['block_custom']);
			$block->setBlockStatus($data['block_status']);		
			$block->setBlockDescription($data['block_description']);			
    		
			$this->getEntityManager()->persist($block);			
    	}
    }	
	
}