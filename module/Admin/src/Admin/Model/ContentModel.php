<?php
namespace Admin\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Travel\Entity\Content;
use Travel\Model\AbstractModel;

/**
 * @author n3ziniuka5 
 * @property \Admin\Model\MenuModel			$menuModel
 * @property \Admin\Model\AliasModel		$aliasModel
 * @property \Admin\Service\AuthService		$authService
 */
class ContentModel extends AbstractModel {
 
    protected $menuModel;
    protected $aliasModel;
    protected $authService;
    protected $entityClass = 'Travel\Entity\Content';
    protected $primaryColumn = 'contentId';
    
    //PAGES
    public function getPageList($search = null) {
        $where = new Where();
        $select = $this->getSql()->select();
        $concat = new Expression('a.alias_system = CONCAT("/content/", content_id)');
        $select->columns(array('content_id', 'content_created', 'content_title', 'content_type', 'content_status'))
                ->from(array('c' => 'content'))
                ->join(array('u' => 'users'), 'u.user_id = content_user_id', array('username'), Select::JOIN_LEFT)
                ->join(array('a' => 'aliases'), $concat, array('url' => 'alias_route'), Select::JOIN_LEFT)
                ->where($where)
                ->order('content_created DESC');
        $where->equalTo('c.content_type', 'page');
        if($search) {
            $where->NEST->like('c.content_body', "%$search%")->OR
                        ->like('c.content_title', "%$search%")->OR
                        ->like('c.content_shortdesc', "%$search%")->UNNEST;
        }
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $this->getDbAdapter()->query($sql, array())->toArray();
        foreach($result as &$row) {
            if(!$row['url']) {
                $row['url'] = '/content/' . $row['content_id'];
            }
        }
        return $result;
    }
    
    public function getPage($id) {
        $where = new Where();
        $select = $this->getSql()->select();
        $concat = new Expression('a.alias_system = CONCAT("/content/", content_id)');
        $select->from(array('c' => 'content'))
               ->join(array('a' => 'aliases'), $concat, array('alias_route', 'alias_id'), Select::JOIN_LEFT)
               ->where($where);
        $where->equalTo('c.content_type', 'page')
              ->equalTo('c.content_id', $id);
        $statement = $this->getSql()->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $result->current();
    }
    
    public function addPage($data) {
    	$content = new Content();
        $content->setContentTitle($data['content_title']);
		$content->setContentBody($data['content_body']);
		$content->setContentStatus($data['content_status']);
		$content->setContentMetatitle($data['content_metatitle']);
		$content->setContentMetakeywords($data['content_metakeywords']);
		$content->setContentUserId($this->getEntityManager()->getReference('Travel\Entity\User', $this->getAuthService()->getUserId()));
		$content->setContentCreated(time());
		$this->getEntityManager()->persist($content);
        if($data['alias_route']) {
        	$this->getEntityManager()->flush(); //Needed to get the new page id;
            $alias = array(
                'alias_system'  => '/content/' . $content->getContentId(),
                'alias_route'   => $data['alias_route']
            );
            $this->getAliasModel()->add($alias);
        }
    }
    
    public function editPage($id, $data) {
    	$content = $this->getEntityManager()->find($this->entityClass, $id);
    	if($content) {
    		$content->setContentTitle($data['content_title']);
    		$content->setContentBody($data['content_body']);
    		$content->setContentStatus($data['content_status']);
    		$content->setContentMetaTitle($data['content_metatitle']);
    		$content->setContentMetaKeywords($data['content_metakeywords']);
    		$content->setContentMetaDescription($data['content_metakeywords']);
    		$this->getEntityManager()->persist($content);
    		if($data['alias_route'] != $data['last_alias']) {
    			$this->getAliasModel()->delete($data['last_alias_id']);
    			$alias = array(
    					'alias_system'  => '/content/' . $id,
    					'alias_route'   => $data['alias_route']
    			);
    			$this->getAliasModel()->add($alias);
    		}
    	}
    }
    
    //CONTENT
    
    public function bulkDelete($ids) {
    	$qb = $this->getEntityManager()->createQueryBuilder();
    	$qb->delete('Travel\Entity\Content', 'c');
    	$qb->where($qb->expr()->in('c.contentId', $ids));
    	$query = $qb->getQuery();
    	$query->execute();
    	
    	$aliases = array();
    	foreach($ids as $id) {
    	    $aliases[] = '/content/' . $id;
    	}
    	$qb = $this->getEntityManager()->createQueryBuilder();
    	$qb->delete('Travel\Entity\Alias', 'a');
    	$qb->where($qb->expr()->in('a.aliasSystem', $aliases));
    	$query = $qb->getQuery();
    	$query->execute();
    }
    
    public function getMenuModel() {
        if(!$this->menuModel) {
            $this->menuModel = $this->getServiceManager()->get('Admin\Model\MenuModel');
        }
        return $this->menuModel;
    }
    
    protected function getAliasModel() {
    	if(!$this->aliasModel) {
    		$this->aliasModel = $this->getServiceManager()->get('Admin\Model\AliasModel');
    	}
    	return $this->aliasModel;
    }
    
    protected function getAuthService() {
    	if(!$this->authService) {
    		$this->authService = $this->getServiceManager()->get('Admin\Service\AuthService');
    	}
    	return $this->authService;
    }

}