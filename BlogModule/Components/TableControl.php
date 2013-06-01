<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Components;

use BlogModule\Forms\BlogFormFactory;
use BlogModule\Forms\ContentFormFactory;
use CmsModule\Administration\Components\AdminGrid\AdminGrid;
use CmsModule\Content\SectionControl;
use DoctrineModule\Repositories\BaseRepository;
use Grido\DataSources\Doctrine;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class TableControl extends SectionControl
{

	/** @var BaseRepository */
	protected $blogRepository;

	/** @var BlogFormFactory */
	protected $formFactory;


	/**
	 * @param BaseRepository $blogRepository
	 * @param BlogFormFactory $formFactory
	 */
	public function __construct(BaseRepository $blogRepository, BlogFormFactory $formFactory)
	{
		parent::__construct();

		$this->blogRepository = $blogRepository;
		$this->formFactory = $formFactory;
	}


	public function handleOn($id)
	{
		if (!$entity = $this->blogRepository->find($id)) {
			throw new BadRequestException;
		}

		$entity->route->published = TRUE;
		$this->blogRepository->save($entity);

		if (!$this->presenter->isAjax()) {
			$this->redirect('this');
		}

		$this['table']->invalidateControl('table');
		$this->presenter->payload->url = $this->link('this', array('id' => NULL));
	}


	public function handleOff($id)
	{
		if (!$entity = $this->blogRepository->find($id)) {
			throw new BadRequestException;
		}

		$entity->route->published = FALSE;
		$this->blogRepository->save($entity);

		if (!$this->presenter->isAjax()) {
			$this->redirect('this');
		}

		$this['table']->invalidateControl('table');
		$this->presenter->payload->url = $this->link('this', array('id' => NULL));
	}


	protected function createComponentTable()
	{
		$_this = $this;
		$admin = new AdminGrid($this->blogRepository);

		// columns
		$table = $admin->getTable();
		$table->setModel(new Doctrine($this->blogRepository->createQueryBuilder('a')
				->andWhere('a.page = :page')
				->setParameter('page', $this->entity->id)
		));
		$table->setTranslator($this->presenter->context->translator->translator);
		$table->addColumn('name', 'Name')
			->setSortable()
			->getCellPrototype()->width = '100%';
		$table->getColumn('name')
			->setFilter()->setSuggestion();

		// actions
		$table->addAction('on', 'On')
			->setCustomRender(function ($entity, $element) {
				if ((bool)$entity->route->published) {
					$element->class[] = 'disabled';
				};
				return $element;
			})
			->setCustomHref(function ($entity) use ($_this) {
				return $_this->link('on!', array($entity->id));
			})
			->getElementPrototype()->class[] = 'ajax';
		$table->addAction('off', 'Off')
			->setCustomRender(function ($entity, $element) {
				if (!(bool)$entity->route->published) {
					$element->class[] = 'disabled';
				};
				return $element;
			})
			->setCustomHref(function ($entity) use ($_this) {
				return $_this->link('off!', array($entity->id));
			})
			->getElementPrototype()->class[] = 'ajax';
		$table->addAction('edit', 'Edit')
			->getElementPrototype()->class[] = 'ajax';

		$repository = $this->blogRepository;
		$entity = $this->entity;
		$form = $admin->createForm($this->formFactory, 'Blog', function () use ($repository, $entity) {
			return $repository->createNew(array($entity));
		}, \CmsModule\Components\Table\Form::TYPE_FULL);

		$admin->connectFormWithAction($form, $table->getAction('edit'));

		// Toolbar
		$toolbar = $admin->getNavbar();
		$toolbar->addSection('new', 'Create', 'file');
		$admin->connectFormWithNavbar($form, $toolbar->getSection('new'));

		$table->addAction('delete', 'Delete')
			->getElementPrototype()->class[] = 'ajax';
		$admin->connectActionAsDelete($table->getAction('delete'));

		return $admin;
	}


	public function render()
	{
		$this->template->render();
	}
}
