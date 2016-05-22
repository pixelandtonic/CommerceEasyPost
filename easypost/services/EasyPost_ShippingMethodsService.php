<?php

namespace Craft;

use CommerceEasyPost\ListingShippingMethod;
use CommerceEasyPost\ShippingMethod;

/**
 * Easy Post Carriers
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2015, Pixel & Tonic, Inc.
 * @license   https://craftcommerce.com/license Craft Commerce License Agreement
 * @see       https://craftcommerce.com
 * @package   craft.plugins.easypost.services
 * @since     0.1
 */
class EasyPost_ShippingMethodsService extends BaseApplicationComponent
{
	private $_allShippingMethods;

	public function getAllShippingMethods()
	{
		if (!isset($this->_allShippingMethods))
		{
			// Grab all easy post carrier accounts;

			$carrierAccounts = craft()->easyPost_carriers->getAllCarrierAccounts();
			$shippingMethods = [];
			foreach ($carrierAccounts as $carrier)
			{
				$shippingMethods[] = new ListingShippingMethod($carrier);
			}

			$this->_allShippingMethods = $shippingMethods;
		}

		return $this->_allShippingMethods;
	}

	public function getAllAvailableShippingMethods($order)
	{

		$rates = craft()->easyPost_rates->getRates($order);

		$shippingMethods = [];

		foreach ($rates as $rate)
		{
			$shippingMethods[] = new ShippingMethod($rate);
		}

		return $shippingMethods;
	}

}