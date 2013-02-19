<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Elements;

use Venne;
use DoctrineModule\Repositories\BaseRepository;
use Venne\Forms\FormFactory;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class BlogElement extends \CmsModule\Content\Elements\BaseElement
{
	/**
	 * @var BaseRepository
	 */
	private $blogRepository;

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
	 * @param BaseRepository $blogRepository
	 */
	public function injectBlogRepository($blogRepository)
	{
		$this->blogRepository = $blogRepository;
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
		return get_class(new \BlogModule\Elements\Entities\BlogEntity());
	}


	public function getItems()
	{
		$query = $this->getQueryBuilder();
		$query->setMaxResults($this->getEntity()->itemsPerPage);
		$query->setFirstResult($this['vp']->getPaginator()->getOffset());
		$query->orderBy('a.released', 'DESC');

		return $query->getQuery()->getResult();
	}


	/**
	 * @return \Doctrine\ORM\QueryBuilder
	 */
	protected function getQueryBuilder()
	{
		$dql = $this->blogRepository->createQueryBuilder("a");

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


	public function render()
	{
		$this->template->render();
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


	public function processForm($form)
	{
		$this->getPresenter()->redirect('this');
	}
}
