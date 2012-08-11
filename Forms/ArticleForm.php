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

use DoctrineModule\Forms\Mapping\EntityFormMapper;
use Doctrine\ORM\EntityManager;
use AssetsModule\Managers\AssetManager;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class ArticleForm extends \CmsModule\Content\Form
{    

	public function create()
	{
		$this->addGroup();
		$this->addManyToMany('categories','Categories');
		$this->addContentEditor('notation', 'Notation');
		$this->addContentEditor('text', NULL, NULL, 20);
	}

}
