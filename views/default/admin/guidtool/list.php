<?php

$title = elgg_echo("guidtool");
$body = elgg_view_title($title);
$offset = (int)max(get_input('offset', 0), 0);
$limit = (int)max(get_input('limit', elgg_get_config('default_limit')), 0);

$owner_guid = get_input('owner_guid');
$vars['owner_guid'] = $owner_guid;

$container_guid = get_input('container_guid');
$vars['container_guid'] = $container_guid;

$subtypes = get_input('subtypes', []);
$vars['subtypes'] = $subtypes;

elgg_push_context('search');

$options = [
	'offset' => $offset,
	'limit' => $limit,
];

foreach ($subtypes as $info) {
	list($type, $subtype) = explode(':', $info);

	if ($type && $subtype) {
		if (!isset($options['type_subtype_pairs'])) {
			$options['type_subtype_pairs'] = [];
		}

		if (!isset($options['type_subtype_pairs'][$type])) {
			$options['type_subtype_pairs'][$type] = [];
		}

		$options['type_subtype_pairs'][$type][] = $subtype;
	} else if ($type) {
		if (!isset($options['types'])) {
			$options['types'] = [];
		}

		$options['types'][] = $type;
	}
}

if ($container_guid) {
	$options['container_guid'] = $container_guid;
}

if ($owner_guid) {
	$options['owner_guid'] = $owner_guid;
}

$entities = elgg_get_entities($options);

$options['count'] = true;
$count = elgg_get_entities($options);
unset($options['count']);

$wrapped_entries = [];

foreach ($entities as $e) {
	$tmp = new ElggObject();
	$tmp->subtype = 'guidtoolwrapper';
	$tmp->entity = $e;
	$wrapped_entries[] = $tmp;
}


$filter = elgg_view_form("guidtool/filter", [
	'action' => '/admin/guidtool/list',
	'method' => 'GET',
	"is_action" => false,
],
	$vars
);

$ege_call = 'elgg_get_entities(' . var_export($options, true) . ')';

$filter .= elgg_format_element('pre', [], $ege_call);

// show by default if filtered
// we only set the offset and limit, so anything else means filtering
$class = count($options) > 2 ? '' : 'hidden';

$body = elgg_view('output/url', [
	'href' => '#filter',
	'rel' => 'toggle',
	'text' => 'Show Filter',
	'class' => "elgg-button elgg-button-submit",
]);

$body .= elgg_format_element('fieldset', ['id' => 'filter', 'class' => $class], $filter);

$body .= elgg_view_entity_list($wrapped_entries, [
	'count' => $count,
	'offset' => $offset,
	'limit' => $limit,
	'full_view' => false,
]);

elgg_pop_context();

echo $body;
