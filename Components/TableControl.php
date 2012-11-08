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

use Venne;
use CmsModule\Content\SectionControl;
use BlogModule\Forms\BlogFormFactory;
use BlogModule\Forms\ContentFormFactory;
use DoctrineModule\Repositories\BaseRepository;

/**
 * @author pave
 */
class TableControl extends SectionControl
{

	/** @var BaseRepository */
	protected $blogRepository;

	/** @var BlogFormFactory */
	protected $formFactory;

	/** @var ContentFormFactory */
	protected $contentFormFactory;


	/**
	 * @param BaseRepository $blogRepository
	 * @param BlogFormFactory $formFactory
	 * @param ContentFormFactory $contentFormFactory
	 */
	public function __construct(BaseRepository $blogRepository, BlogFormFactory $formFactory, ContentFormFactory $contentFormFactory)
	{
		parent::__construct();

		$this->blogRepository = $blogRepository;
		$this->formFactory = $formFactory;
		$this->contentFormFactory = $contentFormFactory;
	}


	protected function createComponentTable()
	{
		$table = new \CmsModule\Components\Table\TableControl;
		$table->setTemplateConfigurator($this->templateConfigurator);
		$table->setRepository($this->blogRepository);
		$table->setPaginator(10);
		$table->enableSorter();

		$pageId = $this->entity->id;
		$table->setDql(function ($sql) use ($pageId) {
			$sql = $sql->andWhere('a.page = :page')->setParameter('page', $pageId);
			return $sql;
		});

		// forms
		$repository = $this->blogRepository;
		$entity = $this->entity;
		$form = $table->addForm($this->formFactory, 'Options', function () use ($repository, $entity) {
			return $repository->createNew(array($entity));
		});
		$contentForm = $table->addForm($this->contentFormFactory, 'Edit content');

		// navbar
		$table->addButtonCreate('create', 'Create new', $form, 'file');

		$table->addColumn('name', 'Name', '50%');

		$table->addActionEdit('edit', 'Options', $form);
		$table->addActionEdit('content', 'Content', $contentForm);
		$table->addActionDelete('delete', 'Delete');

		return $table;
	}


	public function render()
	{
		$this->template->render();
	}
}