<?php
/**
 * Part of Admin project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Merlin\Admin\Model;

use Lyrasoft\Merlin\Admin\Table\Table;
use Phoenix\Model\ListModel;
use Phoenix\Model\Filter\FilterHelperInterface;
use Windwalker\Query\Query;

/**
 * The ArticlesModel class.
 * 
 * @since  1.0
 */
class ArticlesModel extends ListModel
{
	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = 'articles';

	/**
	 * Property allowFields.
	 *
	 * @var  array
	 */
	protected $allowFields = array();

	/**
	 * Property fieldMapping.
	 *
	 * @var  array
	 */
	protected $fieldMapping = array();

	/**
	 * configureTables
	 *
	 * @return  void
	 */
	protected function configureTables()
	{
		$this->addTable('article', Table::ARTICLES);
	}

	/**
	 * The prepare getQuery hook
	 *
	 * @param Query $query The db query object.
	 *
	 * @return  void
	 */
	protected function prepareGetQuery(Query $query)
	{
		// Add your logic
	}

	/**
	 * The post getQuery object.
	 *
	 * @param Query $query The db query object.
	 *
	 * @return  void
	 */
	protected function postGetQuery(Query $query)
	{
		// Add your logic
	}

	/**
	 * Configure the filter handlers.
	 *
	 * Example:
	 * ``` php
	 * $filterHelper->setHandler(
	 *     'article.date',
	 *     function($query, $field, $value)
	 *     {
	 *         $query->where($field . ' >= ' . $value);
	 *     }
	 * );
	 * ```
	 *
	 * @param FilterHelperInterface $filterHelper The filter helper object.
	 *
	 * @return  void
	 */
	protected function configureFilters(FilterHelperInterface $filterHelper)
	{
		// Configure filters
	}

	/**
	 * Configure the search handlers.
	 *
	 * Example:
	 * ``` php
	 * $searchHelper->setHandler(
	 *     'article.title',
	 *     function($query, $field, $value)
	 *     {
	 *         return $query->quoteName($field) . ' LIKE ' . $query->quote('%' . $value . '%');
	 *     }
	 * );
	 * ```
	 *
	 * @param FilterHelperInterface $searchHelper The search helper object.
	 *
	 * @return  void
	 */
	protected function configureSearches(FilterHelperInterface $searchHelper)
	{
		// Configure searches
	}
}
