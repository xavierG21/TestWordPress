=== All-in-One Video Gallery ===
Plugin URI: https://plugins360.com/all-in-one-video-gallery/
Contributors: plugins360, wpvideogallery, freemius
Donate link: https://plugins360.com
Tags: video player, video gallery, youtube gallery, vimeo gallery, livestream
Requires at least: 4.7.0
Tested up to: 5.2
Requires PHP: 5.3.0
Stable tag: 1.6.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add responsive video galleries anywhere on your website – no coding required. Includes HTML5 Player, Thumbnail Grid, Slider, Popup & more

== Description ==

No coding required. A Responsive & Lightweight video gallery plugin. 

HTML5 Player, Categories, Visual Builder (Gutenberg), Search Form, Comments, Social Sharing and everything you will need to build a YouTube/Vimeo like a video sharing website. 

[Demo](https://demo.plugins360.com/all-in-one-video-gallery/) | [Documentation](https://plugins360.com/all-in-one-video-gallery/documentation/) | [Support](https://plugins360.com/support/) | [Premium Version](https://plugins360.com/all-in-one-video-gallery/pricing/)

https://www.youtube.com/watch?v=w47PU9ppuF8

**Key Features**

* Modern, Responsive design.
* Unlimited Categories.
* Unlimited Videos.
* Thumbnail Gallery (you can select how many rows, columns to display and pagination).
* HTML5 Player with FLASH fallback.
* Plays anywhere: supports MP4, WebM, OGV and embeddable players like YouTube, Vimeo, Dailymotion & Facebook.
* Player controls: play pause, timer, progress bar, duration, volume, fullscreen
* Playback options: autoplay, loop, muted, preload
* Subtitles.
* Comments.
* Social Sharing (Facebook, Twitter, Linkedin, Pinterest & WhatsApp).
* Form to search videos.
* Widgets to list categories, list videos, display a single video player and to search videos.
* Show GDPR consent.
* Detailed user and developer documentation.

**Premium Features**

* Auto import videos from YouTube playlist, channel, etc.
* Custom Logo & Branding
* Custom Context Menu
* HLS / M(PEG)-Dash
* Live Streaming
* Popup Template
* Slider Template
* VAST / VPAID Ads
* Front-end User Submission

**Translations**

Currently, the plugin is available only in English. But, the plugin is translation ready and you can [translate](https://plugins360.com/all-in-one-video-gallery/translate/) to your language easy.

**Get Involved**

* Wording - I am not a native English speaker, if you find any typo, grammar mistake or etc. please [report](https://plugins360.com/support/) on our website.
* Translation - If you have translated the plugin to your language, feel free to [submit your translation](https://plugins360.com/support/).
* Rate Plugin - If you find this plugin useful, please leave a [positive review](https://wordpress.org/support/plugin/all-in-one-video-gallery/reviews/).
* Submit a Bug - If you find any issue, please [submit a bug](https://plugins360.com/support/) on our website.

== Installation ==

1. Download the plugin.
2. From the WordPress Admin Panel, click on Plugins => Add New.
3. Click on Upload, so you can directly upload your plugin zip file.
4. Use the browse button to select the plugin zip file that was downloaded, and then click on Install Now.
5. Once installed, click "Activate".

For more detailed instructions visit plugin [documentation](https://plugins360.com/all-in-one-video-gallery/documentation/)

== Frequently Asked Questions ==

= 1. I have installed the plugin. How to build my first Gallery? =
Thanks for installing our plugin. The plugin dashboard should have all the necessary instructions required to build a gallery. Simply follow that.

For more detailed instructions visit plugin [documentation](https://plugins360.com/all-in-one-video-gallery/documentation/)

Still Having Issues? We are just an email away. Please write to us describing your issue using the "Contact" form available under our plugin's menu. You should receive a reply within 24 hours (except Sunday).

= 2. Can I upload large video files using this plugin? =
Sure, the plugin doesn't apply any restriction on the uploaded file size. If you're not able to upload large files, then it must be your server configuration which is not suitable for large file uploads. Simply write to your HOST and ask them to increase the upload file size limit.

= 3. Can I show my videos in a Popup/Slider? =
Yes, you can. Kindly refer the instructions below,

1. [Popup](https://plugins360.com/all-in-one-video-gallery/popup/)
2. [Slider](https://plugins360.com/all-in-one-video-gallery/slider/)

= 4. Does the plugin support third-party page builders like "Elementor", "WPBakery", "Divi", etc.? =
Yes. Simply, generate your shortcode using the plugin's "Shortcode Builder" and add it in your favourite page builder.

= 5. The plugin is not working for me. What should I do now? =
Please describe your issue and submit a ticket on our plugin support forum, you should receive a reply within 24 hours (except Sunday).

== Screenshots ==

1. Categories Layout.
2. Video Gallery ("Classic" Template).
3. Single Video page.
4. Videos list back-end.
5. Video form back-end.
6. Category form back-end.
7. Plugin Settings.

== Changelog ==

= 1.6.5 =

* New: Plugin Dashboard.
* New: Shortcode Builder.
* New: A mechanism to auto-detect plugin misconfiguration issues with the fixes.
* New: "Muted" - A setting to turn OFF the audio output of the video by default.
* New: "include" - A new [aiovg_videos] shortcode attribute to show only the selective videos. Example: [aiovg_videos include="1,2,3"]
* New: "include" - A new [aiovg_categories] shortcode attribute to show only the selective categories. Example: [aiovg_categories include="1,2,3"]
* New: "WhatsApp" share button.
* Tweak: Simplified settings page UI.
* Tweak: Replaced transients with $_COOKIES to calculate unique video views. The reason $_COOKIES are used is to stop bloating up OPTIONS table with several hundreds of transients.
* Fix: Same videos repeat again when the videos ordering is to "random" and the pagination is enabled.
* Fix: [+] few minor bug fixes.

= 1.6.4 =

* Tweak: Updated Freemius SDK (2.3.0).
* Fix: Security fix.

= 1.6.3 =

* Fix: Unfortunately, there were some bugs in the 1.6.2 release and this is an immediate release which addresses those issues.

= 1.6.2 =

* New: Support for Yoast breadcrumbs.
* Tweak: Optimized WP_Query for fast output.
* Fix: [+] few minor bug fixes.

= 1.6.1 =

* New: Option to delete or NOT delete the associated media files when a video post or category is deleted.
* Tweak: Uses mediaelement.js library files from the WordPress core.
* Tweak: Displays spinner immediately after the play button is clicked.
* Fix: Issues with the Gutenberg player block settings.
* Fix: [+] few more minor bug fixes.

= 1.6.0 =

* Fix: Security fix.
* Fix: [+] few minor bug fixes.

= 1.5.9 =

* Fix: Fixes a SERIOUS BUG. Pages created infinitely in some WordPress Environments.
* Fix: Replaced "plugins_loaded" hook with "init" hook to initialize the Gutenberg blocks. 

= 1.5.8 =

* Tweak: "wp_loaded" hook used to insert missing plugin options was updated with a version number check.

= 1.5.7 =

* New: Freemius Integration.
* New: PHP 7+ compatibility.
* New: Introduces Template options for both categories and videos.
* Tweak: Code completely revised and rewritten to make the plugin more extensible.
* Tweak: Removed Twitter Bootstrap & Font Awesome libraries and replaced with custom CSS code to keep the plugin lightweight.
* Tweak: Custom Logo & Branding, Custom Context Menu options removed from the FREE version. But, these options will continue to work for our old users.
* Fix: [+] few minor bug fixes.

= 1.5.6 =

* New: Gutenberg blocks for the plugin.
* New: Support for Yoast SEO Plugin.
* Fix: [+] few minor bug fixes.

= 1.5.5 =

* Fix: Pagination issue in single video pages.

= 1.5.4 =

* Fix: Unfortunately, there were some bugs in the 1.5.3 release and this is an immediate release which addresses those issues.

= 1.5.3 =

* New: Custom Logo & Branding.
* Tweak: Removed jQuery dependency for the player.
* Fix: Shortcodes not working in the single video page.
* Fix: [+] few minor bug fixes.

= 1.5.2 =

* New: Compatible with GDPR.
* Tweak: Disabled the default context menu, and added a custom one.

= 1.5.1 =

* Tweak: README.txt update.

= 1.5.0 =

* New: Added support for Dailymotion videos.

= 1.4.0 =

* Tweak: Updated to the MediaElement version 4.2.8 that includes an important security fix.

= 1.3.0 =

* Tweak: "Select a Template" option removed from "WordPress Admin Panel => Video Gallery => Settings[Display] => Video Gallery Pages" settings.
* Fix: "Autoplay" disabled in mobile devices.
* Fix: YouTube playback issues in IOS.

= 1.2.0 =

* Fix: Unfortunately, there were some bugs in the 1.1.0 release and this is an immediate release which addresses those issues.

= 1.1.0 =

* New: Added support for Facebook videos.

= 1.0.0 =

* Initial release.

== Upgrade Notice ==

= 1.6.5 =

Introduces several bug fixes, new features & enhancements. [See changelog](https://wordpress.org/plugins/all-in-one-video-gallery/#developers)