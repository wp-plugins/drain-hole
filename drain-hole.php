<?php
/*
Plugin Name: Drain Hole
Plugin URI: http://urbangiraffe.com/plugins/drain-hole/
Description: A download management and monitoring plugin with statistics and file protection
Author: John Godley
Version: 2.1.11
Author URI: http://urbangiraffe.com/
============================================================================================================
1.0    - Initial version
1.1    - Make relocatable, use Redirection plugin, Google Analytics hookup, multiple drain holes, statistics,
         better tag effeciency
1.1.2  - Add Audit Trail methods, add referrer.  Fix database creation bug.  Add custom role support
1.1.3  - Add show hole tag
1.1.4  - Add template tag and Widget
2.0.0  - Major new version with support for SVN, versions, and charting
2.0.1  - Fix bug in SVN zip production, add option to disable file delete
2.0.2  - Zip file was removing slashes.  Display of hits fixed to show all versions
2.0.3  - Add missing database columns
2.0.4  - Track down first-time hole creation problem
2.0.5  - Once more unto the breach
2.0.6  - Statistic retention saving
2.0.7  - Option to disable .htaccess creation, ability to show SVN in templates, TinyMCE
2.0.8  - Change order of permalinks so downloads are always first
2.0.9  - Fix hole hits
2.0.10 - Add recent file tag, fix IE7 issue
2.0.11 - Fix an issue with hot-link protection and forced downloads
2.0.12 - Fix an issue with some hosts blocking 'escapeshellcmd'
2.0.13 - Change 'show hole' to display ordered by name
2.0.14 - Update ModalBox library
2.0.15 - Fix search error, add $href$ tag
2.0.16 - Add template to show hole
2.0.17 - Add option to hook up to an issue tracker
2.0.18 - Fix #25, #30, #70, #74.  Added new feature #32, #69, #68
2.1    - WordPress 2.5 version
2.1.1  - Forgot
2.1.2  - WP 2.6
2.1.3  - Add default version and file name
2.1.4  - DH scanning
2.1.5  - Better custom 2.6 support
2.1.6  - Default MIME type
2.1.7  - Allow spaces in version number
2.1.9  - Fix problem with truncated URLs on some sites
2.1.10 - Add file modification time
2.1.11 - Update plugin base class
============================================================================================================
This software is provided "as is" and any express or implied warranties, including, but not limited to, the
implied warranties of merchantibility and fitness for a particular purpose are disclaimed. In no event shall
the copyright owner or contributors be liable for any direct, indirect, incidental, special, exemplary, or
consequential damages (including, but not limited to, procurement of substitute goods or services; loss of
use, data, or profits; or business interruption) however caused and on any theory of liability, whether in
contract, strict liability, or tort (including negligence or otherwise) arising in any way out of the use of
this software, even if advised of the possibility of such damage.

For full license details see license.txt
============================================================================================================ */

include (dirname (__FILE__).'/plugin.php');
include (dirname (__FILE__).'/models/hole.php');
include (dirname (__FILE__).'/models/file.php');
include (dirname (__FILE__).'/models/pager.php');
include (dirname (__FILE__).'/models/access.php');
include (dirname (__FILE__).'/models/auditor.php');
include (dirname (__FILE__).'/models/version.php');
include (dirname (__FILE__).'/models/widget.php');


/**
 * DrainHole plugin class
 *
 * @package Drain Hole
 * @author John Godley
 * @copyright Copyright (C) John Godley
 **/

class DrainholePlugin extends DH_Plugin
{
	var $auditor;
	var $excerpt = false;
	
	
	/**
	 * Constructor instantiates the plugin and registers all actions and filters
	 *
	 * @return void
	 **/

