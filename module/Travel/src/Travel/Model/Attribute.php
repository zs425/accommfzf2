<?php
namespace Travel\Model;

class Attribute
{
public $attr_id;
public $attr_type;
public $attr_code;
public $attr_name;
public $attr_record_type;
public $attr_record_id;



	public function exchangeArray ($data)
	{
	 foreach ($data as $property => $value) {
	 	if (property_exists($this, $property)) {
	 		$this->{$property} = $value;
	 	}
	 }
	}
	/**
	 * @return the $attr_id
	 */
	public function getAttr_id() {
		return $this->attr_id;
	}

	/**
	 * @return the $attr_type
	 */
	public function getAttr_type() {
		return $this->attr_type;
	}

	/**
	 * @return the $attr_code
	 */
	public function getAttr_code() {
		return $this->attr_code;
	}

	/**
	 * @return the $attr_name
	 */
	public function getAttr_name() {
		return $this->attr_name;
	}

	/**
	 * @return the $attr_record_type
	 */
	public function getAttr_record_type() {
		return $this->attr_record_type;
	}

	/**
	 * @return the $attr_record_id
	 */
	public function getAttr_record_id() {
		return $this->attr_record_id;
	}

	/**
	 * @param field_type $attr_id
	 */
	public function setAttr_id($attr_id) {
		$this->attr_id = $attr_id;
	}

	/**
	 * @param field_type $attr_type
	 */
	public function setAttr_type($attr_type) {
		$this->attr_type = $attr_type;
	}

	/**
	 * @param field_type $attr_code
	 */
	public function setAttr_code($attr_code) {
		$this->attr_code = $attr_code;
	}

	/**
	 * @param field_type $attr_name
	 */
	public function setAttr_name($attr_name) {
		$this->attr_name = $attr_name;
	}

	/**
	 * @param field_type $attr_record_type
	 */
	public function setAttr_record_type($attr_record_type) {
		$this->attr_record_type = $attr_record_type;
	}

	/**
	 * @param field_type $attr_record_id
	 */
	public function setAttr_record_id($attr_record_id) {
		$this->attr_record_id = $attr_record_id;
	}

	public function toArray()
	{
		return (array) $this;
	}
}