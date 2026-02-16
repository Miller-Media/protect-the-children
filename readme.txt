=== Protect the Children! ===
Contributors: millermedianow, millermediadev, mohsinrasool, deltafactory, danmossop, ad_taylor
Tags: password protect, child pages, parent pages, visibility, password
Tested up to: 6.9.1
Stable tag: 1.4.7
Requires PHP: 8.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily password protect the child pages/posts of a post/page that is password protected.

== Description ==

**Did you find this plugin helpful?** Please consider [leaving a 5-star review](https://wordpress.org/support/view/plugin-reviews/protect-the-children/).

Please help by contributing to the GitHub repository [Protect the Children on GitHub](https://github.com/Miller-Media/protect-the-children)

Do you have a password protected post or page that has child (and grandchild) pages? Currently, you have to password protect each of these pages individually but, with this simple and efficient plugin, you can automatically password protect a page and all of it's children automatically with the click of a button.

Once you choose the 'Visibility' option on a post and update it to 'Password Protected', you will be given a checkbox where you can opt into protecting all of that post's children and grandchildren.

PROTECT THE CHILDREN!

== Localizations ==
This plugin is available in the following languages:

* Arabic (العربية)
* Bulgarian (Български)
* Chinese Simplified (简体中文)
* Croatian (Hrvatski)
* Czech (Čeština)
* Danish (Dansk)
* Dutch (Nederlands)
* Finnish (Suomi)
* French (Français)
* German (Deutsch)
* Greek (Ελληνικά)
* Hebrew (עברית)
* Hungarian (Magyar)
* Indonesian (Bahasa Indonesia)
* Italian (Italiano)
* Japanese (日本語)
* Korean (한국어)
* Lithuanian (Lietuvių)
* Norwegian (Norsk)
* Polish (Polski)
* Portuguese - Brazil (Português do Brasil)
* Romanian (Română)
* Russian (Русский)
* Slovak (Slovenčina)
* Slovenian (Slovenščina)
* Spanish (Español)
* Swedish (Svenska)
* Thai (ไทย)
* Turkish (Türkçe)
* Vietnamese (Tiếng Việt)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/protect-the-children` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. On any post or page, click 'Edit' next to Visibility, change the post to 'Password Protected' and an optional checkbox to turn on protection of that page's children will appear.

== Frequently Asked Questions ==

= How do I protect child pages? =

Edit the parent page, set its Visibility to "Password Protected", enter a password, and check the "Protect child pages" checkbox. All child and grandchild pages will automatically be protected with the same password.

= Does it work with custom post types? =

Yes! As of version 1.3.9, the plugin fully supports custom post types that have hierarchical (parent/child) relationships.

= Do users need to enter the password for every child page? =

No. Once a user enters the password on any protected page (parent or child), all related pages are unlocked for that session.

= Does it work with the Gutenberg block editor? =

Yes. The plugin supports both the classic editor and the Gutenberg block editor (WordPress 5.0+). The protection checkbox appears in the Visibility settings panel.

= What languages are supported? =

The plugin is available in 30 languages with more being added regularly. We are working toward supporting 50 languages total!

== Screenshots ==

1. WP 5.0+ Before changing to 'Password Protected'
2. WP 5.0+ Change to 'Password Protected'
3. WP 5.0+ Additional option now added
4. WP <5.0 Before changing to 'Password Protected'
5. WP <5.0 After changing to 'Password Protected' (note the checkbox directly above the Publish button)
6. WP <5.0 Admin screen for child post when being protected by parent
7. WP <5.0 Child posts displayed as protected by parent

== Changelog ==

= 1.4.7 =
* Added translations for Russian, Polish, Dutch, Turkish, and Swedish
* Updated localization section in readme

= 1.4.6 =
* Added Chinese Simplified (zh_CN) translation

= 1.4.5 =
* Added Japanese (ja) translation

= 1.4.4 =
* Tested up to WordPress 6.9.1

= 1.4.3 =
* Fixed critical bug where updating parent page via Quick Edit removed password protection from children
* Added dismissible review prompt notice after 14 days of usage

= 1.4.2 =
* Added translations for Spanish, French, German, Portuguese (Brazilian), and Italian

= 1.4.1 =
* Compatibility updates for WordPress 6.9 and PHP 8.1+

= 1.4.0 =
* Fixed issue with nested child pages

= 1.3.9 =
* Added full support for custom post types
* Fixed Gutenberg issues with protected meta fields
* Added public GitHub link to plugin description

= 1.3.5 =
* Fixed valid header warning when activating

= 1.3.4 =
* Code enhancements

= 1.3.3 =
* Bug fix when save_post hook is called during page save

= 1.3.2 =
* Minor Bug Fix

= 1.3.1 =
* Minor Bug Fix

= 1.3 =
* Add support for WordPress 5.0 i.e. Gutenberg Editor

= 1.2.3 =
* Bug fix for password protection input on child and grandchild posts

= 1.2.2 =
* Support for password protection of grandchildren/nested child posts
* Additional display on the post list screen to specify protected child posts

= 1.2.1 =
* Performance improvements
* Bug fix for parent post link

= 1.2 =
* Child post displays password protected status in admin when its parent is protecting children.
* Misc code cleanup

= 1.1 =
* All posts (parent and children) are now unlocked by entering the password on one of those protected pages.

= 1.0.1 =
* Tested and confirmed compatibility for PHP 7.2
* Tested and confirmed compatbility with WordPress 4.9.4
* Removed support for PHP versions lower than 5.6

= 1.0 =
* The initial public release!