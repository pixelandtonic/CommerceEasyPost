<?php

namespace Craft;

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

			$carrierAccountsConfig = craft()->config->get('carrierAccounts', 'easypost');

			$carrierAccountIds = array_keys($carrierAccountsConfig);

			$shippingMethods = [];
			foreach ($carrierAccounts as $carrier)
			{
				if (in_array($carrier->id, $carrierAccountIds))
				{
					$services = isset($carrierAccountsConfig[$carrier->id]['services']) ? $carrierAccountsConfig[$carrier->id]['services'] : [];
					foreach ($services as $handle => $name)
					{
						$shippingMethods[] = new ShippingMethod($carrier, ['handle' => $handle, 'name' => $name]);
					}
				}
			}

			$this->_allShippingMethods = $shippingMethods;
		}

		return $this->_allShippingMethods;
	}


}