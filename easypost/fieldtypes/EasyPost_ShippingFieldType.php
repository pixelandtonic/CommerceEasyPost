<?php
namespace Craft;

/**
 * Class EasyPost_ShippingFieldType
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2015, Pixel & Tonic, Inc.
 * @license   https://craftcommerce.com/license Craft Commerce License Agreement
 * @see       https://craftcommerce.com
 * @package   craft.plugins.easypost.fieldtypes
 * @since     1.0
 */
class EasyPost_ShippingFieldType extends BaseFieldType
{
	// Properties
	// =========================================================================

	/**
	 * @inheritDoc IComponentType::getName()
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Easy Post Shipping');
	}

	/**
	 * @inheritDoc IFieldType::getInputHtml()
	 *
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return string
	 */
	public function getInputHtml($name, $value)
	{
		craft()->templates->includeJsResource('easypost/easypost/.js');
		return craft()->templates->render('easypost/_field', array(
			'name'    => $name,
			'order' => $this->element
		));
	}
}
