# Easy Post plugin for Craft CMS

⚠️ This is an alpha, expect bugs. It is being shared to assist community developers.

Easy Post shipping plugin.

Currently provides shipping options and quotes from your easypost.com account.

## Setup

1) Copy `config.php` from the `easypost` plugin folder to your `craft/config` folder and rename it to 
`easypost.php`
2) Replace the carrier IDs within the cofig with the carrier IDs that you wish to use from your easypost account.
3) Remove service levels you do not wish to offer your customers.
4) Install the plugin from the Craft control panel
4) Add your test AND production keys to the easypost settings screen.

> The we require the product keys to get information about your carrier accounts. Otherwise only the test key will be used when in devMode.

5) Visit the `commerce > settings > shipping methods` screen and confirm that
the easy post shipping merthods are showing up.

Easy Post works on Craft 2.5.x. and Craft Commerce 1.1.X

TODO

* Get a correct bin packing algorithm and supply correct sizes to easypost.
* Purchase shipping labels
* Shipping Tracking
* Returns.

## Easy Post Changelog

### 0.1 -- 2016.05.22

* Initial release

Brought to you by [Pixel & Tonic](http://craftcommerce.com)