	function DrainholePlugin ()
	{
		$this->register_plugin ('drain-hole', __FILE__);
		
		if (is_admin ())
		{
			$this->add_filter ('admin_menu');

			if (strstr ($_SERVER['REQUEST_URI'], 'drain-hole.php'))
				$this->add_action ('admin_head');
			else if (strstr ($_SERVER['REQUEST_URI'], 'post.php') || strstr ($_SERVER['REQUEST_URI'], 'post-new.php') || strstr ($_SERVER['REQUEST_URI'], 'page-new.php') || strstr ($_SERVER['REQUEST_URI'], 'page.php'))
				$this->add_action ('admin_head', 'admin_head_post');

			$this->auditor = new DH_Auditor;
			$this->register_activation (__FILE__);
		}
		else
		{
			$this->add_filter ('the_content');
			$this->add_filter ('the_excerpt');
		}
		
		// And some hooks to insert out files into the permalinks
		$this->add_filter ('rewrite_rules_array');
		$this->add_filter ('parse_request');
		$this->add_filter ('query_vars');
		
		$this->widget = new DH_Widget (__ ('Drainhole Statistics', 'drain-hole'), 5);
	}
	
	function version ()
	{
		return 2;
	}
	
	function parse_request ($request)
	{
		if (isset ($request->query_vars['dhole']))
		{
			$file = DH_File::get ($request->query_vars['dhole']);
			if ($file)
			{
				$hole = DH_Hole::get ($file->hole_id);
				
				$version = '';
				if (preg_match ('/version=(.*)/', $_SERVER['REQUEST_URI'], $matches) > 0)
				{
					$matches[1] = urldecode ($matches[1]);
					$version = DH_Version::get_by_file_and_version ($file->id, $matches[1]);
					if ($version === false)
					{
						$request->query_vars['error'] = '404';
						return $request;
					}
					
					$version = $version->id;
				}

				if ($file->have_access ($hole))
					$file->download ($hole, $version);
				else if ($hole->role_error_url != '')
				{
					wp_redirect ($hole->role_error_url);
					die ();
				}
			}

			$request->query_vars['error'] = '404';
		}
		
		return $request;
	}
	
	
	function query_vars ($vars)
	{
		$vars[] = 'dhole';
		return $vars;
	}
	
	function rewrite_rules_array ($request)
	{
		// Here we insert all our files into the rewrite rules
		$files = DH_File::get_all ();
		$holes = DH_Hole::get_everything ();

		if (count ($holes) > 0)
		{
			foreach ($holes AS $hole)
				$newholes[$hole->id] = $hole;
				
			$holes = $newholes;
		
			$base = parse_url (get_option ('home'));
			$base = ltrim ($base['path'], '/');
			if (count ($files) > 0)
			{
				foreach ($files AS $file)
				{
					$filename = ltrim (preg_quote ($file->url_ref ($holes[$file->hole_id], true), '@'), '/');
					if (substr ($filename, 0, strlen ($base)) == $base)
						$filename = ltrim (substr ($filename, strlen ($base)), '/');
					
					$myrequest[$filename] = 'index.php?dhole='.$file->id;
				}

				$request = array_merge ($myrequest, $request);
			}
		}
		
		return $request;
	}

	
	
	/**
	 * Performs first-time activation by installing the database tables and migrating any older tables
	 *
	 * @return void
	 **/
	
	function activate ()
	{
		$this->upgrade ();
		do_action ('drainhole_installed');
		
		DH_Hole::flush ();
	}
	
	function upgrade ()
	{
		if (get_option ('drainhole_version') != 4)
		{
			include (dirname (__FILE__).'/models/upgrade.php');
			
			$upgrade = new DH_Upgrade ();
			$upgrade->run (4);
		}
	}

	/**
	 * WordPress hook to add to the management menu
	 *
	 * @return void
	 **/
	
	function admin_menu ()
	{
   	add_management_page (__("Drain Hole", 'drain-hole'), __("Drain Hole", 'drain-hole'), "administrator", basename (__FILE__), array (&$this, "admin_screen"));
	}
	
	
	/**
	 * WordPress hook to add CSS and JS
	 *
	 * @return void
	 **/
	
	function admin_head ()
	{
		$this->render_admin ('head');
	}
	
	function admin_head_post ()
	{
		if (user_can_richedit ())
			$this->render_admin ('head_post');
	}
	
	function is_25 ()
	{
		global $wp_version;
		if (version_compare ('2.5', $wp_version) <= 0)
			return true;
		return false;
	}
	
