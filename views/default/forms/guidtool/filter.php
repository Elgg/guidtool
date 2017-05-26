<?php
/**
 * Shows a type:subtype filter for listing entities
 */

$pf = elgg_get_config('dbprefix');
$q = "SELECT * FROM {$pf}entity_subtypes ORDER BY type, subtype";
$subtypes = _elgg_services()->db->getData($q);

$subtype_opts = [
	'object:' => 'object',
	'user:' => 'user',
	'group:' => 'group',
	'site:' => 'site',
];

foreach ($subtypes as $subtype) {
	$class = $subtype->class ? " ({$subtype->class})" : '';

	$subtype_opts["{$subtype->type}:{$subtype->subtype}"] = "{$subtype->type}:{$subtype->subtype}$class";
}

$subtype_input = elgg_view_input('dropdown', [
	'label' => elgg_echo('guidtool:type_and_subtype'),
	'name' => 'subtypes[]',
	'options_values' => $subtype_opts,
	'multiple' => true,
	'value' => elgg_extract('subtypes', $vars),
]);

$container_input = elgg_view_input('autocomplete', [
	'name' => 'container_guid',
	'label' => 'Container GUID / Entity:',
    'value' => elgg_extract('container_guid', $vars)
]);

$owner_input = elgg_view_input('autocomplete', [
	'name' => 'owner_guid',
	'label' => 'Owner GUID / Entity:',
	'value' => elgg_extract('owner_guid', $vars)
]);

$submit = elgg_view("input/submit", [
	'value' => elgg_echo('guidtool:filter'),
]);

$reset = elgg_view('output/url', [
	'href' => '/admin/guidtool/list',
	'text' => elgg_echo('guidtool:clear'),
	'class' => 'elgg-button elgg-button-submit',
]);

?>

<fieldset>
    <div class="elgg-col elgg-col-1of3">
		<?= $subtype_input ?>
    </div>

    <div class="elgg-col elgg-col-1of3">
		<?= $owner_input ?>
    </div>

    <div class="elgg-col elgg-col-1of3">
		<?= $container_input ?>
    </div>
</fieldset>

<?= $submit . $reset ?>
