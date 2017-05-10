<?php
/**
 * Elgg GUID Tool
 *
 * @package   ElggGUIDTool
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author    Curverider Ltd
 * @copyright Curverider Ltd 2008-2010
 * @link      http://elgg.com/
 */

/**
 * Initialise the tool and set menus.
 */
function guidtool_init() {
	global $CONFIG;

	// Register some actions
	elgg_register_action("guidtool/search", $CONFIG->pluginspath . "guidtool/actions/search.php", "admin");

	elgg_register_admin_menu_item('administer', 'list', 'guidtool');
	elgg_register_admin_menu_item('administer', 'search', 'guidtool');
}

// Initialise log
elgg_register_event_handler('init', 'system', 'guidtool_init');