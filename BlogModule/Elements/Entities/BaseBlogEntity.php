<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Elements\Entities;

use Venne;
use CmsModule\Content\Entities\ElementEntity;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class BaseBlogEntity extends ElementEntity
{

	/**
	 * @var string
	 * @Column (type="integer")
	 */
	protected $itemsPerPage;

	/**
	 * @var \CmsModule\Content\Entities\RouteEntity[]
	 * @ManyToMany(targetEntity="\BlogModule\Entities\PageEntity")
	 * @JoinTable(
	 *       joinColumns={@JoinColumn(onDelete="CASCADE")},
	 *       inverseJoinColumns={@JoinColumn(onDelete="CASCADE")}
	 *       )
	 */
	protected $pages;


	public function __construct()
	{
		$this->itemsPerPage = 5;
	}


	/**
	 * @param string $itemsPerPage
	 */
	public function setItemsPerPage($itemsPerPage)
	{
		$this->itemsPerPage = $itemsPerPage;
	}


	/**
	 * @return string
	 */
	public function getItemsPerPage()
	{
		return $this->itemsPerPage;
	}


	/**
	 * @param \CmsModule\Content\Entities\RouteEntity[] $pages
	 */
	public function setPages($pages)
	{
		$this->pages = $pages;
	}


	/**
	 * @return \CmsModule\Content\Entities\RouteEntity[]
	 */
	public function getPages()
	{
		return $this->pages;
	}
}
