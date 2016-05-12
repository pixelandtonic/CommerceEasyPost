<?php

namespace CommerceEasyPost;

use Commerce\Interfaces\ShippingRule as CommerceShippingRule;

class ShippingRule implements CommerceShippingRule
{

	private $_handle;
	private $_description;
	private $_price;

	public function __construct($handle)
	{
		$this->_handle = $handle;
	}

	/**
	 * Returns the unique handle of this Shipping Rule
	 *
	 * @return string
	 */
	public function getHandle()
	{
		return $this->_handle;
	}

	/**
	 * Is this rule a match on the order? If false is returned, the shipping engine tries the next rule.
	 *
	 * @return bool
	 */
	public function matchOrder(\Craft\Commerce_OrderModel $order)
	{
		$rates = craft()->easyPost_rates->getRates($order, $this->_handle);


	}

	/**
	 * Is this shipping rule enabled for listing and selection
	 *
	 * @return bool
	 */
	public function getIsEnabled()
	{
		return true;
	}

	/**
	 * Stores this data as json on the orders shipping adjustment.
	 *
	 * @return mixed
	 */
	public function getOptions()
	{
		return [];
	}

	/**
	 * Returns the percentage rate that is multiplied per line item subtotal.
	 * Zero will not make any changes.
	 *
	 * @return float
	 */
	public function getPercentageRate()
	{
		return 0.00;
	}

	/**
	 * Returns the flat rate that is multiplied per qty.
	 * Zero will not make any changes.
	 *
	 * @return float
	 */
	public function getPerItemRate()
	{
		return 0.00;
	}

	/**
	 * Returns the rate that is multiplied by the line item's weight.
	 * Zero will not make any changes.
	 *
	 * @return float
	 */
	public function getWeightRate()
	{
		return 0.00;
	}

	/**
	 * Returns a base shipping cost. This is added at the order level.
	 * Zero will not make any changes.
	 *
	 * @return float
	 */
	public function getBaseRate()
	{
		return $this->_price;
	}

	/**
	 * Returns a max cost this rule should ever apply.
	 * If the total of your rates as applied to the order are greater than this, the baseShippingCost
	 * on the order is modified to meet this max rate.
	 *
	 * @return float
	 */
	public function getMaxRate()
	{
		return 0.00;
	}

	/**
	 * Returns a min cost this rule should have applied.
	 * If the total of your rates as applied to the order are less than this, the baseShippingCost
	 * on the order is modified to meet this min rate.
	 * Zero will not make any changes.
	 *
	 * @return float
	 */
	public function getMinRate()
	{
		return 0.00;
	}

	/**
	 * Returns a description of the rates applied by this rule;
	 * Zero will not make any changes.
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return $this->_description;
	}
}