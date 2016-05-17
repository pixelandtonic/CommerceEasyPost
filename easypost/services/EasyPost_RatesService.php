<?php

namespace Craft;

use DVDoug\BoxPacker\Packer;
use DVDoug\BoxPacker\TestBox;
use EasyPost\Address;
use EasyPost\Parcel;
use EasyPost\Shipment;

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
			$rates = $shipment->rates;
		}

		return $rates;
	}

	private function _getShipment(Commerce_OrderModel $order)
	{
		$signature = $this->_getSignature($order);

		// Do we already have it on this request?
		if (isset($this->_shipmentsBySignature[$signature]))
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

		$from_address_params = ["name"    => "Jon Calhoun",
		                        "street1" => "388 Townsend St",
		                        "street2" => "Apt 20",
		                        "city"    => "San Francisco",
		                        "state"   => "CA",
		                        "zip"     => "94107",
		                        "phone"   => "323-855-0394"];
		$from_address = Address::create($from_address_params);


//		$packer = new Packer();
//		$packer->addBox(new TestBox());
//		$packer->addItem(new TestItem('Item 1', 250, 250, 2, 200));
//		$packer->addItem(new TestItem('Item 2', 250, 250, 2, 200));
//		$packer->addItem(new TestItem('Item 3', 250, 250, 2, 200));
//		$packedBoxes = $packer->pack();

		$parcel_params = ["length"             => 20.2,
		                  "width"              => 10.9,
		                  "height"             => 5,
		                  "predefined_package" => null,
		                  "weight"             => 14.8
		];
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
		$totalHeight = $order->getTotalHeight();
		$totalLength = $order->getTotalLength();
		$shippingAddress = Commerce_AddressRecord::model()->findById($order->shippingAddressId);
		$updated = "";
		if($shippingAddress)
		{
			$updated = DateTimeHelper::toIso8601($shippingAddress->dateUpdated);
		}

		return md5($totalQty.$totalWeight.$totalHeight.$totalLength.$updated);
	}
}