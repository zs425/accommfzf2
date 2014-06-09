<?php
namespace Travel\Model;

class MenuItem
{
	public $menuitem_id;
	public $menuitem_menu_id;
	public $menuitem_parent_id;
	public $menuitem_type;
	public $menuitem_label;
	public $menuitem_title;
	public $menuitem_uri;
	public $menuitem_target;
	public $menuitem_visible;
	public $menuitem_weight;
	public $children = array();



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

	public function toArray()
	{
		return (array) $this;
	}

}
