<img src="https://github.com/bymayo/mailchimp-commerce/raw/master/screenshots/icon.png" width="50">

# MailChimp Commerce

MailChimp Commerce is a Craft CMS plugin that automatically subscribes customers to a MailChimp list when they are going through the checkout process using Craft Commerce.

It allows you to split the customers in to two lists allowing you to target your marketing a bit better:

- Order Started - When an order has started, but not fully completed (Cart abandoned, essentially)
- Order Complete - When an order has fully completed

## Install

- Add the `mailchimpcommerce` directory into your `craft/plugins` directory.
- Navigate to Settings -> Plugins and click the "Install" button.
- Click the cog icon next to `MailChimp - Commerce` and complete the `API Key`, `Order Started List ID` and `Order Complete List ID` fields.

## Templating

Within any `updateCart` form, add the following tag to output the `Opt In` checkbox

	{{ craft.mailchimpCommerce.fieldOptIn }}
	
Or, if you prefer to manually add it via HTML, use the following snippet:

	<label for="mailchimpCommerce_optIn">
		Receive offers and updates by email?
	</label>
	<input type="checkbox" name="mailchimpCommerce_optIn" value="true" id="mailchimpCommerce_optIn">
	