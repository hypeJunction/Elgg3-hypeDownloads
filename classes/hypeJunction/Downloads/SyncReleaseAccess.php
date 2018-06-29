<?php

namespace hypeJunction\Downloads;

use Elgg\Event;

class SyncReleaseAccess {

	/**
	 * Update release access
	 *
	 * @param Event $event Event
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function __invoke(Event $event) {

		$entity = $event->getObject();

		if (!$entity instanceof Download) {
			return null;
		}

		elgg_call(ELGG_IGNORE_ACCESS | ELGG_SHOW_DISABLED_ENTITIES, function() use ($entity) {
			$releases = elgg_get_entities([
				'type' => 'object',
				'subtype' => Release::SUBTYPE,
				'container_guid' => $entity->getGUID(),
				'wheres' => [function(\Elgg\Database\QueryBuilder $qb) use ($entity) {
					return $qb->compare('e.access_id', '!=', $entity->access_id, 'integer');
				}],
				'limit' => 0,
				'batch' => true,
				'batch_inc_offset' => false,
			]);

			foreach ($releases as $release) {
				$release->access_id = $entity->access_id;
				$release->save();
			}
		});
	}
}