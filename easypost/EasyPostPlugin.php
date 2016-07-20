<?php

namespace Craft;

use CommerceEasyPost\ShippingMethod;
use EasyPost\EasyPost;

require __DIR__.'/vendor/autoload.php';

class EasyPostPlugin extends BasePlugin
{

	/**
	 * @return mixed
	 */
	public function init()
	{

		if (craft()->config->get('devMode'))
		{
			if (isset($this->settings['testApiKey']) && $this->settings['testApiKey'])
			{
				EasyPost::setApiKey($this->settings['testApiKey']);
			}
		}
		else
		{
			if (isset($this->settings['apiKey']) && $this->settings['apiKey'])
			{
				EasyPost::setApiKey($this->settings['apiKey']);
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return Craft::t('Easy Post');
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return Craft::t('Easy Post shipping plugin');
	}

	/**
	 * @return string
	 */
	public function getDocumentationUrl()
	{
		return 'https://github.com/pixelandtonic/CommerceEasyPost/blob/master/README.md';
	}

	/**
	 * @return string
	 */
	public function getReleaseFeedUrl()
	{
		return 'https://raw.githubusercontent.com/pixelandtonic/CommerceEasyPost/master/releases.json';
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return '0.3';
	}

	/**
	 * @return string
	 */
	public function getSchemaVersion()
	{
		return '0.1';
	}

	/**
	 * @return string
	 */
	public function getDeveloper()
	{
		return 'Pixel & Tonic';
	}

	/**
	 * @return string
	 */
	public function getDeveloperUrl()
	{
		return 'http://craftcommerce.com';
	}

	/**
	 * @return bool
	 */
	public function hasCpSection()
	{
		return false;
	}

	/**
	 * @return mixed
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render('easypost/EasyPost_Settings', [
			'settings' => $this->getSettings()
		]);
	}

	/**
	 * @param mixed $settings The Widget's settings
	 *
	 * @return mixed
	 */
	public function prepSettings($settings)
	{
		craft()->cache->delete('easypost-allCarrierAccounts');

		return $settings;
	}

	/**
	 * Returns the shipping methods available for the current order, or just list the base shipping accounts.
	 *
	 * @param Commerce_OrderModel|null $order
	 *
	 * @return array
	 */
	public function commerce_registerShippingMethods($order = null)
	{
		if (isset($this->settings['apiKey']) && $this->settings['testApiKey'])
		{
			// Don't bother returning all shipping methods when we are in the context of an order, only those that match.
			if ($order)
			{
				$carrierAccountsConfig = craft()->config->get('carrierAccounts', 'easypost');

				$rates = craft()->easyPost_rates->getRates($order);
				$shippingMethods = [];

				if (craft()->config->get('devMode'))
				{
					$this::log('Rates for Order #'.$order->id." (Order Number: ".$order->number);
				}

				foreach ($rates as $rate)
				{
					if (craft()->config->get('devMode'))
					{
						$this::log('Rate: '.$rate);
					}

					$services = $carrierAccountsConfig[$rate->carrier_account_id]['services'];
					$carrier = craft()->easyPost_carriers->getCarrierAccountById($rate->carrier_account_id);

					if ($carrier && isset($services[$rate->service]))
					{
						$shippingMethods[] = new ShippingMethod($carrier, ['handle' => $rate->service, 'name' => $services[$rate->service]], $rate, $order);
					}
				}

				return $shippingMethods;
			}

			// return the display shipping methods. These never match the order
			// and are only used for display purposes in the CP.
			return craft()->easyPost_shippingMethods->getAllShippingMethods();
		}
	}

	/**
	 * @return array
	 */
	protected function defineSettings()
	{
		return [
			'apiKey'     => [AttributeType::String, 'label' => 'Easy Post API Key', 'default' => '', 'required' => true],
			'testApiKey' => [AttributeType::String, 'label' => 'Test Easy Post API Key', 'default' => '', 'required' => true],
			'markup'     => [AttributeType::Number, 'label' => 'Mark-up Percentage', 'default' => '5']
		];
	}

}