<?php
namespace Travel\Model;

class Multimedia
{
public $multimedia_id;
public $multimedia_type;
public $multimedia_path;
public $multimedia_description;
public $multimedia_width;
public $multimedia_height;
public $multimedia_source;
public $multimedia_record_type;
public $multimedia_record_id;
public $multimedia_s3bukcet;
public $multimedia_exists;





	public function exchangeArray ($data)
	{
	 foreach ($data as $property => $value) {
	 	if (property_exists($this, $property)) {
	 		$this->{$property} = $value;
	 	}
	 }
	}
	/**
	 * @return the $multimedia_id
	 */
	public function getMultimedia_id() {
		return $this->multimedia_id;
	}

	/**
	 * @return the $multimedia_type
	 */
	public function getMultimedia_type() {
		return $this->multimedia_type;
	}

	/**
	 * @return the $multimedia_path
	 */
	public function getMultimedia_path() {
		return $this->multimedia_path;
	}

	/**
	 * @return the $multimedia_description
	 */
	public function getMultimedia_description() {
		return $this->multimedia_description;
	}

	/**
	 * @return the $multimedia_width
	 */
	public function getMultimedia_width() {
		return $this->multimedia_width;
	}

	/**
	 * @return the $multimedia_height
	 */
	public function getMultimedia_height() {
		return $this->multimedia_height;
	}

	/**
	 * @return the $multimedia_source
	 */
	public function getMultimedia_source() {
		return $this->multimedia_source;
	}

	/**
	 * @return the $multimedia_record_type
	 */
	public function getMultimedia_record_type() {
		return $this->multimedia_record_type;
	}

	/**
	 * @return the $multimedia_record_id
	 */
	public function getMultimedia_record_id() {
		return $this->multimedia_record_id;
	}

	/**
	 * @return the $multimedia_s3bukcet
	 */
	public function getMultimedia_s3bukcet() {
		return $this->multimedia_s3bukcet;
	}

	/**
	 * @return the $multimedia_exists
	 */
	public function getMultimedia_exists() {
		return $this->multimedia_exists;
	}

	/**
	 * @param field_type $multimedia_id
	 */
	public function setMultimedia_id($multimedia_id) {
		$this->multimedia_id = $multimedia_id;
	}

	/**
	 * @param field_type $multimedia_type
	 */
	public function setMultimedia_type($multimedia_type) {
		$this->multimedia_type = $multimedia_type;
	}

	/**
	 * @param field_type $multimedia_path
	 */
	public function setMultimedia_path($multimedia_path) {
		$this->multimedia_path = $multimedia_path;
	}

	/**
	 * @param field_type $multimedia_description
	 */
	public function setMultimedia_description($multimedia_description) {
		$this->multimedia_description = $multimedia_description;
	}

	/**
	 * @param field_type $multimedia_width
	 */
	public function setMultimedia_width($multimedia_width) {
		$this->multimedia_width = $multimedia_width;
	}

	/**
	 * @param field_type $multimedia_height
	 */
	public function setMultimedia_height($multimedia_height) {
		$this->multimedia_height = $multimedia_height;
	}

	/**
	 * @param field_type $multimedia_source
	 */
	public function setMultimedia_source($multimedia_source) {
		$this->multimedia_source = $multimedia_source;
	}

	/**
	 * @param field_type $multimedia_record_type
	 */
	public function setMultimedia_record_type($multimedia_record_type) {
		$this->multimedia_record_type = $multimedia_record_type;
	}

	/**
	 * @param field_type $multimedia_record_id
	 */
	public function setMultimedia_record_id($multimedia_record_id) {
		$this->multimedia_record_id = $multimedia_record_id;
	}

	/**
	 * @param field_type $multimedia_s3bukcet
	 */
	public function setMultimedia_s3bukcet($multimedia_s3bukcet) {
		$this->multimedia_s3bukcet = $multimedia_s3bukcet;
	}

	/**
	 * @param field_type $multimedia_exists
	 */
	public function setMultimedia_exists($multimedia_exists) {
		$this->multimedia_exists = $multimedia_exists;
	}

	public function toArray()
	{
		return (array) $this;
	}
}
