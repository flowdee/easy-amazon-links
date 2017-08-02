=== Easy Amazon Links ===
Contributors: flowdee
Donate link: https://donate.flowdee.de
Tags: amazon, affiliate, Amazon Associate, Amazon Associates, amazon link
Requires at least: 3.5.1
Tested up to: 4.8.0
Stable tag: 1.0.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Easily create text affiliate links for Amazon Associates

== Description ==
With Easy Amazon Links you can easily create text links including your affiliate tracking id and earn commissions as Amazon Associates partner.

= Features =

*   Creating text affiliate links for Amazon Associates
*   No Amazon API keys required
*   Two link types available: Search result (default) and product detail page (by ASIN)
*   Supporting all available countries/stores
*   Geotargeting functionality
*   TinyMCE button for quick link generation
*   Handy shortcode for customizations
*   Configuration page for more options
*   Regular updates and improvements: Go though the [changelog](https://wordpress.org/plugins/easy-amazon-links/changelog/)

= Quickstart Examples =

* Setup tracking id(s)
* Select your default store
* Activate geotargeting in case you want to redirect visitors to their local stores (optional)
* Create affiliate links via TinyMCE editor button or shortcode: e.g. [eal]Amazon Echo Dot[/eal]

= Support =

* Browse [issue tracker](https://github.com/flowdee/easy-amazon-links/issues) on GitHub
* [Follow me on Twitter](https://twitter.com/flowdee) to stay in contact and informed about updates

= Credits =

This plugin is not official made or maintained by Amazon.

== Installation ==

The installation and configuration of the plugin is as simple as it can be.

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'easy amazon links'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select zip file from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download the plugin
2. Extract the directory to your computer
3. Upload the directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Frequently Asked Questions ==

= How do I create an affiliate link? =

Go to your post/page editor, mark a text and hit our TinyMCE button.

Alternatively you can use our shortcode: e.g. [eal]Amazon Echo Dot[/eal]

= What shortcodes are available? =

The default shortcode looks as follows:

[eal]Amazon Echo Dot[/eal]

Sometimes the link text must be different, which can be done as follows:

[eal search="amazon echo dot case"]Best Echo Dot Cases[/eal]

Additionally the link title can be updated as follows:

[eal title="View Ecto Dot Cases on Amazon"]Best Echo Dot Cases[/eal]

In case you want to link a certain product detail page, pass the ASIN over to the shortcode:

[eal asin="B01DFKC2SO"]Amazon Echo Dot[/eal] or [eal asin="B01DFKC2SO"]Get your Echo Dot here[/eal]

= How does geotargeting work exactly? =

In order to redirect your site visitors to their nearest Amazon store, the plugin needs to find out their country. This is done by passing their IP to the API of the following services: [ipinfo.io](https://ipinfo.io/) and [freegeoip.net](https://freegeoip.net/). Additionally the country will be stored for a few hours in a cookie.

Now all plugin generated affiliate links will be replaced by using the local tracking ids you entered on the plugin settings page before.

Geotargeting is an optional feature and must be expressly activated.

= Multisite supported? =

Yes of course.

== Screenshots ==

1. Settings page

== Changelog ==

= Version 1.0.1 (2nd August 2017) =
* Minor improvements

= Version 1.0.0 (1st August 2017) =
* Initial release

== Upgrade Notice ==

= Version 1.0.1 (2nd August 2017) =
* Minor improvements

= Version 1.0.0 (1st August 2017) =
* Initial release