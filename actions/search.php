<?php

admin_gatekeeper();

$guid = (int)get_input('guid');
$entity = get_entity($guid);

if (!$entity) {
	register_error("Entity with guid $guid not found");
	forward(REFERER);
}

forward("/admin/guidtool/view?guid=$guid");
