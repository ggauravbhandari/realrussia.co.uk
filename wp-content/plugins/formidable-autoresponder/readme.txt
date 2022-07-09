=== Formidable Form Action Automation ===
Tags: formidable, forms, autoresponder, email,
Requires at least: 4.0 ( Formidable Pro 2.x or higher is required )
Tested up to: 4.4.1
Stable tag: 1.0.7.1

This plugin allows you to set up an autoresponder email as a Formidable Form notification.

== Description ==

Formidable Form Action Automation turns Formidable's notifications into powerful autoresponders.

* Schedule when to send out the email notification, based on time passed since the entry was created or updated.  Or, use one of the entry's fields to schedule the email
* Schedule the email to go out again after a specified amount of time
* Limit the number of times the email will be sent out
* Use the existing Conditional Logic settings to further augment the logic behind when to send out the email

Use Formidable Form Action Automation to turn your Formidable forms application into a powerful marketing tool for your business!

== Installation ==

1. Install the ZIP file to your server and activate the plugin

== Frequently Asked Questions ==

= What version of Formidable Pro do I need? =

Formidable Autoresponder has been built to work with the new notification API that came out in Formidable Pro 2.0.  Therefore, you must be using at least Formidable Pro 2.0.

= How do I set up an autoresponder? =

Create your Formidable Pro form as you are accustomed to doing.  To create an autoresponder, you will go to the Settings page for the form, and then choose Form Actions from the left-hand nav bar.  Then, create an Email notification.  Please note, there are other types of notifications available there, like creating a post, but at this time, Formidable Autoresponder only works with the email notifications.

To add an autoresponder, click the *Setup Autoresponder* link.  This will reveal all of the settings that you'll need to tweak.

The first setting you'll see is a dropdown allowing you to _ignore_ or _respect_ the default "Trigger this action after" setting in the notification.  The default is to ignore it.  If you _respect_ the setting, then the email notification will go out as regular when the form is created/updated.  If you _ignore_ it, then no immediate email will be sent.

Then, you can choose how many days, hours or minutes after the entry was created ( or modified ) you wish to send the email.  You can also use a date field from your form as the reference date.  If using a date field from your form, you can actually set the autoresponder to send some amount of time _before_ the reference date.

You can also choose to repeat the mailer by checking the "...and then every" checkbox.  This will allow you to specify the number of days, hours or minutes to wait to send the email again, up to a maximum number of times.

When repeating the mailer, you can also use a number field from the form to set the interval time.

= Can I use Formidable Pro's conditional logic at the same time as Formidable Autoresponder? =

Yes, Formidable Autoresponder will respect whatever conditional logic is setup for the notification.  Please note, the autoresponder will get scheduled regardless of whether the conditions pass at the time.  It checks the conditions at the time of sending.

= I tried to upgrade and received a message The package could not be installed. PCLZIP_ERR_BAD_FORMAT (-10) : Unable to find End of Central Dir Record signature =
It’s most likely that the Top Quark credentials are not entered properly on the Settings > Formidable Autoresponder page.  Go there, enter the credentials you received when you purchased the plugin, get the "Awesome! You're good to go!" message, and then visit your plugins page. Add `?forceCheck=true` to the end of the plugins.php url.  Then, you should be able to run the update properly.

= I see there's an update, but it says my subscription has run out.  What's up? =
It’s most likely that the Top Quark credentials are not entered properly on the Settings > Formidable Autoresponder page.  Go there, enter the credentials you received when you purchased the plugin, get the "Awesome! You're good to go!" message, and then visit your plugins page. Add `?forceCheck=true` to the end of the plugins.php url.  Then, you should be able to run the update properly.

== Changelog ==

= 1.0.7.1 =
* Fixed: issue with clearing existing autoresponders
* Added: filter on trigger timestamp

= 1.0.7 =
* Fixed: Issue with triggering a followup autoresponder off of a custom field
* Fixed: Different issue with triggering the initial autoresponder off a custom field
* Cleanup: much code cleanup and refactoring
* Internal: automated unit tests added

= 1.0.6 =
* Fixed: Issue where it would get the time for a subsequent email wrong
* Added index.php files that allow drilling into directories within the WordPress Plugin Editor

= 1.0.5 =
* Critical Fix: Fixed issue that was causing email to get sent repeatedly
* Change: calculated date to send the autoresponder is in the past, don't send it

= 1.0.4 =
* Fixed timer issues that confused days with hours
* Tidied up how the debug logs get shown
* Added in a queue viewer do you can see what emails are in the queue

= 1.0.3 =
* Change how we actually trigger the autoresponder
* Fixed strangeness with the "ignore" the default send settings
* Fixed issue that caused other notifications to not trigger if an autoresponder was set to ignore the default send settings
* Added a debug setting to help in debugging autoresponders

= 1.0.2 =
* Fix how we "ignore" the default send settings
* Do not send autoresponder if entry has been deleted.

= 1.0.1 =
* Fix issue with unexpected '<' failure.

= 1.0.0 =
* Initial release
