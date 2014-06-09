<?php
namespace Travel\Model;

class Destination
{
	public $baodestination_id;
	public $baodestination_name;
	public $baodestination_description;
	public $baodestination_description_details;
	public $baodestination_state;
	public $baodestination_url;
	public $baodestination_type;
	public $baodestination_area;
	public $baodestination_region;
	public $baodestination_country;
	public $baodestination_lat;
	public $baodestination_lon;
	public $baodestination_source;
	public $baodestination_source_id;
	public $baodestination_parent_id;
	public $baodestination_alias;
	public $baodestination_disabled;
	public $baodestination_deleted;
	public $baodestination_searchdisabled;

	public function exchangeArray ($data)
	{
	 foreach ($data as $property => $value) {
        if (property_exists($this, $property)) {
            $this->{$property} = $value;
        }
    }
	}
	/**
	 * @return the $baodestination_id
	 */
	public function getBaodestination_id() {
		return $this->baodestination_id;
	}

	/**
	 * @return the $baodestination_name
	 */
	public function getBaodestination_name() {
		return $this->baodestination_name;
	}

	/**
	 * @return the $baodestination_description
	 */
	public function getBaodestination_description() {
		return $this->baodestination_description;
	}

	/**
	 * @return the $baodestination_description_details
	 */
	public function getBaodestination_description_details() {
		return $this->baodestination_description_details;
	}

	/**
	 * @return the $baodestination_state
	 */
	public function getBaodestination_state() {
		return $this->baodestination_state;
	}

	/**
	 * @return the $baodestination_url
	 */
	public function getBaodestination_url() {
		return $this->baodestination_url;
	}

	/**
	 * @return the $baodestination_type
	 */
	public function getBaodestination_type() {
		return $this->baodestination_type;
	}

	/**
	 * @return the $baodestination_area
	 */
	public function getBaodestination_area() {
		return $this->baodestination_area;
	}

	/**
	 * @return the $baodestination_region
	 */
	public function getBaodestination_region() {
		return $this->baodestination_region;
	}

	/**
	 * @return the $baodestination_country
	 */
	public function getBaodestination_country() {
		return $this->baodestination_country;
	}

	/**
	 * @return the $baodestination_lat
	 */
	public function getBaodestination_lat() {
		return $this->baodestination_lat;
	}

	/**
	 * @return the $baodestination_lon
	 */
	public function getBaodestination_lon() {
		return $this->baodestination_lon;
	}

	/**
	 * @return the $baodestination_source
	 */
	public function getBaodestination_source() {
		return $this->baodestination_source;
	}

	/**
	 * @return the $baodestination_source_id
	 */
	public function getBaodestination_source_id() {
		return $this->baodestination_source_id;
	}

	/**
	 * @return the $baodestination_parent_id
	 */
	public function getBaodestination_parent_id() {
		return $this->baodestination_parent_id;
	}

	/**
	 * @return the $baodestination_alias
	 */
	public function getBaodestination_alias() {
		return $this->baodestination_alias;
	}

	/**
	 * @return the $baodestination_disabled
	 */
	public function getBaodestination_disabled() {
		return $this->baodestination_disabled;
	}

	/**
	 * @return the $baodestination_deleted
	 */
	public function getBaodestination_deleted() {
		return $this->baodestination_deleted;
	}

	/**
	 * @return the $baodestination_searchdisabled
	 */
	public function getBaodestination_searchdisabled() {
		return $this->baodestination_searchdisabled;
	}

	/**
	 * @param field_type $baodestination_id
	 */
	public function setBaodestination_id($baodestination_id) {
		$this->baodestination_id = $baodestination_id;
	}

	/**
	 * @param field_type $baodestination_name
	 */
	public function setBaodestination_name($baodestination_name) {
		$this->baodestination_name = $baodestination_name;
	}

	/**
	 * @param field_type $baodestination_description
	 */
	public function setBaodestination_description($baodestination_description) {
		$this->baodestination_description = $baodestination_description;
	}

	/**
	 * @param field_type $baodestination_description_details
	 */
	public function setBaodestination_description_details($baodestination_description_details) {
		$this->baodestination_description_details = $baodestination_description_details;
	}

	/**
	 * @param field_type $baodestination_state
	 */
	public function setBaodestination_state($baodestination_state) {
		$this->baodestination_state = $baodestination_state;
	}

	/**
	 * @param field_type $baodestination_url
	 */
	public function setBaodestination_url($baodestination_url) {
		$this->baodestination_url = $baodestination_url;
	}

	/**
	 * @param field_type $baodestination_type
	 */
	public function setBaodestination_type($baodestination_type) {
		$this->baodestination_type = $baodestination_type;
	}

	/**
	 * @param field_type $baodestination_area
	 */
	public function setBaodestination_area($baodestination_area) {
		$this->baodestination_area = $baodestination_area;
	}

	/**
	 * @param field_type $baodestination_region
	 */
	public function setBaodestination_region($baodestination_region) {
		$this->baodestination_region = $baodestination_region;
	}

	/**
	 * @param field_type $baodestination_country
	 */
	public function setBaodestination_country($baodestination_country) {
		$this->baodestination_country = $baodestination_country;
	}

	/**
	 * @param field_type $baodestination_lat
	 */
	public function setBaodestination_lat($baodestination_lat) {
		$this->baodestination_lat = $baodestination_lat;
	}

	/**
	 * @param field_type $baodestination_lon
	 */
	public function setBaodestination_lon($baodestination_lon) {
		$this->baodestination_lon = $baodestination_lon;
	}

	/**
	 * @param field_type $baodestination_source
	 */
	public function setBaodestination_source($baodestination_source) {
		$this->baodestination_source = $baodestination_source;
	}

	/**
	 * @param field_type $baodestination_source_id
	 */
	public function setBaodestination_source_id($baodestination_source_id) {
		$this->baodestination_source_id = $baodestination_source_id;
	}

	/**
	 * @param field_type $baodestination_parent_id
	 */
	public function setBaodestination_parent_id($baodestination_parent_id) {
		$this->baodestination_parent_id = $baodestination_parent_id;
	}

	/**
	 * @param field_type $baodestination_alias
	 */
	public function setBaodestination_alias($baodestination_alias) {
		$this->baodestination_alias = $baodestination_alias;
	}

	/**
	 * @param field_type $baodestination_disabled
	 */
	public function setBaodestination_disabled($baodestination_disabled) {
		$this->baodestination_disabled = $baodestination_disabled;
	}

	/**
	 * @param field_type $baodestination_deleted
	 */
	public function setBaodestination_deleted($baodestination_deleted) {
		$this->baodestination_deleted = $baodestination_deleted;
	}

	/**
	 * @param field_type $baodestination_searchdisabled
	 */
	public function setBaodestination_searchdisabled($baodestination_searchdisabled) {
		$this->baodestination_searchdisabled = $baodestination_searchdisabled;
	}

	public function toArray()
	{
		return (array) $this;
	}
}
