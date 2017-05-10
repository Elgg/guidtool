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
$metadata = elgg_get_metadata($options);
$annotations = elgg_get_annotations($options);
$relationships = get_entity_relationships($entity->guid);

?>
	<div>
		<h2><?php echo elgg_echo('Entity'); ?></h2>

        <p class="margin-none"><b>URL: </b><?php echo elgg_view('output/url', ['href' => $entity->getURL()]); ?></p>
        <p class="margin-none"><b>PHP Class: </b><?php echo get_class($entity); ?></p>

        <?php foreach ($entity->toObject() as $k => $v) { ?>
			<p class="margin-none"><b><?php echo $k; ?>: </b><?php echo strip_tags($v); ?></p>
			<?php
		}
		?>
	</div>

<?php if ($metadata) { ?>
	<div id="metadata" class="mtm">
		<h2><?php echo elgg_echo('metadata'); ?></h2>
		<?php
		foreach ($metadata as $m) {
			?>
			<p class="margin-none"><b><?php echo $m->name; ?>: </b><?php echo $m->value; ?></p>
			<?php
		}
		?>

	</div>
<?php } ?>

<?php if ($annotations) { ?>
	<div id="annotations" class="mtm">
		<h2><?php echo elgg_echo('annotations'); ?></h2>
		<?php
		foreach ($annotations as $a) {
			?>
			<table>
				<p class="margin-none"><b><?php echo $a->name; ?>: </b><?php echo $a->value; ?></p>
			</table>
			<?php
		}
		?>
	</div>
<?php } ?>

<?php if ($relationships) { ?>
	<div id="relationship" class="mtm">
		<h2><?php echo elgg_echo('relationships'); ?></h2>
		<?php
		foreach ($relationships as $r) {
			?>
			<table>
				<p class="margin-none"><b><?php echo $r->relationship; ?>: </b><?php echo $r->guid_two; ?></p>
			</table>
			<?php
		}
		?>
	</div>
<?php }