<?php

$title = elgg_echo("guidtool");
$body = elgg_view_title($title);
$offset = (int) max(get_input('offset', 0), 0);
$limit = (int) max(get_input('limit', elgg_get_config('default_limit')), 0);

elgg_push_context('search');

$entities = elgg_get_entities([
	'offset' => $offset,
	'limit' => $limit
]);

$count = elgg_get_entities([
	'offset' => $offset,
	'limit' => $limit,
	'count' => true,
]);

$wrapped_entries = [];

foreach ($entities as $e) {
	$tmp = new ElggObject();
	$tmp->subtype = 'guidtoolwrapper';
	$tmp->entity = $e;
	$wrapped_entries[] = $tmp;
}

$body .= elgg_view_entity_list($wrapped_entries, [
	'count' => $count,
	'offset' => $offset,
	'limit' => $limit,
	'full_view' => false,
]);

elgg_pop_context();

echo $body;
