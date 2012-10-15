<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Presenters;

use Venne;
use DoctrineModule\Repositories\BaseRepository;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class DefaultPresenter extends \CmsModule\Content\Presenters\PagePresenter
{
	/**
	 * @var BaseRepository
	 */
	private $blogRepository;


	public function __construct(BaseRepository $blogRepository)
	{
		parent::__construct();
		$this->blogRepository = $blogRepository;
	}


	public function getItems()
	{
		$query = $this->getQueryBuilder();
		$query->setMaxResults($this->page->itemsPerPage);
		$query->setFirstResult($this['vp']->getPaginator()->getOffset());
		$query->orderBy('a.created', 'DESC');

		return $query->getQuery()->getResult();
	}


	/**
	 * @return \Doctrine\ORM\QueryBuilder
	 */
	protected function getQueryBuilder()
	{
		return $this->blogRepository->createQueryBuilder("a")
			->andWhere('a.page = :page')->setParameter('page', $this->page->id);
	}


	protected function createComponentVp()
	{
		$vp = new \CmsModule\Components\VisualPaginator;
		$pg = $vp->getPaginator();
		$pg->setItemsPerPage($this->page->itemsPerPage);
		$pg->setItemCount($this->getQueryBuilder()->select("COUNT(a.id)")->getQuery()->getSingleScalarResult());
		return $vp;
	}
}