<?php

namespace Craft;

use EasyPost\CarrierAccount;
use EasyPost\EasyPost;

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
			$allCarrierAccounts = craft()->cache->get('easypost-allCarrierAccounts');

			if (!$allCarrierAccounts)
			{
				// Since this API call requires a production API key, lets use it temporarily.
				$originalAPiKey = EasyPost::getApiKey();
				$apiKey = craft()->plugins->getPlugin('easyPost')->getSettings()->apiKey;
				if ($apiKey)
				{
					EasyPost::setApiKey($apiKey);
				}
				$this->_allCarrierAccounts = CarrierAccount::all();
				craft()->cache->set('easypost-allCarrierAccounts', $this->_allCarrierAccounts);

				EasyPost::setApiKey($originalAPiKey);
			}
			else
			{
				$this->_allCarrierAccounts = $allCarrierAccounts;
			}
		}

		return $this->_allCarrierAccounts;
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getCarrierAccountById($id)
	{
		$accounts = $this->getAllCarrierAccounts();

		foreach ($accounts as $account)
		{
			if ($account->id = $id)
			{
				return $account;
			}
		}
	}
}