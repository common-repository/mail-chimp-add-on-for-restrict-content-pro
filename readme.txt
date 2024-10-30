=== Restrict Content Pro - MailChimp ===
Author URI: https://ithemes.com
Author: iThemes
Contributors: jthillithemes, ithemes
Tags: Restrict content, member only, registered, logged in, restricted access, restrict access, limiit access, read-only, read only, mailchimp, mail chimp, newsletter, email list
Requires at least 3.9
Tested up to: 5.8
Stable tag: 1.3.4

Add MailChimp integration to Restrict Content Pro.

== Description ==

**On October 14th, 2021,  Restrict Content Pro MailChimp will be removed from the WordPress plugin repository.**

**The plugin is no longer necessary now that all Restrict Content Pro plans include the Mailchimp Pro.**

**MailChimp Pro and all other Restrict Content Pro add-ons will remain available to download in your <a href="https://members.ithemes.com/panel/downloads.php">iThemes Member's Panel</a>.**

This is an add-on for the Restrict Content Pro plugin. It does not function on its own.

This plugin will add a MailChimp Newsletter signup option to the member registration form in Restrict Content Pro.

Learn more about Restrict Content Pro: https://restrictcontentpro.com/


== Changelog ==

= 1.3.4 =
* Update: Notice around plugin changes

= 1.3.3 =
* Tweak: Update plugin author name and URL.
* Tweak: Fetch 150 MailChimp lists instead of 25.
* Fix: Incorrect hook used for displaying signup status on Customer Details page. This now displays correctly.

= 1.3.2 =
* New: Add setting to choose default checked status for opt-in checkbox.
* New: Add debug logging.
* Fix: Verify subscription is successful before updating user meta designating that it was.

= 1.3.1 =
* New: Added notice about MailChimp Pro add-on.
* Fix: Use `<h1>` tags instead of `<h2>` in settings page header.
* Fix: First and last name not being sent to MailChimp.

= 1.3 =
* Updated to use the MailChimp 3.0 API.
* Added translation support.
* Fixed misspelling in default signup label.
* Customers are no longer subscribed if their payment fails during registration.
* General code improvements.
* New rcp_mailchimp_subscribe_args filter, which allows developers to customize the subscription arguments before subscribing the member.

= 1.2.1 =

* Added a filter called "rcp_mailchimp_merge_vars" that lets developers modify the merge vars sent to MailChimp

= 1.2 =

* Removed the MailChimp Signup column in order to fix display issues on smaller screens
* Added MailChimp signup status to the View Member Details screen

= 1.1 =

* Added First and Last name to the fields that get sent to Mail Chimp

= 1.0.5 =

* Fixed a class conflict that happened when other Mail Chimp plugins were installed
* Improved settings page to match core WP UI

= 1.0.4 =

* Updated the hook used to display the checkbox to work better with other add-ons.

= 1.0.3 =

* Added a "Mail Chimp Signup" column to the Members page to show whether a user signed up for your newsletter.

= 1.0.2 =

* Minor Improvements

= 1.0.1 =

* Added a user meta option that keeps track of when users choose to sign up for the newsletter *

= 1.0 =

* Initial release.

== Upgrade Notice ==

= 1.3.3 =

* Increase number of MailChimp lists fetched & fix signup status not displaying on Customer Details page.

= 1.3.2 =

* New setting to choose default opt-in checked state, add debug logging, and minor bug fix.

= 1.3.1 =

* Fixed bug with first and last name not being sent to MailChimp. Added note about MailChimp Pro add-on.

= 1.1 =

* Added First and Last name to the fields that get sent to Mail Chimp

= 1.0.5 =

* Fixed a class conflict that happened when other Mail Chimp plugins were installed
* Improved settings page to match core WP UI

= 1.0.4 =

* Updated the hook used to display the checkbox to work better with other add-ons.

= 1.0.3 =

* Added a "Mail Chimp Signup" column to the Members page to show whether a user signed up for your newsletter.
