<?php

namespace hypeJunction\Downloads;

use Elgg\Event;
use Elgg\EventsService;
use Elgg\PluginHooksService;
use ElggComment;
use hypeJunction\Downloads\Download;
use hypeJunction\Stash\Preloader;
use hypeJunction\Stash\Stash;

class DownloadsCounter implements Preloader {

	const PROPERTY = 'release_downloads_total';

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return self::PROPERTY;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPriority() {
		return 500;
	}

	/**
	 * {@inheritdoc}
	 */
	public function up(Stash $stash, EventsService $events, PluginHooksService $hooks) {
		$callback = function (Event $event) use ($stash) {
			elgg_call(
				ELGG_IGNORE_ACCESS,
				function () use ($event, $stash) {
					$annotation = $event->getObject();
					if (!$annotation instanceof \ElggAnnotation) {
						return;
					}

					if ($annotation->name !== 'log:download') {
						return;
					}

					$entity = $annotation->getEntity();
					if (!$entity) {
						return;
					}

					$container = $entity->getContainerEntity();
					if (!$container) {
						return;
					}

					/* @todo Once annotation delete:after event exists, use get() with force reload */
					$stash->reset(self::PROPERTY, $container);
				}
			);
		};

		$events->registerHandler('create:after', 'annotation', $callback);
		$events->registerHandler('delete', 'annotation', $callback);
	}

	/**
	 * {@inheritdoc}
	 */
	public function preload(\ElggEntity $entity) {
		return elgg_call(
			ELGG_IGNORE_ACCESS,
			function () use ($entity) {
				if ($entity instanceof Download) {
					return $entity->countDownloads();
				}

				return 0;
			}
		);
	}
}