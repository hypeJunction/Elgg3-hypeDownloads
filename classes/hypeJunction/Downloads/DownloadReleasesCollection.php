<?php

namespace hypeJunction\Downloads;

use Elgg\Database\Clauses\OrderByClause;
use Elgg\Views\TableColumn\ViewColumn;
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

class DownloadReleasesCollection extends Collection {

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return 'collection:object:download_release';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName() {
		return elgg_echo('collection:object:download_release');
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
		return 'download_release';
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
		$options['container_guid'] = (int) $this->target->guid;
		return $options;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getURL() {
		return elgg_generate_url($this->getId(), [
			'guid' => (int) $this->target->guid,
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getListOptions(array $options = []) {
		return array_merge([
			'full_view' => false,
			'no_results' => elgg_echo('downloads:no_results'),
			'columns' => [
				new ViewColumn('object/download_release/columns/icon'),
				new ViewColumn('object/download_release/columns/version'),
				new ViewColumn('object/download_release/columns/release_date'),
				//new ViewColumn('object/download_release/columns/release_notes'),
				new ViewColumn('object/download_release/columns/menu'),
			],
			'list_class' => 'post-list',
			'gallery_class' => 'post-cards',
			'table_class' => 'post-table',
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