<?php
namespace AceLibrary\Validator;

use Zend\Db\Sql\Where;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Doctrine\ORM\EntityManager	$entityManager
 */
class UniqueValueValidator extends \Zend\Validator\AbstractValidator
{

	const IN_USE = 'inUse';

	protected $messageTemplates = array(
			self::IN_USE => "%value% is already in use"
	);
	
	protected $sm;
	protected $table;
	protected $col;
	protected $primary;
	protected $omit;
	protected $entityManager;
	
	public function __construct($sm, $table, $col, $primary, $omit = null) {
	    parent::__construct();
	    $this->sm = $sm;
	    $this->table = $table;
	    $this->col = $col;
	    $this->primary = $primary;
	    $this->omit = $omit;
	    $this->entityManager = $this->sm->get('Doctrine\ORM\EntityManager');
	}

	public function isValid($value)
	{
		$this->setValue($value);
		$qb = $this->entityManager->createQueryBuilder();
		$qb->select(sprintf('a.' . $this->primary));
		$qb->from($this->table, 'a');
		$where = $qb->expr()->andX();
		$where->add($qb->expr()->eq('a.' . $this->col, ':value')); 
		$qb->setParameter('value', $this->value);
		if($this->omit) {
			$where->add($qb->expr()->neq('a.' . $this->primary, ':omit'));
			$qb->setParameter('omit', $this->omit);
		}
		$qb->where($where);
		$row = $qb->getQuery()->getArrayResult();
		if($row) {
		    $this->error(self::IN_USE);
		    return false;
		}
		return true;
	}
}