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

use CmsModule\Pages\Users\UserEntity;
use DoctrineModule\Forms\FormFactory;
use Venne\Forms\Form;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class BlogFormFactory extends FormFactory
{

	protected function getControlExtensions()
	{
		return array(
			new \DoctrineModule\Forms\ControlExtensions\DoctrineExtension(),
			new \CmsModule\Content\ControlExtension(),
			new \FormsModule\ControlExtensions\ControlExtension(),
			new \CmsModule\Content\Forms\ControlExtensions\ControlExtension(),
		);
	}


	/**
	 * @param Form $form
	 */
	public function configure(Form $form)
	{
		$route = $form->addOne('route');

		$group = $form->addGroup();
		$form->addText('name', 'Name');
		$route->setCurrentGroup($group);
		$route->addFileEntityInput('photo', 'Photo');
		$route->addManyToOne('author', 'Author')->setDisabled(TRUE);
		$form->addManyToMany('categories', 'Categories');
		$route->addDateTime('released', 'Release date')
			->addRule($form::FILLED);
		$route->addDateTime('expired', 'Expiry date');
		$route->addTextArea('notation', 'Notation');

		$route->setCurrentGroup($form->addGroup('Content'));
		$route->addContentEditor('text', NULL, NULL, 20);

		$form->addSaveButton('Save');
	}
}
