<?php

namespace hypeJunction\Downloads;

use Elgg\Event;

class SetDownloadUrl {

	public function __invoke(Event $event) {

		$file = $event->getEntityParam();

		if (!$file instanceof Release) {
			return null;
		}

		if ($file->getVolatileData('downloading') || $file->getVolatileData('allow_download')) {
			return null;
		}

		$url = elgg_generate_url('download:object:download_release', [
			'guid' => $file->guid,
		]);

		return elgg_normalize_site_url($url);
	}
}