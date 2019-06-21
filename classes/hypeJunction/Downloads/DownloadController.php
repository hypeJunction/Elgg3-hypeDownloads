<?php

namespace hypeJunction\Downloads;

use Elgg\EntityNotFoundException;
use Elgg\Request;
use hypeJunction\Downloads\Release;
use hypeJunction\Payments\Amount;

class DownloadController {

	/**
	 * @param Request $request
	 *
	 * @return \Elgg\Http\RedirectResponse
	 * @throws EntityNotFoundException
	 * @throws \DataFormatException
	 */
	public function __invoke(Request $request) {
		$file = $request->getEntityParam();

		if (!$file instanceof Release) {
			throw new EntityNotFoundException();
		}

		$file->setVolatileData('downloading', true);

		$user = elgg_get_logged_in_user_entity() ? : elgg_get_site_entity();

		$log = serialize([
			'user_guid' => $user->guid,
			'ip_address' => _elgg_services()->request->getClientIp(),
		]);

		$file->annotate('log:download', $log, ACCESS_PUBLIC, $user->guid);

		elgg_trigger_event('download', 'file', $file);

		return elgg_redirect_response($file->getDownloadURL());
	}
}