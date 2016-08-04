=== White Label Login ===
Contributors: cameronjonesweb
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=WLV5HPHSPM2BG&lc=AU&item_name=cameronjonesweb-FacebookPagePlugin&cy_code=AUD&bn=PPDonationsBFbtn_donateCC_LGgifNonHosted
Requires at least: 4.6
Tested up to: 4.7
Stable tag: trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

White Label Login removes WordPress branding from the login page and replaces it with options from the Customizer

== Description ==
Have you ever found the need to style your WordPress login page? With White Label Login, it's never been easier. Simply install the plugin, and it will grab your custom styles from the Customizer and apply them to the login page. This removes the links to wordpress.org and the WordPress logo and replaces them with the correct information for your site. For any styles that need to be customised further, there are plenty of filters provided.

== Frequently Asked Questions ==
= Where Is The Settings Page? =
There isn't one. The styles for the login page are inherited from the options in the Customizer, such as the logo and the background colour. If there are any changes that you need to make to the login page, you can override it with one of the many filters provided.

== Changelog ==
= 1.0 =
* Initial release

== Screenshots ==
1. Example of the login page

== Filter Reference ==
`white_label_login_logo_max_width`
(integer) Maximum width of the logo compared to the container. Default: 75.

`white_label_login_logo_src`
(string) URL of the image to use for the logo. Default: `get_theme_mod( 'custom_logo' )`

`white_label_login_logo_width`
(int) Width in pixels of the logo. Default: the width of the image passed to `white_label_login_logo_src`

`white_label_login_logo_height`
(int) Height in pixels of the logo. Default: the height of the image passed to `white_label_login_logo_src`

`white_label_login_background_color`
(string) Hex value of the background colour (without the #). Default: `get_theme_mod( 'background_color' )`

`white_label_login_background_image`
(string) URL of the image to use for the page background. Default: `get_theme_mod( 'background_image' )`

`white_label_login_background_position_x`
(string) Valid CSS horizontal position property of the page background image. Default: `get_theme_mod( 'background_position_x' )`

`white_label_login_background_position_y`
(string) Valid CSS vertical position property of the page background image. Default: top

`white_label_login_background_repeat`
(string) Valid CSS background repeat property of the page background image. Default: `get_theme_mod( 'background_repeat' )`

`white_label_login_background_attachment`
(string) Valid CSS background attachment property of the page background image. Default: `get_theme_mod( 'background_attachment' )`

`white_label_login_button_background`
(string) Hex value of the background of the log in button (without the #). Passing false to this value will bypass the inherited values for the other button style properties, which can still be filtered if false. Default: `white_label_login_background_color`

`white_label_login_button_color`
(string) Hex value of the font colour of the log in button. Default: automatically determined by a contrast algorithm based on `white_label_login_button_background`

`white_label_login_button_border`
(string) Valid CSS property for the border of the log in button. Default: none

`white_label_login_button_text_shadow`
(string) Valid CSS property for the text shadow of the log in button. Default: none

`white_label_login_button_box_shadow`
(string) Valid CSS property for the box shadow of the log in button. Default: none

`white_label_login_button_background_hover`
(string) Hex value of the background colour of the log in button hover state. Default: 10% lighter than `white_label_login_button_background`

`white_label_login_button_color_hover`
(string) Hex value of the font colour of the log in button hover state. Default: automatically determined by a contrast algorithm based on the `white_label_login_button_background_hover`