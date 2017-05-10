<?php

echo elgg_view_input('autocomplete', [
	'name' => 'guid',
	'label' => 'Entity GUID or search:',
	'help' => 'Enter a full entity GUID or type the first few letters of the title and select an entity from the popup'
]);

echo elgg_view_input('submit');