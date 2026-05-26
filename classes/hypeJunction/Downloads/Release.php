<?php

namespace hypeJunction\Downloads;

/**
 * @property string $version
 */
class Release extends \ElggFile {

	const SUBTYPE = 'download_release';

	/**
	 * {@inheritdoc}
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName(): string {
		$download = $this->getContainerEntity();
		if ($download) {
			return implode(' ', array_filter([$download->getDisplayName(), $this->version]));
		}

		return parent::getDisplayName();
	}

	/**
	 * Get download object
	 * @return Download
	 */
	public function getPackage() {
		$package = $this->getContainerEntity();
		/* @var $package Download */

		return $package;
	}

	/**
	 * {@inheritdoc}
	 */
	public function canDownload(int $user_guid = 0, bool $default = true): bool {
		$default = $this->getPackage()->canDownload($user_guid, $default);

		return \_elgg_services()->userCapabilities->canDownload($this, $user_guid, $default);
	}
}
