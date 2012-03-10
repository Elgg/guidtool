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

$entity = $vars['entity']->entity;
$by = $entity->getOwnerEntity();

$icon = elgg_view('graphics/icon', array(
    'entity' => $entity,
    'size' => 'small',
));

$controllinks = elgg_view('output/url', array(
    'text' => elgg_echo('export'),
    'href' => "guidtool/export/{$entity->guid}/",
    'is_trusted' => true,
)) . ' ';
if ($entity->canEdit()) {
    $controllinks .= elgg_view('output/confirmlink', array(
        'text' => elgg_echo('delete'),
        'href' => "action/guidtool/delete?guid={$entity->guid}",
    ));
}
$strap = $entity->title ? $entity->title : $entity->name;
$info_link = elgg_view('output/url', array(
    'text' => "[GUID:{$entity->guid}] " . get_class($entity) . " " . get_subtype_from_id($entity->subtype),
    'href' => "guidtool/view/{$entity->guid}/",
));
$info = "<p><b>$info_link</b> $strap</p> <div>";
if ($by) {
    $info .= elgg_echo('by') . " <a href=\"".$by->getURL()."\">{$by->name}</a> ";
}
$info .= " " . elgg_get_friendly_time($entity->time_created ) . " [$controllinks]</div>";

echo elgg_view('page/components/image_block', array('image' => $icon, 'body' => $info));