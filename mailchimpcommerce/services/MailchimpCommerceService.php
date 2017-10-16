<?php
/**
 * MailChimp - Commerce plugin for Craft CMS
 *
 * @author    	Jason Mayo
 * @twitter 		@madebymayo
 * @package   	MailchimpCommerce
 */

namespace Craft;

use \DrewM\MailChimp\MailChimp;

class MailchimpCommerceService extends BaseApplicationComponent
{

	public function getAllSettings()
	{
		return craft()->plugins->getPlugin('MailchimpCommerce')->getSettings();
	}
	
	public function getSetting($name)
	{
		return craft()->plugins->getPlugin('MailchimpCommerce')->getSettings()->$name;
	}

    public function subscribe($order)
    {

		$mailChimp = new MailChimp($this->getSetting('apiKey'));
		
		$address = craft()->commerce_addresses->getAddressById($order->shippingAddressId);
		
		// $mailChimpSubscriber = $mailChimp->subscriberHash($order->email);
			
		$result = $mailChimp->post(
			"lists/" . $this->getSetting('listId') . "/members", 
			[
				'status' => 'subscribed',
				'email_address' => $order->email,
				'merge_fields' => [
					$this->getSetting('mergeFieldFirstName') => $address->firstName, 
					$this->getSetting('mergeFieldLastName') => $address->lastName
				]
			]
		);

		if ($mailChimp->success()) {
			MailchimpCommercePlugin::log('Success');
		} else {
			MailchimpCommercePlugin::log('Error - ' . $mailChimp->getLastError());
		}
	    
    }

}