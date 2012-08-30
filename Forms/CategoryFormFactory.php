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
class CategoryFormFactory extends FormFactory
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
		$form->addManyToOne("parent", "Parent");
		$form->addText("name", "Category name");

		$form->addSubmit('_submit', 'Save');
	}

}