	function submenu ($inwrap = false)
	{
		// Decide what to do
	  $url = explode ('?', $_SERVER['REQUEST_URI']);
	  $url = $url[0];
		$url .= '?page='.$_GET['page'];

		$sub = isset ($_GET['sub']) ? $_GET['sub'] : '';

		if (!$this->is_25 () && $inwrap == false)
			$this->render_admin ('submenu', array ('url' => $url, 'sub' => $sub, 'class' => 'id="subsubmenu"'));
		else if ($this->is_25 () && $inwrap == true)
			$this->render_admin ('submenu', array ('url' => $url, 'sub' => $sub, 'class' => 'class="subsubsub"', 'trail' => ' | '));

		return $sub;
	}
	
	
	/**
	 * Decides which admin page to display, as well as showing any update notifications
	 *
	 * @return void
	 **/
	
	function admin_screen ()
	{
		$this->clear_stats ();
		$this->upgrade ();
		
		$sub = $this->submenu ();

		if ($sub == '')
		{
			if (isset ($_GET['chart']))
				$this->screen_charts (intval ($_GET['chart']), $_GET['source']);
			else if (isset ($_GET['files']))
				$this->screen_files (intval ($_GET['files']));
			else if (isset ($_GET['stats']))
				$this->screen_stats (intval ($_GET['stats']));
			else if (isset ($_GET['version']))
				$this->screen_versions (intval ($_GET['version']));
			else
				$this->screen_holes ();
		}
		else if ($sub == 'options')
			$this->screen_options ();
		else if ($sub == 'downloads')
			$this->screen_downloads ();
	}
	
	
	/**
	 * Expires any download stats that are older than the configured number of days
	 *
	 * @return void
	 **/
	
	function clear_stats ()
	{
		$options = get_option ('drainhole_options');
		if (!isset ($options['days']))
			$options['days'] = 60;

		if ($options['days'] > 0)
		 	DH_Access::clear ($options['days']);
	}
	
	
	/**
	 * Display the admin 'downloads' page
	 *
	 * @return void
	 **/
	
	function screen_downloads ()
	{
		if (isset ($_POST['clear_downloads']))
			DH_Access::delete_all ();
		
		global $wpdb;
		
		$pager = new DH_Pager ($_GET, $_SERVER['REQUEST_URI'], 'created_at', 'DESC', 'drain-hole-downloads', array ('users' => $wpdb->users.'.ID'));
		
		if (isset ($_GET['hole']))
			$stats = DH_Access::get_by_hole (intval ($_GET['hole']), $pager);
		else
			$stats = DH_Access::get_everything ($pager);
			
		$this->render_admin ('downloads', array ('stats' => $stats, 'pager' => $pager));
	}
	
	
	function screen_stats ($id)
	{
		if (isset ($_POST['clear_downloads']))
			DH_Access::delete_by_file ($id);

		global $wpdb;
		
		$pager = new DH_Pager ($_GET, $_SERVER['REQUEST_URI'], 'created_at', 'DESC', 'drain-hole-downloads', array ('users' => $wpdb->users.'.ID'));
		$files = DH_Access::get_by_file ($id, $pager);
		$file  = DH_File::get ($id);
		$hole  = DH_Hole::get ($file->hole_id);
		
		$this->render_admin ('downloads', array ('stats' => $files, 'file' => $file, 'pager' => $pager, 'hole' => $hole));
	}
	
	function screen_versions ($id)
	{
		if (isset ($_POST['save']))
		{
			$_POST = stripslashes_deep ($_POST);
			$file = DH_File::get ($id);
			
			DH_Version::create ($file, $_POST['version'], 0, mktime (0, 0, 0, intval ($_POST['month']), intval ($_POST['day']), intval ($_POST['year'])), $_POST['reason']);
			$this->render_message (__ ('Your version was added succesfully', 'drain-hole'));
		}
		
		$file = DH_File::get ($id);
		$hole = DH_Hole::get ($file->hole_id);
		
		$pager = new DH_Pager ($_GET, $_SERVER['REQUEST_URI'], 'created_at', 'DESC', 'drainhole-versions');
		$versions = DH_Version::get_by_file ($id, $pager);
		
		$this->render_admin ('versions', array ('file' => $file, 'pager' => $pager, 'versions' => $versions, 'hole' => $hole));
	}
	
	
	/**
	 * Display the admin 'files' page
	 *
	 * @return void
	 **/

