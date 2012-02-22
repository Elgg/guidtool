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

$entity_guid = get_input('entity_guid');

// Render the file upload page
$title = "GUID: $entity_guid";
$body = elgg_view_title($title);
$body .= elgg_view("guidtool/profile", array('entity_guid' => $entity_guid));

echo elgg_view_page($title, elgg_view_layout("two_column_left_sidebar", array('area2' => $body)));