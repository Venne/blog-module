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
 * @Entity(repositoryClass="\DoctrineModule\Repositories\BaseRepository")
 * @Table(name="blogElement")
 * @DiscriminatorEntry(name="blogElement")
 */
class BlogEntity extends ElementEntity
{

	/**
	 * @var string
	 * @Column (type="integer")
	 */
	protected $itemsPerPage;

	/**
	 * @var \CmsModule\Content\Entities\RouteEntity
	 * @ManyToOne(targetEntity="\BlogModule\Entities\PageEntity")
	 * @JoinColumn(onDelete="CASCADE")
	 */
	protected $page;


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
	 * @param \CmsModule\Content\Entities\RouteEntity $page
	 */
	public function setPage($page)
	{
		$this->page = $page;
	}


	/**
	 * @return \CmsModule\Content\Entities\RouteEntity
	 */
	public function getPage()
	{
		return $this->page;
	}
}
