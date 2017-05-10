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

$entity = $vars['entity']->entity;
$by = $entity->getOwnerEntity();

$icon = elgg_view('graphics/icon', [
	'entity' => $entity,
	'size' => 'small',
]);

$controllinks = '';

if ($entity->canEdit()) {
	$controllinks .= elgg_view('output/url', [
		'confirm' => true,
		'text' => elgg_echo('delete'),
		'href' => "action/guidtool/delete?guid={$entity->guid}",
	]);
}

$name = elgg_view('output/url', [
	'text' => $entity->getDisplayName() ?: '(No title)',
	'href' => $entity->getURL(),
]);

$info_link = elgg_view('output/url', [
	'text' => "[GUID:{$entity->guid} " . get_class($entity) . " " . $entity->getSubtype() . ']',
	'href' => "admin/guidtool/view?guid={$entity->guid}",
]);

$body = "<h3>$name</h3> $info_link";

$metadata = elgg_view_menu('entity', array(
	'entity' => $entity,
	'handler' => $entity->getSubtype(),
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

if ($metadata) {
	$body .= $metadata;
}

if ($by) {
	$subtext = elgg_view('output/url', [
		'text' => $by->getDisplayName(),
		'href' => $by->getURL()
	]);

	$subtext .= ' ' . elgg_get_friendly_time($entity->time_created);
	$body .= "<div class=\"elgg-subtext\">$subtext</div>";
}

$body = "<div class=\"elgg-content\">$body</div>";

echo elgg_view('page/components/image_block', [
	'image' => $icon,
	'body' => $body,
]);