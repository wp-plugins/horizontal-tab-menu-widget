=== AmR Tab Menu Navigation ===
Contributors: anmari
Donate link: http://webdesign.anmari.com/web-tools/donate/
Tags: tab, navigation, menu, pages
Requires at least: 2.5 (not tested on earlier versions)
Tested up to: 2.6
Stable tag: /trunk/

Produces a non nested list of levels, each listing the pages at each level of the menu tree down to the child level of the current menu.   

== Description ==

The idea is to provide a navigation menu that looks like old tabs on the file folders - when you slid open the filing cabinet drawer there were the tabs on the files to guide you. The widget will list as many levels as you have however two or three looks the best. Four is okay. If you have a deeper structure, consider single level global navigation, plus a breadcrumb menu, with a fold pages style menu at the side.  Only the siblings of the current ancestors are shown.  It is intended to be styled horizontally. 

Features

* Uses a list of unordered lists of parent pages with minimal markup
* Provides default css styling (no spans for separators), with the option to switch the default styling off to use your own
* Uses wordpress sandboxplus flavoured css tags, so will pickup any general styling too, as well as allowing you to style the tab menu yourself.
* Intended to be inserted into a widget enabled header or branding div (horizontal)
* Package consists of one plugin file and a default styling background image
* Some default images are provided for css variations. Some images allow a choice of custom colours.

Tested and Validated

The plugin has been tested on wordpress 2.5 and 2.6. The Css and the html produced have been validated by the w3c validator. The CSS has been tested on IE 7 and Firefox 2. It is fairly standard CSS. Please let me know if any problems are experienced.

If you have just widgetized your theme’s header, you may need to also switch off the list style for the high level ul. eg: div.sidebar ul { list-style-type: none; }. If your theme already allowed for widgets then hopefully it’s styling already provided a suitable style for all div’s of a class sidebar.

== Installation ==

1. Unzip the folder into your wordpress plugins folder.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add the widget to the chosen sidebar. EG: In Sandbox plus, this would probably be the sidebar 3. (Note many themes do not allow for this possibility, however you can add an additional sidebar to your header see [WordPress Stepping_Into_Templates](http://codex.wordpress.org/Stepping_Into_Templates) or [Anmari's widgetising headers](http://webdesign.anmari.com/widgetized-headers-and-footers/)
4. That’s it - customise the css and background image to taste.
 
== Frequently Asked Questions ==

= There is no indentation! =

There is not intended to be ... the "rows" are not nested.  It is intended to be a "wide" breadcrumb trail!
One could style each row differently to highlight the levels.

== Screenshots ==

1. Screenshot of a tab navigation with minimal styling in the default wordpress theme.
2. Screenshot of a blue rounded tab navigation using asliding doors type technique and a single image with positioned backgrounds
3. Widget configuration screen


