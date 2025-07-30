=== WPMasivo Fixed Mobile Bar ===
Contributors: raulsoriano
Tags: mobile, navigation, fixed bar, fontawesome, responsive
Requires at least: 5.9
Tested up to: 6.8
Stable tag: 1.1
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Fixed bottom navigation bar for mobile/tablet with configurable buttons and FontAwesome icon picker.

== Description ==

WPMasivo Fixed Mobile Bar adds a fixed bottom navigation bar on mobile and tablet devices with fully configurable buttons from the admin panel. You can choose the number of buttons, background color, FontAwesome icons, text, and link for each button. Ideal for improving mobile navigation on your website.

== Installation ==

1. Upload the `wpmasivo-mobile-bar` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the fixed bar in the “WPMasivo” > “Fixed Mobile Bar” menu.

== Frequently Asked Questions ==

= Can I use any FontAwesome icon? =

Yes, just make sure to use the correct icon class name without the `fa-` prefix (for example: `home`, `phone`, `search`).

= Does it work on desktop? =

No, it is designed only for mobile and tablet devices.

= Can I change the icon color? =

Yes, you can choose the icon color from the settings.

= What versions of WordPress does it support? =

It supports WordPress 5.0 and above.

= Is the plugin translation-ready? =

Yes, it includes a text domain and supports translations via the /languages folder.

== Screenshots ==

1. Admin panel to configure buttons and colors.
2. Preview of the fixed bar on mobile.

== Upgrade Notice ==

= 1.1 =
Added visual FontAwesome icon picker and improved preview functionality.

= 1.0 =
Initial release with fixed bar and basic settings.

== Technical Details ==

* Hooks:
  - `wp_enqueue_scripts` to load frontend styles/scripts.
  - `admin_menu` to add settings page.
* Filters:
  - None currently.

== Contributors ==

Raúl Soriano - https://seomasivo.com

== License ==

GPLv2 or later - https://www.gnu.org/licenses/gpl-2.0.html
