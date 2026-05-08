<?php

namespace hypeJunction\Downloads;

use Elgg\Event;
use Elgg\IntegrationTestCase;

/**
 * Tests that SetupContainerLogic correctly restricts container types for download_release objects.
 */
class ContainerLogicTest extends IntegrationTestCase {

	public function up(): void {}
	public function down(): void {}

	public function getPluginID(): string {
		return 'hypedownloads';
	}

	public function testReleaseMustBeContainedByDownload(): void {
		$user = $this->createUser();
		$download = $this->createObject(['subtype' => 'download', 'owner_guid' => $user->guid]);

		$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
		$event->method('getParam')->willReturnMap([
			['container', null, $user],
			['subtype', null, Release::SUBTYPE],
		]);

		$handler = new SetupContainerLogic();
		$result = $handler($event);

		$this->assertFalse($result, 'Non-Download container must be rejected for download_release');
	}

	public function testReleaseAllowedInsideDownload(): void {
		$user = $this->createUser();
		$download = $this->createObject(['subtype' => 'download', 'owner_guid' => $user->guid]);

		$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
		$event->method('getParam')->willReturnMap([
			['container', null, $download],
			['subtype', null, Release::SUBTYPE],
		]);

		$handler = new SetupContainerLogic();
		$result = $handler($event);

		$this->assertNull($result, 'Download container must be allowed for download_release');
	}

	public function testOtherSubtypesUnaffected(): void {
		$user = $this->createUser();

		$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
		$event->method('getParam')->willReturnMap([
			['container', null, $user],
			['subtype', null, 'blog'],
		]);

		$handler = new SetupContainerLogic();
		$result = $handler($event);

		$this->assertNull($result, 'Non-release subtypes must pass through unmodified');
	}
}
