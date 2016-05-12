<?php

namespace Craft;

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

	private $_shipmentsBySiganture;

	public function init()
	{
		$this->_shipmentsBySignature = [];
	}

	public function getRates($order)
	{
		$shipment = $this->_getShipment($order);
	}

	private function _getShipment()
	{
		$signature = _getSignature($order);

		if(isset($this->_shipmentsBySignature[$signature]))
		{
			return $this->_shipmentsBySignature[$signature];
		}

		$shipments = $this->_createShipments($order);
	}

	private function _createShipment($order)
	{
		if (!$order->shippingAddress)
		{
			return;
		}

		$to_address_params = ["name"    => "Sawyer Bateman",
		                      "street1" => "388 Townsend St",
		                      "street2" => "Apt 30",
		                      "city"    => "San Francisco",
		                      "state"   => "CA",
		                      "zip"     => "94107"];
		$to_address = Address::create($to_address_params);

		$from_address_params = ["name"    => "Jon Calhoun",
		                        "street1" => "388 Townsend St",
		                        "street2" => "Apt 20",
		                        "city"    => "San Francisco",
		                        "state"   => "CA",
		                        "zip"     => "94107",
		                        "phone"   => "323-855-0394"];
		$from_address = Address::create($from_address_params);


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

		$shipment = Shipment::create($shipment_params);
	}

	private function _getSignature($order)
	{

	}
}