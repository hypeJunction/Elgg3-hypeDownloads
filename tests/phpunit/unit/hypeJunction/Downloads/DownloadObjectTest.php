<?php

namespace hypeJunction\Downloads;

use Elgg\Event;
use Elgg\Plugins\PluginTesting;
use Elgg\UnitTestCase;
use Elgg\Values;

class DownloadObjectTest extends UnitTestCase {

	use PluginTesting;

	public function up() {
		$this->startPlugin();
	}

	public function down() {}

	public function testCanOverrideDownloadPermissions() {

		$download = $this->createObject([
			'subtype' => 'download',
		]);
		/* @var $download \hypeJunction\Downloads\Download */

		$release = $this->createObject([
			'subtype' => 'download_release',
			'container_guid' => $download->guid,
		]);
		/* @var $release \hypeJunction\Downloads\Release */

		$this->assertTrue($download->canDownload());
		$this->assertTrue($release->canDownload());

		$this->registerTestingEvent('permissions_check:download', 'object:download', [Values::class, 'getFalse']);

		$this->assertFalse($download->canDownload());
		$this->assertFalse($release->canDownload());

		$this->registerTestingEvent('permissions_check:download', 'file', function(Event $event) use ($release) {
			if ($event->getEntityParam()->guid == $release->guid) {
				return true;
			}

			return null;
		});

		$this->assertFalse($download->canDownload());
		$this->assertTrue($release->canDownload());
	}
}
