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
use Venne\Forms\Form;
use DoctrineModule\Forms\FormFactory;

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
		$form->addGroup();
		$form->addText('name', 'Name');
		$form->addFileEntityInput('photo', 'Photo');
		$form->addManyToOne('author', 'Author');

		$form->addGroup('Dates');
		$form->addDateTime('released', 'Release date');
		$form->addDateTime('expired', 'Expiry date');

		if (!$form->data->page->getAutoNotation()) {
			$form->addGroup('Notation');
			if ($form->data->page->getNotationInHtml()) {
				$form->addContentEditor('rawNotation', 'Notation');
			} else {
				$form->addTextArea('rawNotation', 'Notation');
			}
		}

		$form->addSaveButton('Save');
	}
}