<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule;

use Venne;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 *
 */
class ListPresenter extends \CoreModule\Presenters\PagePresenter {
    
	/**
	 * @var \DoctrineModule\ORM\BaseRepository
	 */
	private $articleRepository;
	
	public function __construct(\DoctrineModule\ORM\BaseRepository $articleRepository)
	{
		parent::__construct();
		$this->articleRepository = $articleRepository;
	}

	public function actionDefault()
	{
		$this->template->items = (array)$this->getItems();
	}
	
	protected function getItems()
	{
		$query = $this->getQueryBuilder();
		$query->setMaxResults($this->page->itemsPerPage);
		$query->setFirstResult($this['vp']->getPaginator()->getOffset());
		
		return $query->getQuery()->getResult();
	}
	
	
	/**
	 * @return \Doctrine\ORM\QueryBuilder 
	 */
	protected function getQueryBuilder()
	{
		$query = $this->articleRepository->createQueryBuilder("a")
				->leftJoin("a.categories", "p")
				->orderBy("a.created", "DESC");
		
		$i = false;
		foreach ($this->page->categories as $category) {
			if (!$i) {
				$i = true;
				$query = $query->where("p.id = :cat" . $category->id)->setParameter("cat" . $category->id, $category->id);
			}
			$query = $query->orWhere("p.id = :cat" . $category->id)->setParameter("cat" . $category->id, $category->id);
		}
		
		return $query;
	}


	protected function createComponentVp()
	{
		$vp = new \CoreModule\Components\VisualPaginator;
		$pg = $vp->getPaginator();
		$pg->setItemsPerPage($this->page->itemsPerPage);
		$pg->setItemCount($this->getQueryBuilder()->select("COUNT(a.id)")->getQuery()->getSingleScalarResult());
		return $vp;
	}


}