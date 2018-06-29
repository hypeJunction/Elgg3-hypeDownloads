<?php

namespace hypeJunction\Downloads;

use hypeJunction\Lists\Collection;

class Download extends \ElggObject {

	const SUBTYPE = 'download';

	/**
	 * {@inheritdoc}
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 * Get download releases
	 *
	 * @param array $options ege* options
	 * @param array $params  collection parameters
	 *
	 * @return Collection
	 */
	public function getReleases(array $params = []) {
		$collection = elgg_get_collection('collection:object:download_release', $this, $params);

		return $collection;
	}

	/**
	 * Get release by version
	 *
	 * @param string $version Version
	 *
	 * @return Release|null
	 */
	public function getRelease($version) {
		$releases = elgg_get_entities([
			'types' => 'object',
			'subtypes' => Release::SUBTYPE,
			'container_guids' => (int) $this->guid,
			'metadata_name_value_pairs' => [
				'version' => $version,
			],
		]);

		return $releases ? $releases[0] : null;
	}
}
