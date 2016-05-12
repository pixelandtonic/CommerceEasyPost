<?php
namespace CommerceEasyPost;

use Commerce\Interfaces\ShippingMethod as CommerceShippingMethod;
use Craft\Commerce_OrderModel;

class ShippingMethod implements CommerceShippingMethod
{
	private $_handle;
	private $_description;
	private $_price;

	public function __construct($handle, $description)
	{
		$this->_handle = $handle;
		$this->_description = $description;
		$this->_price = 20.00;
	}

	/**
	 * Returns the type of Shipping Method.
	 * The core shipping methods have type: `Custom`. This is shown in the control panel only.
	 *
	 * @return string
	 */
	public function getType()
	{
		return "Easy Post";
	}

	/**
	 * Returns the ID of this Shipping Method, if it is managed by Craft Commerce.
	 *
	 * @return int|null The shipping method ID, or null if it is not managed by Craft Commerce
	 */
	public function getId()
	{
		return null;
	}

	/**
	 * Returns the unique handle of this Shipping Method.
	 *
	 * @return string
	 */
	public function getHandle()
	{
		return $this->_handle;
	}

	/**
	 * Returns the control panel URL to manage this method and it's rules.
	 * An empty string will result in no link.
	 *
	 * @return string
	 */
	public function getCpEditUrl()
	{
		return "";
	}

	/**
	 * Returns an array of rules that meet the `ShippingRules` interface.
	 *
	 * @return \Commerce\Interfaces\ShippingRules[] The array of ShippingRules
	 */
	public function getRules()
	{
		return [new ShippingRule($this->_handle)];
	}

	/**
	 * Returns the name of this Shipping Method as displayed to the customer and in the control panel.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->_description;
	}

	/**
	 * Is this shipping method enabled for listing and selection by customers.
	 *
	 * @return bool
	 */
	public function getIsEnabled()
	{
		return true;
	}
}