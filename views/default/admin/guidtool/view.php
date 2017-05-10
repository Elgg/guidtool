<?php
$entity = get_entity(get_input('guid'));

if (!$entity instanceof \ElggEntity) {
	forward('/', 404);
}

elgg_register_plugin_hook_handler('prepare', 'menu:page', function ($h, $t, $menus, $params) {
	foreach ($menus as $menu) {
		foreach ($menu as $item) {
			if ($item->getName() == 'guidtool') {
				$item->setSelected(true);

				foreach ($item->getChildren() as $child) {
					if ($child->getName() == 'guidtool:search') {
						$child->setSelected(true);
					}
				}
			}
		}
	}
});

echo elgg_view("guidtool/profile", [
	'entity_guid' => $entity->getGUID(),
]);
