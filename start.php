<?php
/**
 * Elgg GUID Tool
 *
 * @package ElggGUIDTool
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */

/**
 * Initialise the tool and set menus.
 */
function guidtool_init()
{
    /*if (isadminloggedin())
    {
        add_menu(elgg_echo('guidtool'), $CONFIG->wwwroot . "pg/guidtool/",array(
//				menu_item(elgg_echo('guidtool:browse'), $CONFIG->wwwroot."pg/guidtool/"),
//				menu_item(elgg_echo('guidtool:import'), $CONFIG->wwwroot."pg/guidtool/import/"),
        ),'guidtool');

    }*/

    // Register a page handler, so we can have nice URLs
    elgg_register_page_handler('guidtool', 'guidtool_page_handler');

    // Register some actions
    $plugins = elgg_get_plugins_path();
    elgg_register_action("guidtool/delete", false, "{$plugins}guidtool/actions/delete.php", true);

}

/**
 * Post init gumph.
 */
function guidtool_page_setup()
{
    $url = elgg_get_site_url();
    if ((elgg_is_admin_logged_in()) && (elgg_get_context()=='admin')) {
        $item = array(
            'name' => elgg_echo('guidtool:browse'),
            'text' => elgg_echo('guidtool:browse'),
            'href' => "{$url}pg/guidtool/",
            'context' => 'admin');
        elgg_register_menu_item('page', $item);
        $item = array(
            'name' => elgg_echo('guidtool:import'),
            'text' => elgg_echo('guidtool:import'),
            'href' => "{$url}pg/guidtool/import/",
            'context' => 'admin');
        elgg_register_menu_item('page', $item);
    }
}

/**
 * Log browser page handler
 *
 * @param array $page Array of page elements, forwarded by the page handling mechanism
 */
function guidtool_page_handler($page)
{
    $url = elgg_get_site_url();
    $plugins_path = elgg_get_plugins_path();

    if (isset($page[0])) {
        switch ($page[0]) {
            case 'view' :
                if ((isset($page[1]) && (!empty($page[1])))) {

                    // @todo rewrite menu code :(
                    add_submenu_item('GUID:'.$page[1], "{$url}pg/guidtool/view/{$page[1]}/");
                    add_submenu_item(elgg_echo('guidbrowser:export'), "{$url}pg/guidtool/export/{$page[1]}/");
                }

            case 'export':
                if ((isset($page[1]) && (!empty($page[1])))) {

                    set_input('entity_guid', $page[1]);
                    if ($page[0] == 'view') {
                        include("{$plugins_path}guidtool/view.php");
                    } else {
                        if ((isset($page[2]) && (!empty($page[2])))) {
                            set_input('format', $page[2]);
                            include("{$plugins_path}guidtool/export.php");
                        } else {
                            set_input('forward_url', "{$url}pg/guidtool/export/$page[1]/");
                            include("{$plugins_path}guidtool/format_picker.php");
                        }
                    }
                } else {
                    include("{$plugins_path}guidtool/index.php");
                }
            break;
            case 'import' :
                if ((isset($page[1]) && (!empty($page[1])))) {
                    set_input('format', $page[1]);
                    include("{$plugins_path}guidtool/import.php");
                } else {
                    set_input('forward_url', "{$url}pg/guidtool/import/");
                    include("{$plugins_path}guidtool/format_picker.php");
                }
            break;
            default:
                include("{$plugins_path}guidtool/index.php");
        }
    } else {
        include("{$plugins_path}guidtool/index.php");
    }
}

/**
 * Get a list of import actions
 *
 */
function guidtool_get_import_actions()
{
    $return = array();

    foreach (elgg_get_config('actions') as $action => $handler) {
        if (strpos($action, "import/") === 0) {
            $return[] = substr($action, 7);
        }
    }

    return $return;
}

// Initialise log
elgg_register_event_handler('init', 'system', 'guidtool_init');
elgg_register_event_handler('pagesetup', 'system', 'guidtool_page_setup');