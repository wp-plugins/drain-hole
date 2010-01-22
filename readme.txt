=== Drain Hole ===
Contributors: johnny5
Donate link: http://urbangiraffe.com/about/support/
Tags: post, page, download, manager, svn, version
Requires at least: 2.7
Tested up to: 2.9.1
Stable tag: trunk

Drain Hole is a centralized download manager with full monitoring, statistics, versioning, SVN support, and proper SEO download URLs (no nasty query parameters)

== Description ==

Drain Hole is a centralized download manager, with full monitoring and statistics, versioning, SVN support, and SEO download URLs (no more nasty query strings!).

In addition to it's monitoring abilities, Drain Hole has a run-time tag replacement feature that lets you embed special tags in your post which are replaced with information from Drain Hole. For example, you can embed download URLs, version information, last update times etc. Whenever you change a downloadable file it is automatically updated throughout your blog, without you needing to change anything else.

Features include:

* SEO download URLs - a unique feature that allows files to look like real links
* Store files on your own server, or on a remote server (such as Amazon S3, wordpress.org etc.)
* SVN support - attach a file directly to an SVN repository and have the contents automatically updated
* Versioning - maintain multiple versions of a file, allowing users to download older files
* Full download statistics, including number of downloads, access times, referrer, and download speed, available as CSV and Flash-based graphs
* Download security - permissions can be assigned to downloads (including Flash files), restricting them to WordPress roles
* Template tags - insert dynamic download data into posts, and into the sidebar as a Widget
* Hot-link protection
* Fully localized

Drain Hole is available in:

* English
* Danish (thanks to [Georg S. Adamsen](http://wordpress.blogos.dk))

== Installation ==

The plugin is simple to install:

1. Download `drain-hole.zip`
1. Unzip
1. Upload `drain-hole` directory to your `/wp-content/plugins` directory
1. Go to the plugin management page and enable the plugin

You can find full details of installing a plugin on the [plugin installation page](http://urbangiraffe.com/articles/how-to-install-a-wordpress-plugin/).

== Screenshots ==

1. Example statistics
2. Manage files
3. Create versions and update from SVN

== Documentation ==

Full documentation can be found on the [Drain Hole](http://urbangiraffe.com/plugins/drain-hole/) page.

== Changelog ==

= 1.0    = 
* Initial version

= 1.1    = 
* Make relocatable
* Use Redirection plugin
* Google Analytics hookup
* Multiple drain holes
* Statistics,
* Better tag effeciency

= 1.1.2  = 
* Add Audit Trail methods
* Add referrer.
* Fix database creation bug.
* Add custom role support

= 1.1.3  = 
* Add show hole tag

= 1.1.4  = 
* Add template tag and Widget

= 2.0.0  = 
* Major new version with support for SVN, versions, and charting

= 2.0.1  = 
* Fix bug in SVN zip production
* Add option to disable file delete

= 2.0.2  = 
* Zip file was removing slashes.
* Display of hits fixed to show all versions

= 2.0.3  = 
* Add missing database columns

= 2.0.4  = 
* Track down first-time hole creation problem

= 2.0.5  = 
* Once more unto the breach

= 2.0.6  = 
* Statistic retention saving

= 2.0.7  = 
* Option to disable .htaccess creation
* Ability to show SVN in templates
* TinyMCE

= 2.0.8  = 
* Change order of permalinks so downloads are always first

= 2.0.9  = 
* Fix hole hits

= 2.0.10 = 
* Add recent file tag
* Fix IE7 issue

= 2.0.11 = 
* Fix an issue with hot-link protection and forced downloads

= 2.0.12 = 
* Fix an issue with some hosts blocking 'escapeshellcmd'

= 2.0.13 = 
* Change 'show hole' to display ordered by name

= 2.0.14 = 
* Update ModalBox library

= 2.0.15 = 
* Fix search error
* Add $href$ tag

= 2.0.16 = 
* Add template to show hole

= 2.0.17 = 
* Add option to hook up to an issue tracker

= 2.0.18 = 
* Fix #25, #30, #70, #74
* Added new feature #32, #69, #68

= 2.1    = 
* WordPress 2.5 version

= 2.1.1  = 
* Forgot

= 2.1.2  = 
* WP 2.6

= 2.1.3  = 
* Add default version and file name

= 2.1.4  = 
* DH scanning

= 2.1.5  = 
* Better custom 2.6 support

= 2.1.6  = 
* Default MIME type

= 2.1.7  = 
* Allow spaces in version number

= 2.1.9  = 
* Fix problem with truncated URLs on some sites

= 2.1.10 = 
* Add file modification time

= 2.1.11 = 
* Update plugin base class

= 2.1.12 = 
* Allow for sites with open_basedir restrictions

= 2.2    = 
* Using jQuery.
* Fix #336.
* Add feature #318

= 2.2.1  = 
* 2.7 styling, nonces

= 2.2.2  = 
* Better display style

= 2.2.3  = 
* Fix #379

= 2.2.4  = 
* Fix deletion of holes

= 2.2.5  = 
* Fix charts display

= 2.2.6  = 
* Danish translation

= 2.2.7  = 
* Make work with Search Unleashed, WP2.8

= 2.2.8 =
* Fix deep slashes