<?php
namespace Travel\Model;

class HotelRoom
{
	public $room_id;
	public $room_name;
	public $room_shortdesc;
	public $room_description;
	public $room_lowrate;
	public $room_highrate;
	public $room_rate_basis;
	public $room_extraperson;
	public $room_guestmax;
	public $room_source;
	public $room_source_id;
	public $room_record_id;


	public function exchangeArray ($data)
	{
	 foreach ($data as $property => $value) {
        if (property_exists($this, $property)) {
            $this->{$property} = $value;
        }
    }
	}
	/**
	 * @return the $room_id
	 */
	public function getRoom_id() {
		return $this->room_id;
	}

	/**
	 * @return the $room_name
	 */
	public function getRoom_name() {
		return $this->room_name;
	}

	/**
	 * @return the $room_shortdesc
	 */
	public function getRoom_shortdesc() {
		return $this->room_shortdesc;
	}

	/**
	 * @return the $room_description
	 */
	public function getRoom_description() {
		return $this->room_description;
	}

	/**
	 * @return the $room_lowrate
	 */
	public function getRoom_lowrate() {
		return $this->room_lowrate;
	}

	/**
	 * @return the $room_highrate
	 */
	public function getRoom_highrate() {
		return $this->room_highrate;
	}

	/**
	 * @return the $room_rate_basis
	 */
	public function getRoom_rate_basis() {
		return $this->room_rate_basis;
	}

	/**
	 * @return the $room_extraperson
	 */
	public function getRoom_extraperson() {
		return $this->room_extraperson;
	}

	/**
	 * @return the $room_guestmax
	 */
	public function getRoom_guestmax() {
		return $this->room_guestmax;
	}

	/**
	 * @return the $room_source
	 */
	public function getRoom_source() {
		return $this->room_source;
	}

	/**
	 * @return the $room_source_id
	 */
	public function getRoom_source_id() {
		return $this->room_source_id;
	}

	/**
	 * @return the $room_record_id
	 */
	public function getRoom_record_id() {
		return $this->room_record_id;
	}

	/**
	 * @param field_type $room_id
	 */
	public function setRoom_id($room_id) {
		$this->room_id = $room_id;
	}

	/**
	 * @param field_type $room_name
	 */
	public function setRoom_name($room_name) {
		$this->room_name = $room_name;
	}

	/**
	 * @param field_type $room_shortdesc
	 */
	public function setRoom_shortdesc($room_shortdesc) {
		$this->room_shortdesc = $room_shortdesc;
	}

	/**
	 * @param field_type $room_description
	 */
	public function setRoom_description($room_description) {
		$this->room_description = $room_description;
	}

	/**
	 * @param field_type $room_lowrate
	 */
	public function setRoom_lowrate($room_lowrate) {
		$this->room_lowrate = $room_lowrate;
	}

	/**
	 * @param field_type $room_highrate
	 */
	public function setRoom_highrate($room_highrate) {
		$this->room_highrate = $room_highrate;
	}

	/**
	 * @param field_type $room_rate_basis
	 */
	public function setRoom_rate_basis($room_rate_basis) {
		$this->room_rate_basis = $room_rate_basis;
	}

	/**
	 * @param field_type $room_extraperson
	 */
	public function setRoom_extraperson($room_extraperson) {
		$this->room_extraperson = $room_extraperson;
	}

	/**
	 * @param field_type $room_guestmax
	 */
	public function setRoom_guestmax($room_guestmax) {
		$this->room_guestmax = $room_guestmax;
	}

	/**
	 * @param field_type $room_source
	 */
	public function setRoom_source($room_source) {
		$this->room_source = $room_source;
	}

	/**
	 * @param field_type $room_source_id
	 */
	public function setRoom_source_id($room_source_id) {
		$this->room_source_id = $room_source_id;
	}

	/**
	 * @param field_type $room_record_id
	 */
	public function setRoom_record_id($room_record_id) {
		$this->room_record_id = $room_record_id;
	}

	public function toArray()
	{
		return (array) $this;
	}

}
