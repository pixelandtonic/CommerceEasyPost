<?php

namespace Craft;

use EasyPost\Address;
use EasyPost\Parcel;
use EasyPost\Shipment;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;

/**
 * Easy Post Rates
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2015, Pixel & Tonic, Inc.
 * @license   https://craftcommerce.com/license Craft Commerce License Agreement
 * @see       https://craftcommerce.com
 * @package   craft.plugins.easypost.services
 * @since     0.1
 */
class EasyPost_RatesService extends BaseApplicationComponent
{

	private $_shipmentsBySignature;

	public function init()
	{
		$this->_shipmentsBySignature = [];
	}

	public function getRates(Commerce_OrderModel $order)
	{
		$shipment = $this->_getShipment($order);

		$rates = [];

		if ($shipment)
		{
			$shipment->rates;

			foreach ($shipment->rates as $rate)
			{
				$rates[$rate['carrier']] = $rate;
			}
		}

		return $rates;
	}

	private function _getShipment(Commerce_OrderModel $order)
	{
		$signature = $this->_getSignature($order);

		// Do we already have it on this request?
		if (isset($this->_shipmentsBySignature[$signature]) && $this->_shipmentsBySignature[$signature] != false)
		{
			return $this->_shipmentsBySignature[$signature];
		}

		$cacheKey = 'easypost-shipment-'.$signature;
		// Is it in the cache, if not, get it from the api?
		$shipment = craft()->cache->get($cacheKey);

		if (!$shipment)
		{
			$shipment = $this->_createShipment($order);
			$this->_shipmentsBySignature[$signature] = craft()->cache->set($cacheKey, $shipment);
		}

		$this->_shipmentsBySignature[$signature] = $shipment;

		return $this->_shipmentsBySignature[$signature];
	}

	private function _createShipment($order)
	{
		/** @var Commerce_AddressModel $shippingAddress */
		$shippingAddress = $order->shippingAddress;

		if (!$shippingAddress)
		{
			return false;
		}

		$to_address_params = ["name"           => $shippingAddress->getFullName(),
		                      "street1"        => $shippingAddress->address1,
		                      "street2"        => $shippingAddress->address2,
		                      "city"           => $shippingAddress->city,
		                      "state"          => $shippingAddress->getState() ? $shippingAddress->getState()->abbreviation : $shippingAddress->getStateText(),
		                      "zip"            => $shippingAddress->zipCode,
		                      "country"        => $shippingAddress->getCountry()->iso,
		                      "phone"          => $shippingAddress->phone,
		                      "company"        => $shippingAddress->businessName,
		                      "residential"    => $shippingAddress->businessName ? true : false,
		                      "email"          => $order->email,
		                      "federal_tax_id" => $shippingAddress->businessTaxId
		];

		$to_address = Address::create($to_address_params);

		$from_address_params = craft()->config->get('fromAddress', 'easypost');

		$from_address = Address::create($from_address_params);

		$settings = craft()->plugins->getPlugin('commerce')->getSettings();

		$length = new Length($order->getTotalLength(), $settings->dimensionUnits);
		$width = new Length($order->getTotalWidth(), $settings->dimensionUnits);
		$height = new Length($order->getTotalHeight(), $settings->dimensionUnits);
		$weight = new Mass($order->getTotalWeight(), $settings->weightUnits);

		$parcel_params = ["length"             => $length->toUnit('inch'),
		                  "width"              => $width->toUnit('inch'),
		                  "height"             => $height->toUnit('inch'),
		                  "predefined_package" => null,
		                  "weight"             => $weight->toUnit('ounce')
		];

		if ($parcel_params['weight'] == 0 || $parcel_params['length'] == 0 || $parcel_params['height'] == 0 || $parcel_params['width'] == 0)
		{
			return false;
		}

		$parcel = Parcel::create($parcel_params);


		$shipment_params = ["from_address" => $from_address,
		                    "to_address"   => $to_address,
		                    "parcel"       => $parcel
		];

		return Shipment::create($shipment_params);
	}

	private function _getSignature(Commerce_OrderModel $order)
	{
		$totalQty = $order->getTotalQty();
		$totalWeight = $order->getTotalWeight();
		$totalWidth = $order->getTotalWidth();
		$totalHeight = $order->getTotalHeight();
		$totalLength = $order->getTotalLength();
		$shippingAddress = Commerce_AddressRecord::model()->findById($order->shippingAddressId);
		$updated = "";
		if ($shippingAddress)
		{
			$updated = DateTimeHelper::toIso8601($shippingAddress->dateUpdated);
		}

		return md5($totalQty.$totalWeight.$totalWidth.$totalHeight.$totalLength.$updated);
	}
}