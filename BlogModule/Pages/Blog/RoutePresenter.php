<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Pages\Blog;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class RoutePresenter extends AbstractRoutePresenter
{

	/** @var ArticleRepository */
	private $repository;

	/** @var CategoryRepository */
	private $categoryRepository;


	/**
	 * @param ArticleRepository $repository
	 * @param CategoryRepository $categoryRepository
	 */
	public function inject(
		ArticleRepository $repository,
		CategoryRepository $categoryRepository
	)
	{
		$this->repository = $repository;
		$this->categoryRepository = $categoryRepository;
	}


	/**
	 * @return ArticleRepository
	 */
	protected function getRepository()
	{
		return $this->repository;
	}


	/**
	 * @return CategoryRepository
	 */
	public function getCategoryRepository()
	{
		return $this->categoryRepository;
	}


	/**
	 * @return \Doctrine\ORM\QueryBuilder
	 */
	protected function getQueryBuilder()
	{
		$qb = parent::getQueryBuilder();

		if ($this->extendedRoute instanceof AbstractCategoryEntity) {
			$qb
				->leftJoin('a.categories', 'cat')
				->andWhere('cat.id IN (:categories)')->setParameter('categories', $this->getCategoriesRecursively($this->extendedRoute));
		}

		return $qb;
	}


	/**
	 * @param AbstractCategoryEntity $category
	 * @return array
	 */
	private function getCategoriesRecursively(AbstractCategoryEntity $category)
	{
		$ids = array($category->id);

		foreach($category->children as $category) {
			$ids = array_merge($this->getCategoriesRecursively($category), $ids);
		}

		return $ids;
	}

}
