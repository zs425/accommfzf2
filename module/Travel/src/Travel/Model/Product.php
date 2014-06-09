<?php
namespace Travel\Model;

class Product
{



	public $category;
	public $product_id;
    public $product_name;
public $product_shortdesc;
public $product_description;
public $product_category;
public $product_source;
public $product_source_id;
public $product_country;
public $product_state;
public $product_region;
public $product_region_id;
public $product_area;
public $product_area_id;
public $region_info;
public $area_info;
public $product_city;
public $product_address;
public $product_phone;
public $product_email;
public $product_website;
public $product_lat;
public $product_lon;
public $product_photo;
public $product_star_rating;
public $product_lowrate;
public $product_highrate;
public $product_rate_basis;
public $product_checkin;
public $product_checkout;
public $product_bookable;
public $product_layout;
public $hotel_rooms;
public $multimedia;
public $product_info;
public $attributes;


    /**
	 * @return the $product_area_id
	 */
	public function getProduct_area_id() {
		return $this->product_area_id;
	}

/**
	 * @return the $product_region_id
	 */
	public function getProduct_region_id() {
		return $this->product_region_id;
	}

/**
	 * @return the $region_info
	 */
	public function getRegion_info() {
		return $this->region_info;
	}

/**
	 * @return the $product_city
	 */
	public function getProduct_city() {
		return $this->product_city;
	}

/**
	 * @param Ambigous <NULL, unknown> $product_area_id
	 */
	public function setProduct_area_id($product_area_id) {
		$this->product_area_id = $product_area_id;
	}

/**
	 * @param Ambigous <NULL, unknown> $product_region_id
	 */
	public function setProduct_region_id($product_region_id) {
		$this->product_region_id = $product_region_id;
	}

/**
	 * @param field_type $region_info
	 */
	public function setRegion_info($region_info) {
		$this->region_info = $region_info;
	}

/**
	 * @param Ambigous <NULL, unknown> $product_city
	 */
	public function setProduct_city($product_city) {
		$this->product_city = $product_city;
	}

	public function exchangeArray ($data)
    {
     foreach ($data as $property => $value) {
        if (property_exists($this, $property)) {
            $this->{$property} = $value;
        }
    }
    }




	/**
	 * @return the $destination_info
	 */
	public function getArea_info() {
		return $this->area_info;
	}

	/**
	 * @param field_type $destination_info
	 */
	public function setArea_info($area_info) {
		$this->area_info = $area_info;
	}

	/**
	 * @return the $product_id
	 */
	public function getProduct_id() {
		return $this->product_id;
	}

	/**
	 * @return the $product_name
	 */
	public function getProduct_name() {
		return $this->product_name;
	}

	/**
	 * @return the $product_shortdesc
	 */
	public function getProduct_shortdesc() {
		return $this->product_shortdesc;
	}

	/**
	 * @return the $product_description
	 */
	public function getProduct_description() {
		return $this->product_description;
	}

	/**
	 * @return the $product_category
	 */
	public function getProduct_category() {
		return $this->product_category;
	}

	/**
	 * @return the $product_source
	 */
	public function getProduct_source() {
		return $this->product_source;
	}

	/**
	 * @return the $product_source_id
	 */
	public function getProduct_source_id() {
		return $this->product_source_id;
	}

	/**
	 * @return the $product_country
	 */
	public function getProduct_country() {
		return $this->product_country;
	}

	/**
	 * @param Ambigous <NULL, unknown> $product_id
	 */
	public function setProduct_id($product_id) {
		$this->product_id = $product_id;
	}

	/**
	 * @param Ambigous <NULL, unknown> $product_name
	 */
	public function setProduct_name($product_name) {
		$this->product_name = $product_name;
	}

	/**
	 * @param Ambigous <NULL, unknown> $product_shortdesc
	 */
	public function setProduct_shortdesc($product_shortdesc) {
		$this->product_shortdesc = $product_shortdesc;
	}

	/**
	 * @param Ambigous <NULL, unknown> $product_description
	 */
	public function setProduct_description($product_description) {
		$this->product_description = $product_description;
	}

	/**
	 * @param Ambigous <NULL, unknown> $product_category
	 */
	public function setProduct_category($product_category) {
		$this->product_category = $product_category;
	}

	/**
	 * @param Ambigous <NULL, unknown> $product_source
	 */
	public function setProduct_source($product_source) {
		$this->product_source = $product_source;
	}

	/**
	 * @param Ambigous <NULL, unknown> $product_source_id
	 */
	public function setProduct_source_id($product_source_id) {
		$this->product_source_id = $product_source_id;
	}

	/**
	 * @param Ambigous <NULL, unknown> $product_country
	 */
	public function setProduct_country($product_country) {
		$this->product_country = $product_country;
	}
	/**
	 * @return the $category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * @return the $product_state
	 */
	public function getProduct_state() {
		return $this->product_state;
	}

	/**
	 * @return the $product_region
	 */
	public function getProduct_region() {
		return $this->product_region;
	}

	/**
	 * @return the $product_area
	 */
	public function getProduct_area() {
		return $this->product_area;
	}

	/**
	 * @return the $product_address
	 */
	public function getProduct_address() {
		return $this->product_address;
	}

	/**
	 * @return the $product_phone
	 */
	public function getProduct_phone() {
		return $this->product_phone;
	}

