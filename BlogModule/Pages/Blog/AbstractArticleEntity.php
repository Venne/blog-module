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

use CmsModule\Content\Entities\ExtendedRouteEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
abstract class AbstractArticleEntity extends ExtendedRouteEntity
{

	/**
	 * @var AbstractCategoryEntity
	 * @ORM\ManyToMany(targetEntity="\BlogModule\Pages\Blog\CategoryEntity", cascade={"persist"})
	 */
	protected $categories;


	protected function startup()
	{
		parent::startup();

		$this->categories = new ArrayCollection;
	}


	/**
	 * @param \BlogModule\Pages\Blog\AbstractCategoryEntity $categories
	 */
	public function setCategories($categories)
	{
		$this->categories = $categories;
	}


	/**
	 * @return \BlogModule\Pages\Blog\AbstractCategoryEntity
	 */
	public function getCategories()
	{
		return $this->categories;
	}

}
