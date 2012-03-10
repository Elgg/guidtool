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

$format = elgg_extract('format', $vars, 'opendd');

$entity_guid = get_input('entity_guid');

$url = elgg_get_site_url();
	
?>
<div id="export">
<?php echo elgg_view('output/text', array(
    // @todo use a view to populate this. This will never work, right?
    'value' => htmlspecialchars(file_get_contents("{$url}export/$format/$entity_guid/"), ENT_QUOTES, 'UTF-8')
)); ?>
</div>