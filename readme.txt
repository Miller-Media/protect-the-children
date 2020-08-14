=== Protect the Children! ===
Contributors: millermedianow, millermediadev, mohsinrasool, deltafactory
Tags: password protect, password, protected, protect, password, child, parent, edit, visibility
Tested up to: 5.5
Stable tag: 1.3.6
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily password protect the child pages/posts of a post/page that is password protected.

== Description ==

Do you have a password protected post or page that has child (and grandchild) pages? Currently, you have to password protect each of these pages individually but, with this simple and efficient plugin, you can automatically password protect a page and all of it's children automatically with the click of a button.

Once you choose the 'Visibility' option on a post and update it to 'Password Protected', you will be given a checkbox where you can opt into protecting all of that post's children and grandchildren.

PROTECT THE CHILDREN!

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/protect-the-children` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. On any post or page, click 'Edit' next to Visibility, change the post to 'Password Protected' and an optional checkbox to turn on protection of that page's children will appear.

== Screenshots ==

1. WP 5.0+ Before changing to 'Password Protected'
2. WP 5.0+ Change to 'Password Protected'
3. WP 5.0+ Additional option now added
4. WP <5.0 Before changing to 'Password Protected'
5. WP <5.0 After changing to 'Password Protected' (note the checkbox directly above the Publish button)
6. WP <5.0 Admin screen for child post when being protected by parent
7. WP <5.0 Child posts displayed as protected by parent

== Changelog ==

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