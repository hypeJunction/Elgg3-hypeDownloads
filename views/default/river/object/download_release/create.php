<?php

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$subject = $item->getSubjectEntity();
if (!$subject instanceof ElggEntity) {
	return;
}

$object = $item->getObjectEntity();
if (!$object instanceof \hypeJunction\Downloads\Release) {
	return;
}

$download = $object->getContainerEntity();
if (!$download instanceof \hypeJunction\Downloads\Download) {
	return;
}

$subject_link = elgg_view('output/url', [
	'href' => $subject->getURL(),
	'text' => $subject->getDisplayName(),
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
]);


$object_link = elgg_view('output/url', [
	'href' => $object->getURL(),
	'text' => $object->version,
	'class' => 'elgg-river-object',
	'is_trusted' => true,
]);

$download_link = elgg_view('output/url', [
	'href' => $download->getURL(),
	'text' => $download->getDisplayName(),
	'class' => 'elgg-river-object',
	'is_trusted' => true,
]);

$group_string = '';
$container = $download->getContainerEntity();
if ($container instanceof ElggGroup && $container->guid != elgg_get_page_owner_guid()) {
	$group_link = elgg_view('output/url', [
		'href' => $container->getURL(),
		'text' => $container->getDisplayName(),
		'is_trusted' => true,
	]);
	$group_string = elgg_echo('river:ingroup', [$group_link]);
}


$summary = elgg_echo('river:create:object:download_release', [$subject_link, $object_link, $download_link]);

$vars['summary'] = trim("$summary $group_string");

$vars['attachments'] = elgg_view('river/elements/attachment', [
	'entity' => $download,
	'item' => $item,
]);

echo elgg_view('river/elements/layout', $vars);

