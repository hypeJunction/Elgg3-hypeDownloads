<?php

namespace hypeJunction\Downloads;

use hypeJunction\Lists\Collection;
use hypeJunction\Stash\Stash;

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

	/**
	 * Get latest release
	 * @return Release|null
	 */
	public function getLastRelease() {
		$releases = $this->getReleases()->getList()->get(0);

		usort($releases, function ($a, $b) {
			return version_compare($b->version, $a->version);
		});

		return $releases[0];
	}

	/**
	 * Check if user has permissions do download releases of this package
	 *
	 * @param int  $user_guid User guid
	 * @param bool $default   Default permission
	 *
	 * @return bool
	 */
	public function canDownload($user_guid = 0, $default = true) {
		if (!$user_guid) {
			$user_guid = elgg_get_logged_in_user_guid();
		}

		$user = get_entity($user_guid);

		return elgg_trigger_plugin_hook('permissions_check:download', 'object:download', [
			'user' => $user,
			'entity' => $this,
		], $default);
	}

	/**
	 * Count downloads of all releases
	 * @return int
	 */
	public function countDownloads() {
		$releases = $this->getReleases()->getList()->get(0);
		$count = 0;

		foreach ($releases as $release) {
			$count += $release->countAnnotations('log:download');
		}

		return $count;
	}

	/**
	 * Retrieve downloads count from cache
	 * @return int
	 */
	public function getDownloadsCount() {
		return Stash::instance()->get(DownloadsCounter::PROPERTY, $this);
	}
}
