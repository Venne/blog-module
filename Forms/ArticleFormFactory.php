<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Forms;

use Venne;
use Venne\Forms\FormFactory;
use Venne\Forms\Form;
use DoctrineModule\Forms\Mappers\EntityMapper;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class ArticleFormFactory extends FormFactory
{

	/** @var EntityMapper */
	protected $mapper;


	/**
	 * @param EntityMapper $mapper
	 */
	public function __construct(EntityMapper $mapper)
	{
		$this->mapper = $mapper;
	}


	protected function getMapper()
	{
		return $this->mapper;
	}


	protected function getControlExtensions()
	{
		return array(
			new \DoctrineModule\Forms\ControlExtensions\DoctrineExtension(),
			new \CmsModule\Content\ControlExtension(),
		);
	}


	/**
	 * @param Form $form
	 */
	public function configure(Form $form)
	{
		$form->addGroup();
		$form->addManyToMany('categories', 'Categories');
		$form->addContentEditor('notation', 'Notation');
		$form->addContentEditor('text', NULL, NULL, 20);

		$form->addSubmit('_submit', 'Save');
	}
}
