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

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

admin_gatekeeper();
elgg_set_context('admin');

$title = elgg_echo("guidtool");
$body = elgg_view_title($title);

$context = elgg_get_context();
elgg_set_context('search');

$limit = get_input('limit', 10);
$offset = get_input('offset');

// Get entities

$entities = elgg_get_entities(array(
    'limit' => $limit,
    'offset' => $offset,
));
$count = elgg_get_entities(array(
    'limit' => $limit,
    'offset' => $offset,
    'count' => true,
));

$wrapped_entries = array();

foreach ($entities as $e) {
    $tmp = new ElggObject();
    $tmp->subtype = 'guidtoolwrapper';
    $tmp->entity = $e;
    $wrapped_entries[] = $tmp;
}

$body .= elgg_view_entity_list($wrapped_entries, array(
    'count' => $count,
    'offset' => $offset,
    'limit' => $limit,
    'full_view' => false,
));

elgg_set_context($context);

// Display main admin menu

echo elgg_view_page($title, elgg_view_layout("two_column_left_sidebar", array('area2' => $body)));