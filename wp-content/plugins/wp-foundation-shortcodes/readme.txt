=== Plugin Name ===
Contributors: adam1920
Donate link:  https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GX2LMF9946LEE
Tags: WP Foundation Shortcodes, Wordpress Shortcodes, Wordpress zurb foundation, Wordpress foundation Shortcode, Zurb Foundation, Foundation Shortcodes, Foundation, responsive pages, editor plugin, TinyMCE, shortcodes
Requires at least: 4.0
Tested up to: 4.5.3
Stable tag: 0.8.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Foundation Shortcodes Plugin makes your ZURB Foundation website to the most powerful framework by styling your content with shortcodes

== Description ==

WP Foundation Shortcodes Plugin makes your ZURB Foundation website to the most powerful framework by styling your content with shortcodes.

[WP Foundation Shortcodes Demo](http://foundation.tadam.co.il/)


https://www.youtube.com/watch?v=ZFeSUiAvfsc&feature=youtu.be

= For best results use with Zurb Foundation 5 responsive theme =

You can use '{}' in every shortcode item, e.g. '[row {data-equalizer}]', to get '&lt;div class="row" data-equalizer&gt;'.

= Features: =
* Shortcodes are easy to use (first of all, make sure that the editing mode is set to Visual)
* No need to paste shortcode in editor
* Add button control to TinyMCE editor
* Select the shortcode you want to insert
* Popup with choices of parameters
* No additional JS or CSS files 

All available shortcodes are conditionally divided into these groups:

1. Posts: posts grid, posts list, posts lightbox, posts cycle
2. Buttons: button, button groups, radio button group, split buttons, dropdown, button option group
3. Elements: label, blockquotes, icon, address, inline list, keystroke, horisontal rule, clear 
4. Callouts & Prompts: alert box, panel, tooltip, banner, comments, service box, categories, tags 
5. Content: pricing table, progressbar, table, accordion, tabs, equalizer
6. Grid: grid, block grid
7. Widgets: google map, product card, product card with hover effects, social login buttons, pricing table recommended, pricing table animated
8. Media: orbit slider, silck slider, thumbnail, cliaring lightbox, video
9. Forms: switchers, range slider


The plugin contains a lot of shortcodes and widgets, we worked hard to make it easy for you.

== Installation ==

1.Upload:
Unzip wp-foundation-shortcode.zip file, and upload 'wp-foundation-shortcode' folder to your plugins folder: /wp-content/plugins/

2.Activate:
In the admin panel, click Plugins menu, active WP Foundation Shortcodes.

3.Use:
Now you can see the new button in the TinyMCE Editor, use these button to create great responsive pages/posts content. Pay attention, you need to use 'Visual' mode in TinyMCE Editor

1, 2, 3: You're done!

== Frequently Asked Questions ==

= Can I use this if my theme isn't built with Foundation 5? =

Some elements will work if the theme is built with Foundation 4, but other than that, no. See [how to upgrade Foundation 4](http://foundation.zurb.com/docs/upgrading.html).

== Screenshots ==

1. how it looks after installation
2. shortcode pop-up in the TinyMCE Editor
3. buttons example
4. labels example
5. range sliders example
6. alerts example
7. dropdowns example
8. pricing table example
9. progressbars example
10. table example
11. accordion example
12. tabs example
13. equalizer example

== Changelog ==

= 0.8.3 =
*Release Date - 03 July 2015*
* Added option to switch off loading Font awesome
* Added option 'free attributes' for all shrortcode items
* Font awesome CDN link updated to latest version

= 0.7 =
*Release Date - 24 September 2015*
*Bugs fixing

= 0.6 =
*Release Date - 24 September 2015*
* Allow shortcodes in widgets

= 0.5.1 =
* small design changes

= 0.5 =
*Release Date - 18 September 2015*
* Added 'Posts Lightbox' shortcode
* Added 'Tags' shortcode
* Added 'Categories' shortcode
* Added 'Comments' shortcode
* Added 'Banner' shortcode
* Added 'Service Box' shortcode
* Added options in dashboard plugin settings to enable/disable google map api and slick slider JS/CSS upload. It's necessary to avoid unnecessary scripts uploading
* Font-awesome styles changed to CDN
* Google map api script changed to CDN
* Slick slider script/styles changed to CDN
* Added 'Posts Cycle' shortcode

= 0.4 =
*Release Date - 10 September 2015*
* Added 'Posts Grid' shortcode
* Added 'Posts List' shortcode

= 0.3 =
*Release Date - 10 September 2015*
* PHP Class structure changed
* Added 'Slick Slider' shortcode
* Added 'Clearing Lightbox' shortcode
* Admin menu page added
* Added 'Button Groups' shortcode
* Added 'Split Buttons' shortcode
* Added 'Switch' shortcode
* Added 'Inline List' shortcode
* Added 'Link' shortcode
* Added 'Panel' shortcode
* Added 'Tooltip' shortcode
* Added 'Hr' shortcode
* 'Alert Box' shortcode improved, added types
* Added 'Product Card' widget
* Added 'Product Card with hover effects' widget
* 'Progress' shortcode improved, added colors
* Added SCSS files based on Compass
* 'Switch' shortcode improved: added On & Off label
* Added 'Radio Button Group' shortcode
* Added 'Option Button Group' shortcode
* Added 'Social Login Button' shortcode

= 0.2 =
*Release Date - 04 September 2015*
* Fixed bug in 'tabs' shortcode
* Fixed php notice messages
* Documentation improved
* Added '2 Columns Grid' shortcode
* Added '3 Columns Grid' shortcode
* Added '4 Columns Grid' shortcode
* Added 'Blocks grid' shortcode
* Added 'Google Map' shortcode
* Added 'Video' shortcode
* Added 'Orbit' shortcode
* Added 'Thumbnail' shortcode

= 0.1 =
*Release Date - 01 September 2015*
* first version

== Upgrade Notice ==

* no notice

== Arbitrary section ==

Requires a theme built with Foundation 5.

== A brief Markdown Example ==

1. [label color="secondary" corners="round"]Round Secondary Label[/label]
2. [button color="alert" size="large" icon="fa fa-exclamation-triangle"]Large Alert Button[/button]
3. [blockquote author="Cicero" class="my_custom_class"]At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio[/blockquote]
4. [icon icon="fa-warning" size="40px" color="red" class="my_custom_class"]Alert[/icon]
5. [range_slider direction="horizontal" corners="radius" class="my_custom_class" initial_value="10" start_value="0" end_value="100" step="0"]
6. [address title="Gaius Baltar" class="my_custom_class"]123 Colonial Ave.
Caprica City
Caprica, 12345
g.baltar@example.com[/address]
7. [alert_box color="alert" corners="radius" class="my_custom_class" icon="fa-exclamation-triangle" close="yes"]This is an alert with radius corners[/alert_box]
8. [dropdown button_text="Down" button_size="small" button_color="alert" dropdown_autoclose="yes" dropdown_open_on_hover="no"]This is a link
This is another
Yet another[/dropdown]
9. [pricing_table title="Standard" price="$99.99" description="An awesome description" item_name_1="1 Database" item_name_2="5GB Storage" item_name_3="20 Users" button_text="Buy Now" link="#" target="_blank" class="my_custom_class"]
10. [progressbar value="60" color="success" corners="round" class="my_custom_class"]
11. [table caption="Foundation table" colwidth="20|100|50" colalign="left|left|center|left|right"]
num|head1|head2|head3|head4
1|row1col1|row1col2|row1col3|100
2|row2col1|row2col2|row2col3|200
3|row3col1|row3col2|row3col3|300
4|row4col1|row4col2|row4col3|400
[/table]
12. [accordions] [accordion title="title1" active="yes"] tab content [/accordion] [accordion title="title2"] another content tab 
[/accordion] [/accordions]
13. [tabs direction="horizontal" class="my_custom_class"][tab title='Title #1'] Tab 1 content... [/tab] [tab title='Title #2'] Tab 2 content... [/tab] [tab title='Title #3'] Tab 3 content... [/tab][/tabs]
14. [equalizers] [equalizer title="Panel 1"] Panel 1 text ... [/equalizer] [equalizer title="Panel 2"] Panel 2 text ... [/equalizer] [equalizer title="Panel 3"] Panel 3 a lot of text text text text... [/equalizer] [/equalizers]

[To full documentation](http://foundation.tadam.co.il/).

