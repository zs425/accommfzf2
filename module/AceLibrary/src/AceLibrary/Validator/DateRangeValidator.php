<?php
namespace AceLibrary\Validator;

use Zend\Db\Sql\Where;
use Zend\Validator\Translator\TranslatorAwareInterface;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com> 
 */
class DateRangeValidator extends \Zend\Validator\AbstractValidator {

	protected $options = array(
		'min'	=> null,
		'max'	=> null,
	);

	protected $messageVariables = array(
		'min'	=> array('options' => 'min'),
		'max'	=> array('options' => 'max'),
	);

	const ERROR_MIN = 'errorMin';
	const ERROR_MAX = 'errorMax';
	const ERROR_RANGE = 'errorRange';	

	public function __construct(array $options = array()) {
		$this->messageTemplates = array(
			self::ERROR_MIN		=> $this->getTranslator()->translate('Date must be higher or equal to %min%'),
			self::ERROR_MAX		=> $this->getTranslator()->translate('Date must be lower or equal to %max%'),
			self::ERROR_RANGE	=> $this->getTranslator()->translate('Date must be between %min% and %max%'),
		);
	    parent::__construct($options);
	}

	public function isValid($value)	{
		$this->setValue($value);
		$min = $this->getOption('min');
		$max = $this->getOption('max');
		$valueTime = strtotime($value);
		$isValid = true;
		if(isset($min) && isset($max)) {
			$minTime = strtotime($min);
			$maxTime = strtotime($max);
			if($valueTime < $minTime || $valueTime > $maxTime) {
				$isValid = false;
				$this->error(self::ERROR_RANGE);
			}
		}
		else if(isset($min)) {
			$minTime = strtotime($min);
			if($valueTime < $minTime) {
				$isValid = false;
				$this->error(self::ERROR_MIN);
			}
		}
		else if(isset($max)) {
			$maxTime = strtotime($max);
			if($valueTime < $maxTime) {
				$isValid = false;
				$this->error(self::ERROR_MAX);
			}
		}
		return $isValid;
	}

}