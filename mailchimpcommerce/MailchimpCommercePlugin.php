<?php
/**
 * MailChimp - Commerce plugin for Craft CMS
 *
 * @author    	Jason Mayo
 * @twitter 		@madebymayo
 * @package   	MailchimpCommerce
 */

namespace Craft;

class MailchimpCommercePlugin extends BasePlugin
{

    public function init()
    {

		require_once __DIR__ . '/vendor/autoload.php';
	    
		craft()->on(
			'commerce_orders.onSaveOrder', 
			function($event){
				
		    	$order = $event->params['order'];
		    	
		    	if (craft()->request->getPost('mailchimpCommerce_optIn') == true && $order->email)
		    	{
			    	craft()->mailchimpCommerce->orderSaved($order);
		    	}
		    	
			}
		);
		
		craft()->on(
			'commerce_orders.onOrderComplete', 
			function($event){
				
		    	$order = $event->params['order'];
		    	
		    	if ($order->email)
		    	{
			    	craft()->mailchimpCommerce->orderComplete($order);
		    	}
		    	
			}
		);
	    
        parent::init();

    }

    public function getName()
    {
         return Craft::t('MailChimp - Commerce');
    }

    public function getDescription()
    {
        return Craft::t('Subscribes commerce customers to MailChimp list');
    }

    public function getDocumentationUrl()
    {
        return 'https://github.com/bymayo/mailchimpcommerce/blob/master/README.md';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/bymayo/mailchimpcommerce/master/releases.json';
    }

    public function getVersion()
    {
        return '1.0.2';
    }

    public function getSchemaVersion()
    {
        return '1.0.2';
    }

    public function getDeveloper()
    {
        return 'Jason Mayo';
    }

    public function getDeveloperUrl()
    {
        return 'http://bymayo.co.uk';
    }

    public function hasCpSection()
    {
        return false;
    }

    protected function defineSettings()
    {
        return array(
            'apiKey' => array(AttributeType::String, 'required' => true),
            'listIdStarted' => array(AttributeType::String, 'required' => true),
            'listIdComplete' => array(AttributeType::String, 'required' => true),
            'mergeFieldFirstName' => array(AttributeType::String, 'default' => 'FNAME'),
            'mergeFieldLastName' => array(AttributeType::String, 'default' => 'LNAME')
        );
    }

    public function getSettingsHtml()
    {
		return craft()->templates->render(
			'mailchimpcommerce/settings', 
			array(
				'settings' => $this->getSettings()
			)
		);
    }

    public function prepSettings($settings)
    {
        return $settings;
    }

}