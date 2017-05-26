<?php
/**
 * Override to update for latest API
 *
 * Elgg Entity export.
 * Displays an entity using the current view.
 *
 * @package    Elgg
 * @subpackage Core
 * @deprecated 1.9
 */

$entity = $vars['entity'];
if (!$entity) {
	throw new InvalidParameterException("No entity found, it either doesn't exist or you don't have access to it.");
}
$options = [
	'guid' => $entity->guid,
	'limit' => 0,
];

$serialized = $entity->toObject();
$serialized->php_class = get_class($entity);

$metadata = elgg_get_metadata($options);
$annotations = elgg_get_annotations($options);
$relationships = get_entity_relationships($entity->guid);
$inv_relationships = get_entity_relationships($entity->guid, true);


?>
    <div>
        <h2 class="pbm ptl"><?php echo elgg_echo('Entity'); ?></h2>

        <table class="elgg-table">
			<?php foreach ($serialized as $k => $v) {
				switch ($k) {
					case 'subtype':
						if (!$v) {
							$v = '(None)';
						}

					case 'url':
						if ($v) {
							$v = elgg_view("output/url", [
								'href' => $v,
							]);
						}
						break;

					case 'owner_guid':
					case 'container_guid':
					case 'site_guid':
						$tmp = get_entity($v);

						if ($tmp instanceof \ElggEntity) {
							$v .= ' ' . elgg_view('output/url', [
									'href' => "/admin/guidtool/view?guid=$v",
									'text' => '(' . $tmp->getDisplayName() . ')',
								]);
						}
						break;


					case 'title':
					case 'description':
					case 'name':
						$v = htmlspecialchars($v);
						break;

					case 'read_access':
					case 'write_access':

						$acl = get_access_collection($v);
						if ($acl) {
							$v .= " ({$acl->name})";
						}

						break;

					case 'tags':
						$v = implode(', ', $v);
						break;

				}
				?>
                <tr>
                    <td><label><?php echo $k; ?></label></td>
                    <td><?php echo $v; ?></td>
                </tr>
			<?php } ?>
        </table>
    </div>

<?php if ($metadata) { ?>
    <div id="metadata" class="mtm">
        <h2 class="pbm ptl"><?php echo elgg_echo('metadata'); ?></h2>
        <table class="elgg-table">
			<?php foreach ($metadata as $m) { ?>
                <tr>
                    <td><label><?php echo $m->name; ?></label></td>
                    <td><?php echo $m->value; ?></td>
                </tr>
			<?php } ?>
        </table>
    </div>
<?php } ?>

<?php if ($annotations) { ?>
    <div id="annotations" class="mtm">
        <h2 class="pbm ptl"><?php echo elgg_echo('annotations'); ?></h2>
        <table class="elgg-table">
			<?php
			foreach ($annotations as $a) { ?>
                <tr>
                    <td><label><?php echo $a->name; ?></label></td>
                    <td><?php echo $a->value; ?></td>
                </tr>
			<?php } ?>
        </table>
    </div>
<?php } ?>

<?php if ($relationships) { ?>
    <div id="relationship" class="mtm">
        <h2 class="pbm ptl">Relationships (guid_one = <?php echo $entity->guid; ?>)</h2>
        <table class="elgg-table">
			<?php foreach ($relationships as $r) { ?>
                <tr>
                    <td><label><?php echo $r->relationship; ?></label></td>
                    <td><?php
						echo $r->guid_two;

						$tmp = get_entity($r->guid_two);
						if ($tmp instanceof \ElggEntity) {
							echo ' (';
							echo $tmp->getType() . ':' . $tmp->getSubtype() . ' ';
							echo elgg_view('output/url', [
								'href' => '/admin/guidtool/view?guid=' . $r->guid_two,
								'text' => $tmp->getDisplayName(),
							]);
							echo ')';
						}

						?></td>
                </tr>
			<?php } ?>
        </table>
    </div>
<?php } ?>


<?php if ($inv_relationships) { ?>
    <div id="inv_relationship" class="mtm">
        <h2 class="pbm ptl">Inverse Relationships (guid_two = <?php echo $entity->guid; ?>)</h2>
        <table class="elgg-table">
			<?php foreach ($inv_relationships as $r) { ?>
                <tr>
                    <td><label><?php echo $r->relationship; ?></label></td>
                    <td><?php
						echo $r->guid_one;

						$tmp = get_entity($r->guid_one);
						if ($tmp instanceof \ElggEntity) {
							echo ' (';
							echo $tmp->getType() . ':' . $tmp->getSubtype() . ' ';
							echo elgg_view('output/url', [
								'href' => '/admin/guidtool/view?guid=' . $r->guid_one,
								'text' => $tmp->getDisplayName(),
							]);
							echo ')';
						}

						?></td>
                </tr>
			<?php } ?>
        </table>
    </div>
<?php }