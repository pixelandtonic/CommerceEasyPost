<?php

namespace Craft;

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
class EasyPost_CarriersService extends BaseApplicationComponent
{
	private $_allCarrierAccounts;

	public function getAllCarrierAccounts()
	{
		if (!isset($this->_allCarrierAccounts))
		{
			$this->_allCarrierAccounts = CarrierAccount::all();
		}

		return $this->_allCarrierAccounts;
	}

}