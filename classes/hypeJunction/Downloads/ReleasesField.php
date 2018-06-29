<?php

namespace hypeJunction\Downloads;

use Elgg\Request;
use ElggEntity;
use hypeJunction\Fields\Field;
use hypeJunction\Post\River;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\ParameterBag;

class ReleasesField extends Field {

	/**
	 * {@inheritdoc}
	 */
	public function raw(Request $request, ElggEntity $entity) {
		return [
			'files' => elgg_get_uploaded_files($this->name),
			'meta' => $request->getParam($this->name),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function save(ElggEntity $entity, ParameterBag $parameters) {
		/* @var $entity Download */

		$value = $parameters->get($this->name);

		$releases = elgg_extract('meta', $value);
		$uploads = elgg_extract('files', $value);

		$keys = array_keys($releases);

		foreach ($keys as $key) {

			$upload = $uploads[$key]['file'];

			$guid = $releases[$key]['guid'];

			if ($guid) {
				$release = get_entity($guid);
				$add_to_river = false;
			} else {
				$release = new Release();
				$release->container_guid = $entity->guid;
				$add_to_river = true;
			}

			$release->version = $releases[$key]['version'];
			$release->description = $releases[$key]['description'];
			$release->access_id = $entity->access_id;

			if ($upload instanceof UploadedFile && $upload->isValid()) {
				$release->acceptUploadedFile($upload);
			}

			if ($release->save()) {
				$release->saveIconFromElggFile($release);
			}

			$release->save();

			if ($add_to_river) {
				$river = new River();
				$river->add($release);
			}
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function retrieve(ElggEntity $entity) {
		/* @var $entity Download */

		return $entity->getReleases()->getList()->get(0);
	}
}