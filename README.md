# MailChimp Commerce

MailChimp Commerce is a Craft CMS plugin that automatically subscribes customers to a single MailChimp list when they are going through the checkout process using Craft Commerce.

## Install

- Add the `mailchimpcommerce` directory into your `craft/plugins` directory.
- Navigate to Settings -> Plugins and click the "Install" button.
- Click the cog icon next to "MailChimp - Commerce" and complete the `API Key`, `List ID` and `Merge Field` fields.

## Templating

Within any `updateCart` form, add the following checkbox field (Or hidden, your choice!)

	<label for="mailchimpCommerce_optIn">
		Receive offers and updates by email?
	</label>
	<input type="checkbox" name="mailchimpCommerce_optIn" value="true" id="mailchimpCommerce_optIn">
	