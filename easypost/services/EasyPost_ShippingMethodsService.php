<?php

namespace Craft;

use CommerceEasyPost\ShippingMethod;
use EasyPost\CarrierAccount;

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
			$carrierAccounts = CarrierAccount::all();
			$shippingMethods = [];
			foreach ($carrierAccounts as $carrier)
			{
				$shippingMethods[] = new ShippingMethod($carrier->type, $carrier->description);
			}

			$this->_allShippingMethods = $shippingMethods;
		}

		return $this->_allShippingMethods;
	}

}