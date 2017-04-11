=== UrVenue ===

Contributors: urvenue
Tags: urvenue, nightclub, bar, management, venue, calendar, event, events
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 1.0.1
License: GPLv2 or later

UrVenue is the leading Venue Management Software on the market in the nightclub industry today.

== Description ==

UrVenue is the leading Venue Management Software on the market in the nightclub industry today. For this, UrVenue presents uvwpintegrations. If you are a client with Wordpress page, now is available a plugin for you, where you can added integrations with you account the UrVenue. Customize with just a few clicks.

**Prerequisites**

In order to use the plugin you need the following:

* An account at [UrVenue](https://www.urvenue.com/) with a venue.
* A page in Wordpress.

== Installation ==

1. Upload 'UVWordpress.php' to the '/wp-content/plugins/' directory,
2. Activate the plugin through the 'Plugins' menu in WordPress.

**Settings plugin**

* Once installed the UrVenue plugin, it will appear in the Plugins screen. Click on Configure UrVenue Plugin.

* Open a window where you will add the veaid of your venue. The veaid shows in your account of UrVenue. Login and go to **Venue » Profile UV » Veaid**. 

* Copy the veaid and click on Save Changes.

* Once added the veaid, the database of your page of Wordpress will have the information of your venue and you will be able to use the urvenue shortcodes.

== Frequently Asked Questions ==

= How can I tell if it's working? =

Urvenue shortcode are available to show some integrations of urvenue in a simple and fast way. Only you need add the shortcode on a new page and done.

1. **[urvenue_calendar]** : A calendar with venue events. When you click on an event will open a page called event.

2. **[urvenue_event]** : You need to have a page called event so the calendar does not mark error and you add this urvenue shortcode.

3. **[urvenue_reservation]** : You can add a reservation_id to specify what type of reservation will be generated with this form. Example:

	* Bottle Service **[urvenue_reservation id="704283900"]**
	* Guest List **[urvenue_reservation id="704283898"]**

4. **More** : For more information to shortcodes and documentation, please check [Wiki UrVenue](http://wiki.urvenue.com/plugins).

= How to customize the new page? =

To get to the file it is necessary to follow the following steps:

* First, go to WordPress admin area and visit Plugins. In this page, show all the plugins installed. Find the uvwpintegrations plugin and click Edit.

* The Plugins Editor Screen allows you to edit those Plugin files.

* Click on uvwpintegrations/uvcustom.css file. You can see that the file is empty.

* In this file you can add all the css code you want. Once you have added the code click on Update File.

**Warning:** Making changes to active plugins is not recommended. Only change the uvcustom.css or your changes can cause a fatal error, the plugin will be automatically deactivated.

== Screenshots ==

1. Calendar Events
2. Calendar List Events
3. Guest List
4. Bottle Service
5. Packages
6. Photo Galleries
7. Event Slider
8. Carousel Events
9. Map 3D

== Changelog ==

= 1.0 =
* Initial release.

= 1.0.1 =
* Add UrVenue Map.

== Upgrade Notice ==

= 1.0 =
* Just released.

= 1.0.1 =
* Add UrVenue Map.