	/**
	 * @return the $product_email
	 */
	public function getProduct_email() {
		return $this->product_email;
	}

	/**
	 * @return the $product_website
	 */
	public function getProduct_website() {
		return $this->product_website;
	}

	/**
	 * @return the $product_lat
	 */
	public function getProduct_lat() {
		return $this->product_lat;
	}

	/**
	 * @return the $product_lon
	 */
	public function getProduct_lon() {
		return $this->product_lon;
	}

	/**
	 * @return the $product_photo
	 */
	public function getProduct_photo() {
		return $this->product_photo;
	}

	/**
	 * @return the $product_star_rating
	 */
	public function getProduct_star_rating() {
		return $this->product_star_rating;
	}

	/**
	 * @return the $product_lowrate
	 */
	public function getProduct_lowrate() {
		return $this->product_lowrate;
	}

	/**
	 * @return the $product_highrate
	 */
	public function getProduct_highrate() {
		return $this->product_highrate;
	}

	/**
	 * @return the $product_rate_basis
	 */
	public function getProduct_rate_basis() {
		return $this->product_rate_basis;
	}

	/**
	 * @return the $product_checkin
	 */
	public function getProduct_checkin() {
		return $this->product_checkin;
	}

	/**
	 * @return the $product_checkout
	 */
	public function getProduct_checkout() {
		return $this->product_checkout;
	}

	/**
	 * @return the $product_bookable
	 */
	public function getProduct_bookable() {
		return $this->product_bookable;
	}

	/**
	 * @return the $hotel_rooms
	 */
	public function getHotel_rooms() {
		return $this->hotel_rooms;
	}

	/**
	 * @param field_type $category
	 */
	public function setCategory($category) {
		$this->category = $category;
	}

	/**
	 * @param field_type $product_state
	 */
	public function setProduct_state($product_state) {
		$this->product_state = $product_state;
	}

	/**
	 * @param field_type $product_region
	 */
	public function setProduct_region($product_region) {
		$this->product_region = $product_region;
	}

	/**
	 * @param field_type $product_area
	 */
	public function setProduct_area($product_area) {
		$this->product_area = $product_area;
	}

	/**
	 * @param field_type $product_address
	 */
	public function setProduct_address($product_address) {
		$this->product_address = $product_address;
	}

	/**
	 * @param field_type $product_phone
	 */
	public function setProduct_phone($product_phone) {
		$this->product_phone = $product_phone;
	}

	/**
	 * @param field_type $product_email
	 */
	public function setProduct_email($product_email) {
		$this->product_email = $product_email;
	}

	/**
	 * @param field_type $product_website
	 */
	public function setProduct_website($product_website) {
		$this->product_website = $product_website;
	}

	/**
	 * @param field_type $product_lat
	 */
	public function setProduct_lat($product_lat) {
		$this->product_lat = $product_lat;
	}

	/**
	 * @param field_type $product_lon
	 */
	public function setProduct_lon($product_lon) {
		$this->product_lon = $product_lon;
	}

	/**
	 * @param field_type $product_photo
	 */
	public function setProduct_photo($product_photo) {
		$this->product_photo = $product_photo;
	}

	/**
	 * @param field_type $product_star_rating
	 */
	public function setProduct_star_rating($product_star_rating) {
		$this->product_star_rating = $product_star_rating;
	}

	/**
	 * @param field_type $product_lowrate
	 */
	public function setProduct_lowrate($product_lowrate) {
		$this->product_lowrate = $product_lowrate;
	}

	/**
	 * @param field_type $product_highrate
	 */
	public function setProduct_highrate($product_highrate) {
		$this->product_highrate = $product_highrate;
	}

	/**
	 * @param field_type $product_rate_basis
	 */
	public function setProduct_rate_basis($product_rate_basis) {
		$this->product_rate_basis = $product_rate_basis;
	}

	/**
	 * @param field_type $product_checkin
	 */
	public function setProduct_checkin($product_checkin) {
		$this->product_checkin = $product_checkin;
	}

	/**
	 * @param field_type $product_checkout
	 */
	public function setProduct_checkout($product_checkout) {
		$this->product_checkout = $product_checkout;
	}

	/**
	 * @param field_type $product_bookable
	 */
	public function setProduct_bookable($product_bookable) {
		$this->product_bookable = $product_bookable;
	}

	/**
	 * @param field_type $hotel_rooms
	 */
	public function setHotel_rooms($hotel_rooms) {
		$this->hotel_rooms = $hotel_rooms;
	}
	/**
	 * @return the $multimedia
	 */
	public function getMultimedia() {
		return $this->multimedia;
	}

	/**
	 * @param field_type $multimedia
	 */
	public function setMultimedia($multimedia) {
		$this->multimedia = $multimedia;
	}
	/**
	 * @return the $product_info
	 */
	public function getProduct_info() {
		return $this->product_info;
	}

	/**
	 * @param field_type $product_info
	 */
	public function setProduct_info($product_info) {
		$this->product_info = $product_info;
	}
	/**
	 * @return the $attributes
	 */
	public function getAttributes() {
		return $this->attributes;
	}

	/**
	 * @param field_type $attributes
	 */
	public function setAttributes($attributes) {
		$this->attributes = $attributes;
	}



public function toArray()
{
	return (array) $this;
}


}