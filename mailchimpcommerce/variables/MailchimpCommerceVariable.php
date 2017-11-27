<?php
/**
 * MailChimp - Commerce plugin for Craft CMS
 *
 * @author    	Jason Mayo
 * @twitter 		@madebymayo
 * @package   	MailchimpCommerce
 */

namespace Craft;

class MailchimpCommerceVariable
{
    
	public function getAllSettings()
    {
	    return craft()->mailchimpCommerce->getAllSettings();
    }
    
    public function fieldOptIn()
    {
	    return TemplateHelper::getRaw('<input type="checkbox" name="mailchimpCommerce_optIn" value="true" id="mailchimpCommerce_optIn" checked>');
    }
    
}