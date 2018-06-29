<?php

/**
 * Digital products shop
 *
 * @author Ismayil Khayredinov <info@hypejunction.com>
 */
require __DIR__ . '/autoloader.php';

return function () {
	elgg_register_event_handler('init', 'system', function () {

		elgg_register_collection('collection:object:download:all', \hypeJunction\Downloads\DefaultDownloadCollection::class);
		elgg_register_collection('collection:object:download:owner', \hypeJunction\Downloads\OwnedDownloadCollection::class);
		elgg_register_collection('collection:object:download:friends', \hypeJunction\Downloads\FriendsDownloadCollection::class);
		elgg_register_collection('collection:object:download:group', \hypeJunction\Downloads\GroupDownloadCollection::class);

		elgg_register_collection('collection:object:download_release', \hypeJunction\Downloads\DownloadReleasesCollection::class);

		elgg_register_plugin_hook_handler('container_logic_check', 'object', \hypeJunction\Downloads\SetupContainerLogic::class);

		elgg_register_event_handler('update:after', 'object', \hypeJunction\Downloads\SyncReleaseAccess::class, 600);

		elgg_register_plugin_hook_handler('uses:cover', 'object:download', [\Elgg\Values::class, 'getTrue']);
		elgg_register_plugin_hook_handler('uses:icon', 'object:download', [\Elgg\Values::class, 'getTrue']);
		elgg_register_plugin_hook_handler('uses:river', 'object:download', [\Elgg\Values::class, 'getFalse']);
		elgg_register_plugin_hook_handler('likes:is_likable', 'object:download', [\Elgg\Values::class, 'getTrue']);

		elgg_register_plugin_hook_handler('uses:river', 'object:download_release', [\Elgg\Values::class, 'getTrue']);
		elgg_register_plugin_hook_handler('uses:comments', 'object:download_release', [\Elgg\Values::class, 'getFalse']);
		elgg_register_plugin_hook_handler('likes:is_likable', 'object:download_release', [\Elgg\Values::class, 'getFalse']);

		elgg_register_plugin_hook_handler('fields', 'object:download', \hypeJunction\Downloads\SetupDownloadForm::class);

		elgg_register_plugin_hook_handler('register', 'menu:entity', \hypeJunction\Downloads\EntityMenu::class);

		elgg_register_ajax_view('input/downloads/release');

		elgg_extend_view('elgg.css', 'input/downloads/releases.css');

		elgg_register_menu_item('site', [
			'name' => 'downloads',
			'text' => elgg_echo('collection:object:download'),
			'href' => elgg_generate_url('collection:object:download:all'),
		]);
	});
};