	function screen_files ($id)
	{
		if (isset ($_POST['rescan']))
		{
			$hole = DH_Hole::get ($id);
			do_action ('drainhole_scan', $hole);
			
			$scanned = $hole->scan ();
			
			DH_Hole::flush ();
			
			if ($scanned == 0)
				$this->render_message (__ ('No new files were found', 'drain-hole'));
			else if ($scanned == 1)
				$this->render_message (sprintf (__ngettext ('%d new file was found', '%d new files were found', $scanned, 'drain-hole'), $scanned));
		}
		else if (isset ($_POST['upload']))
		{
			$hole = DH_Hole::get ($id);
			if (DH_File::upload ($hole, $_POST['filename'], $_FILES['file']))
			{
				DH_Hole::flush ();
				
				$this->render_message ('Your files were successfully updated', 'drain-hole');
				do_action ('drainhole_upload', $hole);
			}
			else
				$this->render_error ('Your files were not updated', 'drain-hole');
		}
		
		$pager = new DH_Pager ($_GET, $_SERVER['REQUEST_URI'], 'file', 'ASC', 'drainhole-files');
		$files = DH_File::get_by_hole ($id, $pager);
		$hole  = DH_Hole::get ($id);
		
		$this->render_admin ('files', array ('files' => $files, 'hole' => $hole, 'pager' => $pager));
	}

	function screen_charts ($id, $source)
	{
		include (dirname (__FILE__).'/models/charts.php');
		
		$chart = new Charts ($this->url ());
		
		if ($source == 'hole')
		{
			$hole = DH_Hole::get ($id);
			$type = 'percent';
			
			if (isset ($_GET['type']))
				$type = $_GET['type'];
		
			if ($type == 'percent')
			{
				$display = 'pie';
				if (isset ($_GET['display']))
					$display = $_GET['display'];
				
				if (!in_array ($display, array ('pie', 'bar')))
					$display = 'pie';
				
				$chart->set_source ($this->url ().'/charts/hole.php?type=percent&display='.$display.'&hole='.$hole->id);
			}	
			else if ($type == 'time')
			{
				$display = 'monthly';
				if (isset ($_GET['display']))
					$display = $_GET['display'];

				if (!in_array ($display, array ('hourly', 'daily', 'monthly')))
					$display = 'daily';

				$chart->set_source ($this->url ().'/charts/hole.php?type=time&display='.$display.'&hole='.$hole->id.$chart->time_to_query ($chart->get_time ($hole)));
			}

			$base = get_bloginfo ('wpurl').'/wp-admin/edit.php?page=drain-hole.php&amp;chart='.$hole->id.'&amp;source=hole';
			$this->render_admin ('chart_holes', array ('hole' => $hole, 'chart' => $chart, 'type' => $type, 'display' => $display, 'base' => $base));
		}
		else
		{
			$file    = DH_File::get ($id);
			$type    = 'access';
			$display = 'daily';
			
			if (isset ($_GET['type']) && in_array ($_GET['type'], array ('access', 'version')))
				$type = $_GET['type'];
				
			if (isset ($_GET['display']) && in_array ($_GET['display'], array ('hourly', 'daily', 'monthly')))
				$display = $_GET['display'];
				
			$chart->set_source ($this->url ().'/charts/file.php?type='.$type.'&display='.$display.'&file='.$file->id.$chart->time_to_query ($chart->get_time ($file)));
			$base = get_bloginfo ('wpurl').'/wp-admin/edit.php?page=drain-hole.php&amp;chart='.$file->id;
			
			$this->render_admin ('chart_files', array ('file' => $file, 'chart' => $chart, 'type' => $type, 'display' => $display, 'base' => $base));
		}
	}

	function screen_holes ()
	{
		if (isset ($_POST['create']))
		{
			$_POST = stripslashes_deep ($_POST);
			if (DH_Hole::create ($_POST))
			{
				DH_Hole::flush ();
				
				$this->render_message (__ ('The Drain Hole was successfully created', 'drain-hole'));
				do_action ('drainhole_hole_created');
			}
			else
				$this->render_message (__ ('The Drain Hole was not created - you must supply a unique URL (without <code>http://</code> prefix) and directory', 'drain-hole'));
				
			// Cache the list of holes so we don't need to access the database
			$holes = DH_Hole::get_as_list ();
		}

		$parts = parse_url (get_bloginfo ('home'));
		$base_url = $parts['path'].'/download';
		$base_directory = $this->realpath (rtrim ($_SERVER['DOCUMENT_ROOT'], '/').'/download').'/';
		
		$pager = new DH_Pager ($_GET, $_SERVER['REQUEST_URI'], 'name', 'ASC');
		$this->render_admin ('holes', array ('holes' => DH_Hole::get_all ($pager), 'pager' => $pager, 'options' => get_option ('drainhole_options'), 'base_url' => $base_url, 'base_directory' => $base_directory, 'home' => $parts['path']));
	}
	
	
	/**
	 * Display the admin 'options' page
	 *
	 * @return void
	 **/
	
