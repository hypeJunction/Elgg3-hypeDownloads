<?php

$value = elgg_extract('value', $vars, []);
unset($vars['value']);

$fields = '';

foreach ($value as $val) {
	if ($val instanceof \hypeJunction\Downloads\Release) {
		$params = $vars;
		$params['value'] = $val;
		$fields .= elgg_view('input/downloads/release', $params);
	}
}

//if (empty($fields)) {
//	$fields .= elgg_view('input/downloads/release', $vars);
//}

$input = elgg_format_element('div', [
	'class' => 'downloads-release-forms'
], $fields);

$input .= elgg_view('output/url', [
	'href' => 'javascript:',
	'data-view' => 'input/downloads/release',
	'data-query' => json_encode([
		'name' => elgg_extract('name', $vars),
	]),
	'text' => elgg_echo('add:object:download_release'),
	'class' => 'downloads-add-release-form',
	'icon' => 'plus',
]);

echo elgg_format_element('div', [
	'class' => 'downloads-input-releases',
], $input);

?>
<script>
	require(['input/downloads/releases']);
</script>

