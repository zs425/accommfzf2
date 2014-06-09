<?php
namespace Content\Model;
use Travel\Model\AbstractModel;
/**
 * @author n3ziniuka5
 * 
 */
class ContentModel extends AbstractModel {
    
    /**
     * @return \Travel\Entity\Content
     */
    public function get($id) {
    	$dql = 'SELECT c, partial u.{userId, username} FROM Travel\Entity\Content c JOIN c.contentUserId u WHERE c.contentStatus = :contentStatus AND c.contentType = :contentType AND c.contentId = :contentId';
        $query = $this->getEntityManager()->createQuery($dql);
        $params = array(
        	'contentStatus'	=> 'published',
        	'contentType'	=> 'page',
        	'contentId'		=> $id
        );
        $query->setParameters($params);
        return $query->getOneOrNullResult();
    }

}