	function screen_options ()
	{
		if (isset ($_POST['options']))
		{
			$options = array
			(
				'google'          => isset ($_POST['google']) ? true : false,
				'update'          => isset ($_POST['update']) ? true : false,
				'htaccess'        => isset ($_POST['htaccess']) ? true : false,
				'days'            => intval ($_POST['days']),
				'kitten'          => isset ($_POST['kitten']) ? true : false,
				'delete_file'     => isset ($_POST['delete_file']) ? true : false,
				'svn'             => $_POST['svn'],
				'tracker'         => $_POST['tracker'],
				'default_version' => $_POST['default_version'],
				'default_name'    => $_POST['default_name']
			);
			
			update_option ('drainhole_options', $options);
			$this->render_message (__ ('Your options have been updated', 'drain-hole'));
		}
		else if (isset ($_POST['delete']))
		{
			include (dirname (__FILE__).'/models/upgrade.php');
			
			$upgrade = new DH_Upgrade ();
			$upgrade->delete (__FILE__);
			
			$this->render_message ('Drain Hole has been removed', 'drain-hole');
		}
		
		$options = get_option ('drainhole_options');
		if (!isset ($options['days']))
			$options['days'] = 60;
		if (!isset ($options['update']))
			$options['update'] = true;
			
		if (!isset ($options['svn']))
		{
			$options['svn'] = exec ('which svn');
			if (strpos ($options['svn'], 'no svn') !== false)
				$options['svn'] = '';
		}

		$this->render_admin ('options', array ('options' => $options));
	}
	
	
	/**
	 * Replaces inline tags when showing a file
	 *
	 * @param string $text The text to perform the replacement upon
	 * @param DH_Hole $hole The Hole object for the file we are displaying
	 * @param DH_File $file The File object representing the file we are displaying
	 * @return string The original text with any replacements made
	 **/
	
	function tags_inline ($text, $hole, $file)
	{
		$options = get_option ('drainhole_options');

		$text = str_replace ('$url$',     $file->url ($hole, '', $options['google']), $text);
		$text = str_replace ('$size$',    $file->bytes ($file->filesize ($hole)), $text);
		$text = str_replace ('$desc$',    $file->description, $text);
		$text = str_replace ('$updated$', date (get_option ('date_format'), $file->updated_at), $text);
		$text = str_replace ('$hits$',    number_format ($file->hits), $text);
		$text = str_replace ('$version$', $file->version, $text);
		$text = str_replace ('$icon$',    $file->icon ($hole, $this->url (), $options['google']), $text);
		$text = str_replace ('$svn$',     $file->svn (), $text);
		$text = str_replace ('$href$',    $file->url_ref ($hole), $text);
		$text = str_replace ('$name$',    $file->name (), $text); 
		$text = str_replace ('$iconref$', $file->icon_ref ($this->url ()), $text);
		$text = str_replace ('$md5$',     md5 ($file->file ($hole)), $text);
		return $text;
	}
	
	
	/**
	 * Replaces matched regular expressions with appropriate data
	 * 
	 * @param array $matches An array of matches from preg_replace.  $matches[1]=type, $matches[2]=ID, $matches[3]=command, $matches[4]=arguments
	 * @return string New text with replaced tags
	 **/
	
