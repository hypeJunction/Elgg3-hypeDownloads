<?php

namespace hypeJunction\Downloads;

use Elgg\Hook;

class SetDownloadUrl {

	/**
	 * Rewrite download URL
	 *
	 * @param Hook $hook Hook
	 *
	 * @return bool
	 */
	public function __invoke(Hook $hook) {

		$file = $hook->getEntityParam();

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