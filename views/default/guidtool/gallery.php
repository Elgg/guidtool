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

global $CONFIG;

$entity = $vars['entity']->entity;
$by = $entity->getOwnerEntity();

$strap = $entity->title ? $entity->title : $entity->name;

$info_link = elgg_view('output/url', array(
    'text' => "[GUID:{$entity->guid}] " . get_class($entity) . " " . get_subtype_from_id($entity->subtype),
    'href' => "guidtool/view/{$entity->guid}/",
));

$info .= "<p><b>$info_link</b> $strap</p>";

$desc = $entity->description ? substr($entity->description, 0, 100) : "";
$info .= "<p>$desc</p>";

$info .= "<div>";
if ($by) $info .= elgg_echo('by') . " <a href=\"".$by->getURL()."\">{$by->name}</a> ";
$info .= " " . elgg_get_friendly_time($entity->time_created )."</div>";

echo elgg_view_listing($icon, $info);
?>