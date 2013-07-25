<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Pages\Blog\BlogElement;

use BlogModule\Pages\Blog\RouteRepository;
use CmsModule\Content\Elements\BaseElement;
use Venne\Forms\FormFactory;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class BlogElement extends BaseElement
{

	/** @var RouteRepository */
	private $routeRepository;

	/** @var TextFormFactory */
	protected $setupFormFactory;


	/**
	 * @param TextFormFactory $setupForm
	 */
	public function injectSetupForm(FormFactory $setupForm)
	{
		$this->setupFormFactory = $setupForm;
	}


	/**
	 * @param RouteRepository $routeRepository
	 */
	public function injectRouteRepository(RouteRepository $routeRepository)
	{
		$this->routeRepository = $routeRepository;
	}


	/**
	 * @return array
	 */
	public function getViews()
	{
		return array(
			'setup' => 'Edit element',
		) + parent::getViews();
	}


	/**
	 * @return string
	 */
	protected function getEntityName()
	{
		return get_class(new BlogEntity);
	}


	public function getItems()
	{
		$query = $this->getQueryBuilder()
			->join('a.route', 'r')
			->setMaxResults($this->getEntity()->itemsPerPage)
			->setFirstResult($this['vp']->getPaginator()->getOffset())
			->orderBy('r.released', 'DESC')
			->getQuery();

		$query->getResult();
		dump($query->getSQL());die();
	}


	/**
	 * @return \Doctrine\ORM\QueryBuilder
	 */
	protected function getQueryBuilder()
	{
		$dql = $this->routeRepository->createQueryBuilder('a');

		if (count($this->getEntity()->pages) > 0) {
			$ids = array();
			foreach ($this->getEntity()->pages as $page) {
				$ids[] = $page->id;
			}

			$dql = $dql->join('a.page', 'p');
			$dql = $dql->andWhere('p.id IN (:ids)')->setParameter('ids', $ids);
		}

		return $dql;
	}


	protected function createComponentVp()
	{
		$vp = new \CmsModule\Components\VisualPaginator;
		$pg = $vp->getPaginator();
		$pg->setItemsPerPage($this->getEntity()->itemsPerPage);
		$pg->setItemCount($this->getQueryBuilder()->select("COUNT(a.id)")->getQuery()->getSingleScalarResult());
		return $vp;
	}


	public function renderSetup()
	{
		echo $this['form']->render();
	}


	/**
	 * @return \Venne\Forms\Form
	 */
	protected function createComponentForm()
	{
		$form = $this->setupFormFactory->invoke($this->getEntity());
		$form->onSuccess[] = $this->processForm;
		return $form;
	}


	public function processForm()
	{
		$this->getPresenter()->redirect('this');
	}
}