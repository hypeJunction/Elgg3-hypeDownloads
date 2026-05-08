<?php

namespace hypeJunction\Downloads;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {

	public function load(): void {
		$autoloader = dirname(__DIR__, 3) . '/autoloader.php';
		if (file_exists($autoloader)) {
			require_once $autoloader;
		}
	}

	public function init(): void {
		if (function_exists('elgg_register_collection')) {
			elgg_register_collection('collection:object:download:all', DefaultDownloadCollection::class);
			elgg_register_collection('collection:object:download:owner', OwnedDownloadCollection::class);
			elgg_register_collection('collection:object:download:friends', FriendsDownloadCollection::class);
			elgg_register_collection('collection:object:download:group', GroupDownloadCollection::class);
			elgg_register_collection('collection:object:download_release', DownloadReleasesCollection::class);
		}

		elgg_register_event_handler('container_logic_check', 'object', SetupContainerLogic::class);
		elgg_register_event_handler('update:after', 'object', SyncReleaseAccess::class, 600);

		elgg_register_event_handler('uses:cover', 'object:download', [\Elgg\Values::class, 'getTrue']);
		elgg_register_event_handler('uses:icon', 'object:download', [\Elgg\Values::class, 'getTrue']);
		elgg_register_event_handler('uses:river', 'object:download', [\Elgg\Values::class, 'getFalse']);
		elgg_register_event_handler('likes:is_likable', 'object:download', [\Elgg\Values::class, 'getTrue']);

		elgg_register_event_handler('uses:river', 'object:download_release', [\Elgg\Values::class, 'getTrue']);
		elgg_register_event_handler('uses:comments', 'object:download_release', [\Elgg\Values::class, 'getFalse']);
		elgg_register_event_handler('likes:is_likable', 'object:download_release', [\Elgg\Values::class, 'getFalse']);

		elgg_register_event_handler('fields', 'object:download', SetupDownloadForm::class);

		elgg_register_event_handler('register', 'menu:entity', EntityMenu::class);
		elgg_register_event_handler('register', 'menu:social', SocialMenu::class);

		elgg_register_event_handler('download:url', 'file', SetDownloadUrl::class);

		elgg_register_ajax_view('input/downloads/release');

		elgg_extend_view('elgg.css', 'input/downloads/releases.css');

		elgg_register_menu_item('site', [
			'name' => 'downloads',
			'text' => elgg_echo('collection:object:download'),
			'href' => elgg_generate_url('collection:object:download:all'),
		]);

		if (class_exists(\hypeJunction\Stash\Stash::class)) {
			\hypeJunction\Stash\Stash::instance()->register(new DownloadsCounter());
		}
	}
}
