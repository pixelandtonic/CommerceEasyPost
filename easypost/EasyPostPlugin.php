<?php
/**
 * Easy Post plugin for Craft CMS
 *
 * Easy Post shipping plugin
 *
 * @author    Pixel &amp; Tonic
 * @copyright Copyright (c) 2016 Pixel &amp; Tonic
 * @link      http://craftcommerce.com
 * @package   EasyPost
 * @since     0.1
 */

namespace Craft;

class EasyPostPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
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
        return 'Pixel &amp; Tonic';
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
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'someSetting' => array(AttributeType::String, 'label' => 'Some Setting', 'default' => ''),
        );
    }

    /**
     * @return mixed
     */
    public function getSettingsHtml()
    {
       return craft()->templates->render('easypost/EasyPost_Settings', array(
           'settings' => $this->getSettings()
       ));
    }

    /**
     * @param mixed $settings  The Widget's settings
     *
     * @return mixed
     */
    public function prepSettings($settings)
    {
        // Modify $settings here...

        return $settings;
    }

}