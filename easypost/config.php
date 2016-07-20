<?php

return [
	//	Possible rates types available at https://www.easypost.com/docs/api#rates
	// list_rate. rate, retail_rate etc
	'useRate'         => 'rate',

	// The address you will be posting from.
	'fromAddress'     => ["name"    => "Jon Calhoun",
	                      "street1" => "388 Townsend St",
	                      "street2" => "Apt 20",
	                      "city"    => "San Francisco",
	                      "state"   => "CA",
	                      "zip"     => "94107",
	                      "phone"   => "323-855-0394"],

	// You can find the service levels here: https://www.easypost.com/docs/api#service-levels
	// The easypost carrier accounts and their service levels you want to make available
	'carrierAccounts' => [
		'ca_04ef65ec88434fcca8c8afb1c1b68d5e' => [ //USPS
			'services' => [
				"First"                                 => "First-Class Mail",
				"Priority"                              => "Priority Mail",
				"Express"                               => "Priority Mail Express",
				"ParcelSelect"                          => "USPS Parcel Select",
				"LibraryMail"                           => "Library Mail Parcel",
				"MediaMail"                             => "Media Mail Parcel",
				"CriticalMail"                          => "USPS Critical Mail",
				"FirstClassMailInternational"           => "First Class Mail International",
				"FirstClassPackageInternationalService" => "First Class Package Service International",
				"PriorityMailInternational"             => "Priority Mail International",
				"ExpressMailInternational"              => "Express Mail International"
			]
		],
		'ca_0dff155ec7d84c0e8bba213cf7b69aa5' => [ //Fedex
			'services' => [
				"FIRST_OVERNIGHT"        => "First Overnight",
				"PRIORITY_OVERNIGHT"     => "Priority Overnight",
				"STANDARD_OVERNIGHT"     => "Standard Overnight",
				"FEDEX_2_DAY_AM"         => "FedEx 2 Day AM",
				"FEDEX_2_DAY"            => "FedEx 2 Day",
				"FEDEX_EXPRESS_SAVER"    => "FedEx Express Saver",
				"FEDEX_GROUND"           => "FedEx Ground",
				"INTERNATIONAL_PRIORITY" => "FedEx International Priority",
				"INTERNATIONAL_ECONOMY"  => "FedEx International Economy"
			]
		],
		'ca_3e8a353b7b6c49089125804d6ae51319' => [ //UPS
			'services' => [
				"Ground"            => "Ground (UPS)",
				"3DaySelect"        => "3 Day Select (UPS)",
				"2ndDayAirAM"       => "2nd Day Air AM (UPS)",
				"2ndDayAir"         => "2nd Day Air (UPS)",
				"NextDayAirSaver"   => "Next Day Air Saver (UPS)",
				"NextDayAirEarlyAM" => "Next Day Air Early AM (UPS)",
				"NextDayAir"        => "Next Day Air (UPS)",
				"Express"           => "Express (UPS)",
				"Expedited"         => "Expedited (UPS)",
				"ExpressPlus"       => "Express Plus (UPS)",
				"UPSSaver"          => "UPS Saver (UPS)",
				"UPSStandard"       => "UPS Standard (UPS)"
			]
		]
	],
	// This setting can change the price of any rate returned from easypost
	// The shipping method handle is the combination of carrier account id and service level id
	// e.g  ca_3e8a353b7b6c49089125804d6ae51319ExpressPlus
	'modifyPrice'     => function ($shippingMethodHandle, $order, $price)
	{

		// Example of modifying the price based on order totalPrice
		/*
		if($order->totalPrice >= 100)
		{
			return $price + 10;
		}
		return $price + 5;
		*/

		return $price;
	}
];