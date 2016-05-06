=== Custom CSS by PressBro ===
Contributors: pressbro
Donate link: https://pressbro.com/donate
Tags: custom, css, code
Requires at least: 4.0
Tested up to: 4.5
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to easily write custom CSS to edit the look and feel of your site. 

== Description ==

This plugin allows you to easily write custom CSS to edit the look and feel of your site.

Features:

- [Ace](https://ace.c9.io/) editor
- Updates code with ctrl/cmd+s
- Responsive design
- Beautiful UI and UX
- Minifies the output

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/pressbro-custom-css` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Navigate to Appearance->Custom CSS to start using the plugin.

== Frequently Asked Questions ==

= Why another Custom CSS plugin? =

Because most of them are filled with interrupting content and have bad design that interrupt usability, so I decided to make one that's modern, beautiful, easy to use and does exactly what it says.

== Screenshots ==

1. Plugin screenshot

== Changelog ==

= 1.1 =
* Made the hard choice with removing HTMLPurifier and CSSTidy since we only write to non-executing .css file and only the administrator has access to the plugin. If the site breaks, it's not because of the plugin (unless of course you write CSS that will break it, but then simply undo what you did)
* Added font size + and - buttons next to the Update button as requested in [this topic](https://wordpress.org/support/topic/plugin-broken-67) 

= 1.0.2 =
* Fixed editor height in mobile devices

= 1.0.1 =
* Fixed a bug related to file creation / updating

= 1.0 =
* Initial release

== Upgrade Notice ==

Always upgrade to the latest version of the plugin and if at all possible, enable automatic updates. This makes sure that your WordPress site will always be safe from attacts to the vulnerabilities that may be discovered in this plugin, or any other plugin for that matter.