	function tags ($matches)
	{
		$type = $matches[1];
		$id   = intval ($matches[2]);
		$cmd  = $matches[3];
		$args = $matches[4];
		
		$options = get_option ('drainhole_options');
		
		if ($type == 'hole')
		{
			$hole = DH_Hole::get ($id);
			if ($hole)
			{
				if ($cmd == 'hits')
					return number_format ($hole->hits);
				else if ($cmd == 'recent')
				{
					if ($args == 0)
						$args = 1;
					$files = DH_File::get_recent ($hole->id, $args);
					return $this->capture ('show_hole', array ('files' => $files, 'hole' => $hole));
				}
				else if ($cmd == 'show' && !$this->excerpt)
				{
					if ($args == '')
						$args = 'show_hole';
					$files = DH_File::get_all ($hole->id);
					return $this->capture ($args, array ('files' => $files, 'hole' => $hole));
				}
			}
		}
		else if ($type == 'file')
		{
			$file = DH_File::get ($id);
			if ($file)
			{
				$hole = DH_Hole::get ($file->hole_id);
				if ($cmd == 'show' && !$this->excerpt)
				{
					if ($args == '')
						$args = 'default_show';
					return $this->tags_inline ($this->capture ($args, array ('file' => $file, 'hole' => $hole)), $hole, $file);
				}
				else if ($cmd == 'versions')
				{
					$limit = 5;
					if ($args)
						$limit = intval ($args);
						
					$versions = DH_Version::get_history ($file->id, $file->version_id, $limit);
					if (count ($versions) > 0 && $options['tracker'])
					{
						foreach ($versions AS $pos => $version)
							$versions[$pos]->reason = preg_replace ('@\#(\d*)@', '<a href="'.$options['tracker'].'$1">#$1</a>', $version->reason);
					}

					return $this->capture ('versions', array ('versions' => $versions, 'file' => $file, 'hole' => $hole));
				}
				else if ($cmd == 'version')
					return $file->version;
				else if ($cmd == 'hits')
					return number_format ($file->hits);
				else if ($cmd == 'md5')
					return md5 ($file->file ($hole));
				else if ($cmd == 'url')
					return $file->url ($hole, $args == '' ? basename ($file->file) : $args, $options['google']);
				else if ($cmd == 'href')
					return $file->url_ref ($hole);
				else if ($cmd == 'svn')
					return $file->svn ();
				else if ($cmd == 'updated')
					return date (get_option ('date_format'), $file->updated_at);
				else if ($cmd == 'size')
					return $file->bytes ($file->filesize ($hole));
				else if ($cmd == 'icon')
					return $file->icon ($hole, $this->url (), $options['google']);
			}
		}
	}
	
	
	/**
	 * Filters post content and replaces drainhole tags
	 *
	 * @param string $text The post content
	 * @return void
	 **/
	
	function the_content ($text)
	{
		if (is_search ())
			$this->excerpt = true;
		return preg_replace_callback ('/(?:<p>\s*)?\[drain\s*(\w+)\s*(\d+)\s*(\w+)\s*(.*?)\](?:\s*<\/p>)?/', array (&$this, 'tags'), $text);
	}
	
	
	/**
	 * Filters post excerpt and replaces drainhole tags.  'show' commands are removed
	 *
	 * @param string $text The post content
	 * @return void
	 **/
	
	function the_excerpt ($text)
	{
		$this->excerpt = true;
		return $this->the_content ($text);
	}
	
	function csv_escape ($value)
	{
		// Escape any special values
		$double = false;
		if (strpos ($value, ',') !== false || $value == '')
			$double = true;

		if (strpos ($value, '"') !== false)
		{
			$double = true;
			$value  = str_replace ('"', '""', $value);
		}

		if ($double)
			$value = '"'.$value.'"';
		return $value;
	}
}


/**
 * WordPress template function to display the top downloads
 *
 * @param int $count Maximum items to display (default 5)
 * @return void
 **/

function the_drainhole_stats ($count = 5)
{
	global $drainhole;
	$drainhole->render ('top_downloads', array ('files' => DH_File::get_top_downloads ($count)));
}

function the_drainhole ($text)
{
	global $drainhole;
	echo $drainhole->the_content ($text);
}

/**
 * Our one and only instance of the plugin
 *
 * @global DrainholePlugin The plugin
 **/

$drainhole = new DrainholePlugin ();

function mymce ($plugins)
{
	$plugins[] = 'drainhole';
	return $plugins;
}

function mymcebuttons ($buttons)
{
	$buttons[] = 'drainhole';
	return $buttons;
}

//add_filter ('mce_plugins', 'mymce');
//add_filter ('mce_buttons', 'mymcebuttons');
?>