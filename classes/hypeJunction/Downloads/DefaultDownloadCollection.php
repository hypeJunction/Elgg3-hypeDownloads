<?php

namespace hypeJunction\Downloads;

use hypeJunction\Lists\Collection;
use hypeJunction\Lists\Filters\All;
use hypeJunction\Lists\Filters\IsContainedByUsersGroups;
use hypeJunction\Lists\Filters\IsOwnedBy;
use hypeJunction\Lists\Filters\IsOwnedByFriendsOf;
use hypeJunction\Lists\SearchFields\CreatedBetween;
use hypeJunction\Lists\Sorters\Alpha;
use hypeJunction\Lists\Sorters\LastAction;
use hypeJunction\Lists\Sorters\LikesCount;
use hypeJunction\Lists\Sorters\ResponsesCount;
use hypeJunction\Lists\Sorters\TimeCreated;

class DefaultDownloadCollection extends Collection {

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return 'collection:object:download:all';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName() {
		return elgg_echo('collection:object:download');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getType() {
		return 'object';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSubtypes() {
		return 'download';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCollectionType() {
		return 'all';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getQueryOptions(array $options = []) {
		return array_merge([
			'types' => $this->getType(),
			'subtypes' => $this->getSubtypes(),
			'preload_owners' => true,
			'preload_containers' => true,
			'distinct' => true,
		], $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getURL() {
		return elgg_generate_url($this->getId());
	}

	/**
	 * {@inheritdoc}
	 */
	public function getListOptions(array $options = []) {
		return array_merge([
			'full_view' => false,
			'no_results' => elgg_echo('download:none'),
			'pagination_type' => 'infinite',
			'list_class' => 'post-list',
			'list_type' => get_input('list_type', 'gallery'),
			'gallery_class' => 'post-cards',
		], $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFilterOptions() {
		if (!elgg_is_logged_in()) {
			return [];
		}

		return [
			All::id() => All::class,
			IsOwnedBy::id() => IsOwnedBy::class,
			IsOwnedByFriendsOf::id() => IsOwnedByFriendsOf::class,
			IsContainedByUsersGroups::id() => IsContainedByUsersGroups::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSortOptions() {
		return [
			Alpha::id() => Alpha::class,
			TimeCreated::id() => TimeCreated::class,
			LastAction::id() => LastAction::class,
			LikesCount::id() => LikesCount::class,
			ResponsesCount::id() => ResponsesCount::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSearchOptions() {
		$fields = parent::getSearchOptions();

		$fields[] = CreatedBetween::class;

		return $fields;
	}
}