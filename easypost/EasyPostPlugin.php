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
		return 'https://github.com/pixelandtonic/easypost/blob/master/README.md';
	}

	/**
	 * @return string
	 */
	public function getReleaseFeedUrl()
	{
		return 'https://raw.githubusercontent.com/pixelandtonic/easypost/master/releases.json';
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return '0.1';
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
	 */
	public function onBeforeInstall()
	{
	}

	/**
	 */
	public function onAfterInstall()
	{
	}

	/**
	 */
	public function onBeforeUninstall()
	{
	}

	/**
	 */
	public function onAfterUninstall()
	{
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
		if (isset($this->settings['apiKey']) && $this->settings['apiKey'])
		{
			
			if ($order)
			{
				$rates = craft()->easyPost_rates->getRates($order);
				$shippingMethods = [];
				foreach ($rates as $rate)
				{
					$shippingMethods[] = new ShippingMethod($rate);
				}

				return $shippingMethods;
			}

			// return the display shipping methods. These never match the order
			// and are only used for display purposes.
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