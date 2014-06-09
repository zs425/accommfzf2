<?php
namespace Travel\Model;

class ProductInfo
{
public $info_id;
public $info_code;
public $info_title;
public $info_body;
public $info_record_id;



	public function exchangeArray ($data)
	{
	 foreach ($data as $property => $value) {
	 	if (property_exists($this, $property)) {
	 		$this->{$property} = $value;
	 	}
	 }
	}
	/**
	 * @return the $info_id
	 */
	public function getInfo_id() {
		return $this->info_id;
	}

	/**
	 * @return the $info_code
	 */
	public function getInfo_code() {
		return $this->info_code;
	}

	/**
	 * @return the $info_title
	 */
	public function getInfo_title() {
		return $this->info_title;
	}

	/**
	 * @return the $info_body
	 */
	public function getInfo_body() {
		return $this->info_body;
	}

	/**
	 * @return the $info_record_id
	 */
	public function getInfo_record_id() {
		return $this->info_record_id;
	}

	/**
	 * @param field_type $info_id
	 */
	public function setInfo_id($info_id) {
		$this->info_id = $info_id;
	}

	/**
	 * @param field_type $info_code
	 */
	public function setInfo_code($info_code) {
		$this->info_code = $info_code;
	}

	/**
	 * @param field_type $info_title
	 */
	public function setInfo_title($info_title) {
		$this->info_title = $info_title;
	}

	/**
	 * @param field_type $info_body
	 */
	public function setInfo_body($info_body) {
		$this->info_body = $info_body;
	}

	/**
	 * @param field_type $info_record_id
	 */
	public function setInfo_record_id($info_record_id) {
		$this->info_record_id = $info_record_id;
	}
	public function toArray()
	{
		return (array) $this;
	}

}