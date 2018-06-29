<?php

$name = elgg_extract('name', $vars, 'releases');
$release = elgg_extract('value', $vars);

$fields = [];
if (!$release instanceof \hypeJunction\Downloads\Release) {
	$release = new \hypeJunction\Downloads\Release();
} else {
	$fields[] = [
		'#html' => elgg_view_entity($release, [
			'full_view' => false,
			'item_view' => 'object/elements/chip',
		]),
	];
}

$id = "release-" . base_convert(mt_rand(), 10, 36);

$fields[] = [
	'#type' => 'file',
	'#label' => elgg_echo('field:object:download_release:file'),
	'#class' => 'elgg-col elgg-col-3of4',
	'name' => "{$name}[$id][file]",
	'value' => $release->exists(),
	'required' => !$release->exists(),
];

$fields[] = [
	'#type' => 'text',
	'#label' => elgg_echo('field:object:download_release:version'),
	'#class' => 'elgg-col elgg-col-1of4',
	'name' => "{$name}[$id][version]",
	'value' => $release->version ? : '0.0.0',
	'required' => true,
];

$fields[] = [
	'#type' => 'longtext',
	'#label' => elgg_echo('field:object:download_release:description'),
	'#class' => 'elgg-col elgg-col-1of1',
	'name' => "{$name}[$id][description]",
	'value' => $release->description,
	'rows' => 2,
	'visual' => false,
	'editor_type' => 'simple',
];

$fields[] = [
	'#type' => 'hidden',
	'name' => "{$name}[$id][guid]",
	'value' => $release->guid,
];

echo elgg_view_field([
	'#type' => 'fieldset',
	'#class' => 'downloads-input-release',
	'class' => 'elgg-grid',
	'fields' => $fields,
]);