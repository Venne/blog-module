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
use Doctrine\ORM\Mapping as ORM;
use CmsModule\Content\Entities\ElementEntity;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class BaseBlogEntity extends ElementEntity
{

	/**
	 * @var string
	 * @ORM\Column(type="integer")
	 */
	protected $itemsPerPage;

	/**
	 * @var \CmsModule\Content\Entities\RouteEntity[]
	 * @ORM\ManyToMany(targetEntity="\BlogModule\Entities\PageEntity")
	 * @ORM\JoinTable(
	 *       joinColumns={@ORM\JoinColumn(onDelete="CASCADE")},
	 *       inverseJoinColumns={@ORM\JoinColumn(onDelete="CASCADE")}
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
