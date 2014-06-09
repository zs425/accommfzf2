<?php
namespace Travel\Model;

class ContentBox
{
public $ctbox_id;
public $ctbox_title;
public $ctbox_desc;
public $ctbox_link;
public $ctbox_anchor;
public $ctbox_image;
public $ctbox_order;



	public function exchangeArray ($data)
	{
	 foreach ($data as $property => $value) {
	 	if (property_exists($this, $property)) {
	 		$this->{$property} = $value;
	 	}
	 }
	}

	public function toArray()
	{
		return (array) $this;
	}
	/**
	 * @return the $ctbox_id
	 */
	public function getCtbox_id() {
		return $this->ctbox_id;
	}

	/**
	 * @return the $ctbox_title
	 */
	public function getCtbox_title() {
		return $this->ctbox_title;
	}

	/**
	 * @return the $ctbox_desc
	 */
	public function getCtbox_desc() {
		return $this->ctbox_desc;
	}

	/**
	 * @return the $ctbox_link
	 */
	public function getCtbox_link() {
		return $this->ctbox_link;
	}

	/**
	 * @return the $ctbox_anchor
	 */
	public function getCtbox_anchor() {
		return $this->ctbox_anchor;
	}

	/**
	 * @return the $ctbox_image
	 */
	public function getCtbox_image() {
		return $this->ctbox_image;
	}

	/**
	 * @return the $ctbox_order
	 */
	public function getCtbox_order() {
		return $this->ctbox_order;
	}

	/**
	 * @param field_type $ctbox_id
	 */
	public function setCtbox_id($ctbox_id) {
		$this->ctbox_id = $ctbox_id;
	}

	/**
	 * @param field_type $ctbox_title
	 */
	public function setCtbox_title($ctbox_title) {
		$this->ctbox_title = $ctbox_title;
	}

	/**
	 * @param field_type $ctbox_desc
	 */
	public function setCtbox_desc($ctbox_desc) {
		$this->ctbox_desc = $ctbox_desc;
	}

	/**
	 * @param field_type $ctbox_link
	 */
	public function setCtbox_link($ctbox_link) {
		$this->ctbox_link = $ctbox_link;
	}

	/**
	 * @param field_type $ctbox_anchor
	 */
	public function setCtbox_anchor($ctbox_anchor) {
		$this->ctbox_anchor = $ctbox_anchor;
	}

	/**
	 * @param field_type $ctbox_image
	 */
	public function setCtbox_image($ctbox_image) {
		$this->ctbox_image = $ctbox_image;
	}

	/**
	 * @param field_type $ctbox_order
	 */
	public function setCtbox_order($ctbox_order) {
		$this->ctbox_order = $ctbox_order;
	}

}