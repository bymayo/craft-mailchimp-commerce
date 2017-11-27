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

    public function subscribe($order, $listId)
    {

		$mailChimp = new MailChimp($this->getSetting('apiKey'));
		
		$address = craft()->commerce_addresses->getAddressById($order->shippingAddressId);
			
		$result = $mailChimp->post(
			"lists/" . $listId . "/members", 
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
			MailchimpCommercePlugin::log('[Subscribe] Success');
		} else {
			MailchimpCommercePlugin::log('[Subscribe] Error - ' . $mailChimp->getLastError());
		}
	    
    }
    
    public function unsubscribe($order, $listId)
    {
	    
		$mailChimp = new MailChimp($this->getSetting('apiKey'));

		$subscriberHash = $mailChimp->subscriberHash($order->email);
		
		$mailChimp->delete(
			"lists/" . $listId . "/members/" . $subscriberHash
		);
			
		if ($mailChimp->success()) {
			MailchimpCommercePlugin::log('[Unsubscribe] Success');
		} else {
			MailchimpCommercePlugin::log('[Unsubscribe] Error - ' . $mailChimp->getLastError());
		}			
			
    }
    
    public function orderSaved($order)
    {
	    $this->subscribe($order, $this->getSetting('listIdStarted'));
    }
    
    public function orderComplete($order)
    {
	    $this->unsubscribe($order, $this->getSetting('listIdStarted'));
	    $this->subscribe($order, $this->getSetting('listIdComplete'));
    }

}